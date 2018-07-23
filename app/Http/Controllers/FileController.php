<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Resources\FileResource;
use App\Http\Resources\FileResourceCollection;
use App\Models\File;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\GroupMessage;
use App\Models\Message;
use App\Models\MessageQueue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Validator;

class FileController extends BaseController
{


    //获取文件列表
    public function file_list(Request $request)
    {
        // return new FileResourceCollection(File::all());
        //   $where  =   is_array($request->input('search'))?'':'';
        $userid = $request->user_id;
        $search = $request->input('search');
        $list = File::where('name', 'like', '%' . $search . '%')
            ->where(function ($query) use ($userid) {
                $query->where('user_id','=' ,$userid)->orWhere('to_user_id', $userid);
            })
            ->orderBy('id', 'desc')
            ->paginate(12);

        return new FileResourceCollection($list);
    }


    /**
     * 群组文件列表
     */
    public function groupFiles(Request $request){

           $data   =   DB::table("group_users")
            ->rightJoin('files','group_users.group_id','=','files.group_id')
            ->where('group_users.user_id',$request->userid)
            ->where('files.name','like','%'.$request->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(12);

        $groups =   Group::all();
        $group_array=[];
        foreach ($groups as $g){
            $group_array[$g['id']]=$g->name;
        }

        if($data->count()>0){

            foreach ($data as $k=>$v){
                if(!empty($v->group_id)){
                    $v->group_name  =  $group_array[$v->group_id];

                }
            }
        }
        return  response()->json($data) ;
    }



    /**
     * 文件上传
     */
//    public function file_upload(Request $request)
//    {
//
//
//        /*        $path = $request->file('file')->store('file/'.$request->user()->id, 's3' );*/
//        $fileTypes = array('audio/mpeg', 'text/html', 'video/mp4', 'application/pdf', 'application/msword', 'text/plain', 'image/jpeg', 'image/png');
//
//        if (!$request->hasFile('file')) {
//            return $message = ('上传文件为空！');
//        }
//
//        $file = $request->file('file');
//        //判断文件上传过程中是否出错
//        // echo  ($file->getClientSize() ) . PHP_EOL;
//        if (!in_array($file->getMimeType(), $fileTypes)) {
//            // 保存文件
//            return $message = '文件格式不合法!' . $file->getMimeType();
//        }
//
//        if (!$file->isValid()) {
//            return $message = ('文件上传出错！');
//        }
//        $destPath = (public_path() . "/upload/file/");
//        if (!file_exists($destPath))
//            mkdir($destPath, 0755, true);
//        $filename = $file->getClientOriginalName();
//
//        $newname = date('Ymdhis') . '_' . $filename;
//        if (!$file->move($destPath, $newname)) {
//            $msessage = ('保存文件失败！');
//        }
//        //上传成功后写入数据库
//        $data = [
//            'user_id' => $request->input('user_id'),
//            'to_user_id' => $request->input('id'),
//            'group_id' => $request->input('to_user_id'),
//            'name' => $filename,
//            'type' => $file->getClientMimeType(),
//            'size' => $file->getClientSize(),
//            'url' => $newname,
//        ];
//        $save = File::create($data);
//        FileResource::withoutWrapping();
//        return new FileResource($save);
//    }

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
        if (in_array($type, ['user', 'group','customer']) && $request->id) {
            /*if ($type == 'user') {
                $to_user_id = $request->id;
                $user = User::findOrFail($to_user_id);
            } elseif ($type == 'group'){
                $group_id = $request->id;
                $group = Group::findOrFail($group_id);
            }*/

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
                    //'user_id' => $request->user()->id,
                    // 'to_user_id' => $to_user_id,
                    //  'group_id' => $group_id,
                    //  'name' => $file->getClientOriginalName(),
                    //  'type' => $file->getClientMimeType(),
                    // 'size' => $file->getClientSize(),
                    'url' => $result['path'],
                ];
                //$save = File::create($data);


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

                return response()->json(['data' => $data], '201');
            }
        } else {
            return response()->json(['message' => '上传失败', 'statusCode' => 41003], 401);
        }

    }

    public function fileUpload(Request $request, ImageUploadHandler $uploader)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:pdf,txt,zip,rar,doc,xsl,docx,jpeg,gif,bmp,jpg,png',
        ], [
            'file.required' => '没有上传文件',
            'file.mimes' => '文件格式必须是pdf,txt,zip,rar,doc,xsl,docx,jpeg,gif,bmp,jpg,png'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => '文件格式错误或没有上传文件', 'statusCode' => 41001], 401);
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
        if ($file = $request->file) {
            // 保存图片到本地
            $result = $uploader->save_file($file, 'files', \Auth::id());
            // 图片保存成功的话
            if ($result) {

                $data = [
                    'user_id' => $request->user()->id,
                    'to_user_id' => $to_user_id,
                    'group_id' => $group_id,
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientOriginalExtension(),//文件后綴
                    'size' => getFilesize($file->getClientSize()),
                    'url' => $result['path'],
                    'updated_at' => date('Y-m-d H:i:s', time()),
                    'show_time'  => date('H:i',time())
                ];
                $save = File::create($data);

                $messageQueue = new MessageQueue();

                $data = [
                    'user_name' => $request->user()->name,
                    'headimg' => avatar($request->user()->avatar),
                    'content' => '[文件]',
                    'file_id' => $save->id,
                    'file_size' => $save->size,
                    'file_type' => $save->type,
                    'file_name' => $save->name,
                ];
                $contents = json_encode($data);

                if ($type == 'group') {
                    $groupMessage = new GroupMessage();
                    $groupMessage->user_id = $request->user()->id;
                    $groupMessage->group_id = $group_id;
                    $groupMessage->content = $contents;
                    $groupMessage->save();
                    //添加消息队列
                    $messageQueue->saveGroupQueue($request->user()->id, $group_id, $group->name, $contents, $type);
                    //推送消息
                    $send_data = [
                        'type' => 'group',
                        'user_id' => $request->user()->id,
                        'group_name' => $group->name,
                        'group_id' => $group_id,
                        'content' => $data,
                        'updated_at' => date('Y-m-d H:i:s', time()),
                        'show_time'  => date('H:i',time()),
                        'msg_id' => $groupMessage->id,
                    ];
                    $this->sendToGroup($group->group_name, $send_data);
                } else {
                    $message = new Message();
                    $message->user_id = $request->user()->id;
                    $message->to_user_id = $to_user_id;
                    $message->content = $contents;
                    $message->save();
                    //推送数据封装
                    $send_data = [
                        'type' => $type,
                        'user_id' => $request->user()->id,
                        'user_name' => $request->user()->name,
                        'to_user_id' => $to_user_id,
                        'content' => $data,
                        'updated_at' => date('Y-m-d H:i:s', time()),
                        'show_time'  => date('H:i',time()),
                        'msg_id' => $message->id
                    ];

                    //添加消息队列
                    $messageQueue->saveUserQueue($request->user()->id, $to_user_id, $user->name, $contents, $type);
                    //推送消息
                    $this->sendToUid([$to_user_id], $send_data);
                }

                return response()->json($send_data);

            } else {

                return response()->json(['message' => '上传失败', 'statusCode' => 41003], 401);
            }

        } else {
            return response()->json(['message' => '上传失败', 'statusCode' => 41003], 401);
        }

    }


    /**
     * 文件资源返回
     */
    public function returnResource(Request $request)
    {
        $filepath = $request->input('path');;
        return response()->download(public_path($filepath));
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
            $filehas = File::find($fileid);
            if(empty($filehas)){return response()->json(['message' => '文件已删除', 'statusCode' => '40002',], 200);}

            $file = File::where(['id' => $fileid])
                ->where(function ($query) use ($userid) {$query
                ->orWhere(['to_user_id' => $userid, 'user_id' => $userid]);})
                ->first();

            //群文件判断
            if (empty($file)) {
                $file =  GroupUser::where(['user_id' => $userid, 'group_id' => $filehas->group_id])->first() ;
                if (empty($file)) {
                    return response()->json(['message' => '您没有下载权限', 'statusCode' => '40002',], 200);
                }
            }

            $filepath = !empty($file) ? public_path($filehas->url) : '';
            //判断文件是否存在
            $exists = !empty($filepath) ? file_exists($filepath) : false;
            if ($exists) {
                return response()->json(['statusCode' => 0, 'message' => $filehas->url]);
            } else {
                //文件不存时删除记录
                $del = $filehas->user_id == $userid ? File::destroy($fileid) : "0";
                return response()->json(['message' => '找不到对应文件', 'statusCode' => '40004','del'=>$del], 200);
            }
        }
        return response()->json(['statusCode' => 20001, 'message' => '请登录后重试'], 201);
    }


    /**
     * 文件删除
     */
    public function del_file(Request $request)
    {
        $user_id = $request->input('user_id');
        $fileid = $request->input('file_id');
        $file = File::find($fileid);
        if (!empty($file) && $file->id && $file->user_id == $user_id) {
            File::destroy($fileid);
          //  unlink(public_path($file->url));//文件删除暂定
            return json_encode(['statusCode' => 0, 'message' => '删除成功']);
        }
        return json_encode(['statusCode' => 1, 'message' => '删除失败']);
    }

    public function test()
    {
        return (File::where('user_id', 3)->firstorfail());
    }
}
