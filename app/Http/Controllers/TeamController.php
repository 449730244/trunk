<?php
/**
 * 分组管理
 * Author: lfq
 * Date: 2018/7/5
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamUser;
// Use App\Http\Resources\TeamResourceCollection;
// Use App\Http\Resources\UserResourceCollection;
class TeamController extends BaseController
{
    /**
     * 信息返回
     * $code:     0：代表返回失败1：代表返回成功
     * @return json
     */
    public function Api($msg='',$code=0,$data=array()){
        $ar=array(
            'msg'=>$msg,
            'code'=>$code,
            'data'=>$data
        );
        echo json_encode($ar);
        exit;
    }
    /**
     * 获取在线用户 暂时不用获取
     */

    // public function getIslogin()
    // {
    //     $arr = array();

    //     return $this->Api('请求成功。',1,$arr);  
    // }
    /**
     * 获取用户信息
     */

    public function user(Request $request)
    {
        $suser_id= $request->input('id');
        $info = User::SearchUserId($suser_id)->get();
        foreach ($info as $key => $value) {
            $info[$key]['avatar'] = avatar($value['avatar']);
        }
        $ar = json_decode(json_encode($info),true);
        return $this->Api('请求成功。',1,$ar);  
       
    }

    
    /**
     * 用户搜索
     */

    public function searchUsers(Request $request)
    {
        $keyword = $request->input('keyword');
        $user_id = Auth::user()->id;
        if (!empty($keyword)) {
            $info = User::where('name','like','%'.$keyword.'%')->where('id','!=',$user_id)->get();
        }else{
            $info = User::where('id','!=',$user_id)->get();
        }
        foreach ($info as $key => $value) {
            $info[$key]['avatar'] = avatar($value['avatar']);
        }
        $ar = json_decode(json_encode($info),true);
        return $this->Api('请求成功。',1,$ar);  
       
    }
    /**
     * 分组列表页
     */

    public function index()
    {
        $arr = array();
        $user_id = Auth::user()->id;

        $friends = User::all();
        $friends_ar = json_decode(json_encode($friends),true);
        $tooar=array();
        foreach ($friends_ar as $k => $v) {
            $tooar[]=array(
                "user_id"=>$v['id'],
                "nickname"=>$v['name'],
                "avatar"=>avatar($v['avatar']),
                "team_owner"=>null,
                "team_name"=>"",
                "team_id"=>null,
            );
        }
        $uar[]=array(
            'id'=>null,
            'name'=>'所有人',
            'data'=>$tooar
        );
        $team_list = Team::searchTeamUserId($user_id)->get();
        $team_list = json_decode(json_encode($team_list),true);
        if (!empty($team_list)) {
            foreach($team_list as $v){
                $lid=TeamUser::where(['user_id'=>$user_id,'team_id'=>$v['id']])->get();
                $lid = json_decode(json_encode($lid),true);
                $lid_ar = array();
                foreach ($lid as $key => $val) {
                    $suser_id = $val['b_user_id'];
                    $utin = User::SearchUserId($suser_id)->first();
                    $lid_ar[]=array(
                        "user_id"=>$val['b_user_id'],
                        "nickname"=>$utin->name,
                        "avatar"=>avatar($utin->avatar),
                        "team_owner"=>$user_id,
                        "team_name"=>$v['name'],
                        "team_id"=>$v['id'],
                    );
                }
                $uar[]=array(
                    'team_id'=>$v['id'],
                    'name'=>$v['name'],
                    'data'=>$lid_ar
                );
            }
        }
        $arr['team_list'] = $uar;
        $arr['user_info'] = json_decode(json_encode(Auth::user()),true);
        return $this->Api('请求成功。',1,$arr);  
    }
    /**
     * 添加新的分组
     */
    public function add_team_name(Request $request)
    {
        $data['name']=trim($request->input('name'));
        if (empty($data['name'])) return $this->Api('分组名称不能为空。');  
        $data['user_id'] = Auth::user()->id;
        
        $re = Team::create($data);
        if (!$re) {
            return $this->Api('网络异常，请尝试重新提交。');  
        }
        return $this->Api('添加成功。',1);  
    }
    /**
     * 修改分组
     */
    public function renameTeam(Request $request)
    {
        $id=$request->input('teamId');
        $data['name']=trim($request->input('name'));
        if (empty($data['name'])) return $this->Api('分组名称不能为空。');  
        $team = Team::find($id);
        $team->name = $request->input('name');
        $team->save();
        
        return $this->Api('修改成功。',1);  
    }

    /**
     * 删除分组
     */ 
    public function removeTeam(Request $request)
    {
        $id=$request->input('teamId');
        $team = Team::find($id);
        $team->delete();
        return $this->Api('删除分组成功。',1); 
    }
    /**
     * 添加用户分组
     */ 
    public function addTeamUser(Request $request)
    {
        $data['team_id']=$request->input('teamId');
        $data['b_user_id']=$request->input('teamUser');
        $data['user_id'] = Auth::user()->id;
        $current_teamId = $request->input('current_teamId');
        $details=TeamUser::where(['team_id'=>$data['team_id'],'b_user_id'=>$data['b_user_id']])->first();
        if($details){
            return $this->Api('该成员已经在当前分组下面'); 
        }else{
            TeamUser::where(['user_id'=>$data['user_id'],'b_user_id'=>$data['b_user_id']])->delete();
            TeamUser::create($data);

            return $this->Api('操作成功。',1); 
        }
    }
    /**
     * 用户移除分组
     */
    public function leaveTeam (Request $request)
    {
      
        $teamId = $request->input('teamId');
        $teamUser = $request->input('teamUser');
        $cc = TeamUser::where(['team_id'=>$teamId,'b_user_id'=>$teamUser])->delete();
        return $this->Api('移除成功。',1); 
    }
    /**
     * 编辑个人资料
     */
    public function avatar(Request $request)
    {
        $fileTypes = array('image/png','image/gif','image/jpg','image/jpeg');

        if (!$request->hasFile('file')) {
            return $this->Api('上传头像不能为空！');
        }
        // 获取表单上传文件 例如上传了001.jpg
        $file = $request->file('file');

        
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
        //判断文件上传过程中是否出错
       // echo  ($file->getClientSize() ) . PHP_EOL;
        if (!in_array($file->getMimeType(), $fileTypes)) {
            // 保存文件
            return $this->Api('图片格式不合法');
        }

        if (!$file->isValid()) {
            return $this->Api('图片上传出错！');
        }
        $destPath = ('uploads/logo');
        if (!file_exists($destPath))
            mkdir($destPath, 0755, true);
        //$filename = $file->getClientOriginalName();
        $filename = date('YmdHis').".".$file->getClientOriginalExtension();
        if (!$file->move($destPath, $filename)) {
            $msessage = ('保存文件失败！');
            return $this->Api('头像保存失败！');
        }
        $imgpath = '/'.$destPath.'/'.$filename;
        $uid = Auth::user()->id;
        User::where('id', $uid)->update(array('avatar' => $imgpath));
        return $this->Api('修改头像成功!',1);

        }
    }

}
