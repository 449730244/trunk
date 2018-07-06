<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FileResource;
use App\Http\Resources\FileResourceCollection;

class FileController extends Controller
{


    //获取文件列表
    public function file_list(Request $request){
       // return new FileResourceCollection(File::all());
     //   $where  =   is_array($request->input('search'))?'':'';
        $search =   $request->input('search');
        if(empty($search)){
            $list   =File::all();
        }else{
            $list   =   File::where('name','like','%'.$search.'%')
                ->orderBy('updated_at', 'desc')
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
        $fileTypes = array('audio/mpeg', 'text/html', 'video/mp4', 'application/pdf', 'application/msword', 'text/plain', 'image/jpeg');

        if (!$request->hasFile('file')) {
            return $message = ('上传文件为空！');
        }

        $file = $request->file('file');
        //判断文件上传过程中是否出错
       // echo  ($file->getClientSize() ) . PHP_EOL;
        if (!in_array($file->getMimeType(), $fileTypes)) {
            // 保存文件
            return $message = '文件格式不合法!';
        }

        if (!$file->isValid()) {
            return $message = ('文件上传出错！');
        }
        $destPath = ('../storage/app/file');
        if (!file_exists($destPath))
            mkdir($destPath, 0755, true);
        $filename = $file->getClientOriginalName();

        if (!$file->move($destPath, $filename)) {
            $msessage = ('保存文件失败！');
        }
        //上传成功后写入数据库
        $data   =   [
          'user_id'=>$request->input('user_id'),
            'to_user_id'=>$request->input('to_user_id'),
            'group_id'=>$request->input('to_user_id'),
            'name'=>$filename,
            'type'=>$file->getClientMimeType(),
            'size'=>$file->getClientSize(),
            'url'=>url('download_file'),
        ];
     //   File::saving();
        $message = ('文件上传成功！');

        return $message;
    }


    /**
     * 文件移动
     */
    public function move_file($oldpath,$newpath)
    {
        //Storage::copy('old/file1.jpg', 'new/file1.jpg');
        Storage::move($oldpath, $newpath);
    }

    /**
     * 下载文件
     */
    public function download_file($name = '2016112710069.jpg', $newname = '')
    {
        //download 方法可用于生成强制用户浏览器下载给定路径文件的响应。
        //download 方法接收一个文件名作为第二个参数用于决定用户下载时看到的文件名。
        //最后，你可以传递一个 HTTP 请求头数组作为该方法的第三个参数：
        $file = storage_path() . '/app/file/' . $name;
        //判断文件是否存在
        $exists = Storage::disk('local')->exists($name);
        return $exists ? response()->download($file, empty($newname) ? $name : $newname) : '文件已删除';
    }


    /**
     * 文件删除
     */
    public function destroy($fileid)
    {
        File::destroy($fileid);
        Storage::delete($file);

        // Storage::delete(['file1.jpg', 'file2.jpg']);
    }
}
