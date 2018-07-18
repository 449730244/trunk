<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HtmlController extends BaseController
{
    public function __construct()
    {
        $this->middleware('checklogin', ['except' => ['formtoken']]);
    }
    public function groupBox(Request $request){
        $userlist = User::where('id','!=', $request->user()->id)->orderBy('created_at','desc')->get();
        return view('chat.create_group_box', ['userlist' => $userlist]);
    }

    public function formtoken(){
        return csrf_token();
    }

    public function forwardBox(User $user, Request $request){

        $groups = $request->user()->userGroups;
        $users = $user->userListCache();

        return view('chat.groupsAndUsers',['groups'=>$groups, 'users'=>$users]);
    }
}
