<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FileResource;
use App\Http\Resources\FileResourceCollection;
use App\Exceptions\InvalidRequestException;
use App\Handlers\ImageUploadHandler;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\Message;
use App\Models\MessageQueue;
use App\Models\User;
use Validator;

class FileController extends BaseController
{


    //获取文件列表
    public function file_list(Request $request)
    {
        // return new FileResourceCollection(File::all());
        //   $where  =   is_array($request->input('search'))?'':'';
        $userid =   $request->user_id;
        $search = $request->input('search');
        if (empty($search)) {
            $list = File::where('user_id',$userid)->orderBy('id', 'desc')->get();
        } else {
            $list = File::where('name', 'like', '%' . $search . '%')
                ->orderBy('id', 'desc')
                ->take(15)
                ->get();
        }
        return new FileResourceCollection($list);
    }

    /**
     * 文件上传
     */
    public function file_upload(Request $request)
    {


        /*        $path = $request->file('file')->store('file/'.$request->user()->id, 's3' );*/
        $fileTypes = array('audio/mpeg', 'text/html', 'video/mp4', 'application/pdf', 'application/msword', 'text/plain', 'image/jpeg', 'image/png');

        if (!$request->hasFile('file')) {
            return $message = ('上传文件为空！');
        }

        $file = $request->file('file');
        //判断文件上传过程中是否出错
        // echo  ($file->getClientSize() ) . PHP_EOL;
        if (!in_array($file->getMimeType(), $fileTypes)) {
            // 保存文件
            return $message = '文件格式不合法!' . $file->getMimeType();
        }

        if (!$file->isValid()) {
            return $message = ('文件上传出错！');
        }
        $destPath = (public_path() . "/upload/file/");
        if (!file_exists($destPath))
            mkdir($destPath, 0755, true);
        $filename = $file->getClientOriginalName();

        $newname = date('Ymdhis') . '_' . $filename;
        if (!$file->move($destPath, $newname)) {
            $msessage = ('保存文件失败！');
        }
        //上传成功后写入数据库
        $data = [
            'user_id' => $request->input('user_id'),
            'to_user_id' => $request->input('to_user_id'),
            'group_id' => $request->input('to_user_id'),
            'name' => $filename,
            'type' => $file->getClientMimeType(),
            'size' => $file->getClientSize(),
            'url' => $newname,
        ];
        $save = File::create($data);
        FileResource::withoutWrapping();
        return new FileResource($save);
    }

    public function imgUpload(Request $request, ImageUploadHandler $uploader)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,bmp,png,gif',

        ], [
            'image.required' => '没有上传图片',
            'image.mimes' => '图片格式必须是jpeg,bmp,png,gif'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => '图片格式错误或没有上传图片', 'statusCode' => 41001], 401);
        }
        $type = $request->type;
        $group_id = null;
        $to_user_id = null;
        if (in_array($type, ['user', 'group']) && $request->id) {
            if ($type == 'user') {
                $to_user_id = $request->id;
                $user = User::findOrFail($to_user_id);
            } else {
                $group_id = $request->id;
                $group = Group::findOrFail($group_id);
            }

        } else {
            return response()->json(['message' => '没有选择发送对象', 'statusCode' => 41002], 401);
        }

        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->image) {
            // 保存图片到本地
            $result = $uploader->save($file, 'images', \Auth::id());
            // 图片保存成功的话
            if ($result) {

                $data = [
                    'user_id' => $request->user()->id,
                    'to_user_id' => $to_user_id,
                    'group_id' => $group_id,
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getClientSize(),
                    'url' => $result['path'],
                ];
                $save = File::create($data);


                /*$messageQueue = new MessageQueue();

                $data = [
                    'user_name' => $request->user()->name,
                    'headimg' => $request->user()->avatar,
                    'content' => '<img src="'.$result['path'].'">',
                    'file_id' => $save->id,
                    'file_size' => $save->size,
                    'file_url' => $save->url,
                    'file_type' => $save->type,
                ];
                $contents = json_encode($data);

                if ($type == 'group'){
                    $groupMessage  = new GroupMessage();
                    $groupMessage->user_id  = $request->user()->id;
                    $groupMessage->group_id = $group_id;
                    $groupMessage->content  = $contents;
                    $groupMessage->save();
                    //添加消息队列
                    $messageQueue->saveQueue($request->user()->id, $group_id, $group->name,$contents,$type);
                    //推送消息
                    $send_data = [
                        'type'     => 'group',
                        'user_id'  => $request->user()->id,
                        'group_id' => $group_id,
                        'content'  => $data
                    ];
                    $this->sendToGroup($group->group_name,$send_data);
                }else{

                    $message  = new Message();
                    $message->user_id  = $request->user()->id;
                    $message->to_user_id = $to_user_id;
                    $message->content  = $contents;
                    $message->save();
                    //推送数据封装
                    $send_data = [
                        'type'     => $type,
                        'to_user_id' => $to_user_id,
                        'content'  => $data,
                        'updated_at' => date('Y-m-d H:i:s',time()),
                        'msg_id'   => $message->id
                    ];

                    //添加消息队列
                    $messageQueue->saveQueue($request->user()->id, $to_user_id,$user->name,$contents,$type);
                    //推送消息
                    $this->sendToUid([$to_user_id],$send_data);
                }*/

                return new FileResource($save);
            }
        } else {
            return response()->json(['message' => '上传失败', 'statusCode' => 41003], 401);
        }

    }

    /**
     * 文件移动
     */
    public function move_file($oldpath, $newpath)
    {
        //Storage::copy('old/file1.jpg', 'new/file1.jpg');
        Storage::move($oldpath, $newpath);
    }

    /**
     * 下载文件
     */
    public function download_file(Request $request)
    {
        $fileid = $request->input('file_id');
        $userid = $request->input('user_id');

        //判断文件是否为收发者  否则不能下载
        if ($fileid && $userid) {
            $file = File::where(['user_id' => $userid, 'id' => $fileid])
                ->orWhere(
                    function ($query) use ($userid, $fileid) {
                        $query->where(['to_user_id' => $userid, 'id' => $fileid]);
                    })
                ->first();
            $url = $file->url ? $file->url : $file->name;
            $filepath = public_path('/upload/file/')   . $url;
            //判断文件是否存在
            $exists = Storage::disk('local')->exists($file->url);
            if ($exists) {
                return response()->download($filepath, $file->name);
            } else {
                throw new InvalidRequestException('文件已删除', '404', '404');
            }
        }
        return json_encode(['error' => 201, 'msg' => '请登录后重试']);
    }


    /**
     * 文件删除
     */
    public function del_file(Request $request)
    {
        $user_id = $request->input('user_id');
        $fileid = $request->input('file_id');
        $file = File::find($fileid);
        if ($file->id && $file->user_id == $user_id) {
            File::destroy($fileid);
            Storage::delete($file->url);
            return json_encode(['error' => 0, 'msg' => '删除成功']);
        }
        return json_encode(['error' => 1, 'msg' => '删除失败']);
    }

    public function test()
    {

    }
}
