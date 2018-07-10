<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
Use App\Http\Resources\UserResourceCollection;
use Auth;
use App\Exceptions\InvalidRequestException;

class UsersController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('checklogin', ['except' => ['logout']]);
    }

    public function index(User $user){

        return new UserResourceCollection($user->userListCache());
    }

    public function me(){
        return new UserResource(Auth::user());
    }

    /**
     * 用户ID绑定服务端clent_id
     */
    public function bind(Request $request)
    {
        if($request->ajax())
        {
            $client_id = $request->input('client_id');

            $user_id = Auth::user()->id;

            $this->bindUid($client_id, $user_id);

            $data = [
                'user_id' => $user_id,
                'name' => Auth::user()->name,
                'avatar' => Auth::user()->avatar ? '/uploads/'. Auth::user()->avatar : '/chat/img/avatar.png',
                'csrf_token' => csrf_token(),
            ];
            return response()->json($data);

        }else{
            throw new InvalidRequestException('非法请求',10001, 410);
        }
    }


    public function logout(){
        Auth::logout();
        return json_data('退出成功', '0','200');
    }
    /**
     * 重置密码
     */
    public function resetPssword(Request $request){
        $oldpassword = $request->input('oldpassword');
        $newpassword = $request->input('newpassword');
        $renewpassword = $request->input('renewpassword');
        if (mb_strlen($oldpassword) < 6 || mb_strlen($newpassword) < 6) return json_encode(array('msg'=>'密码长度至少6位。','code'=>0)); 
        $id = Auth::user()->id;
        $rel_bool = app('hash')->check($oldpassword, Auth::user()->makeVisible('password')->password);
        if (!$rel_bool) return json_encode(array('msg'=>'旧密码输入错误！','code'=>0)); 
        if ($newpassword != $renewpassword) return json_encode(array('msg'=>'两次输入的新密码不一致','code'=>0)); 
        if ($oldpassword == $newpassword)  return json_encode(array('msg'=>'新旧密码相同,无需修改！','code'=>0)); 
        $user = User::find($id);
        $user->password = bcrypt($newpassword);
        $user->save();  
        return json_encode(array('msg'=>'设置新密码成功。','code'=>1));           
    }

    
}
