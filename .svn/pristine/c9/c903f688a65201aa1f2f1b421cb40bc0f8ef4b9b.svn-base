<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GatewayClient\Gateway;
use App\Models\Group;

class HomeController extends BaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()    {

        return redirect('chat/index.html');
    }

    public function test(){

        //$html = '👏gfgfdgfg🤑😃';
        //echo $html;exit;
        $group = Group::findOrFail(11);
       // $users = $group->users->toArray();
//print_r($users);
       // $user_list = \App\Models\User::query()->select(['id','name','avatar','username'])->whereIn('id', [1,2,3,4])->get();
       // echo json_encode(new \App\Http\Resources\UserResourceCollection($user_list));
//print_r($user_list);
       // $user_list = \App\Models\Group::with(['users'=>function($query){
         //   return $query->whereIn( 'user_id' , [1,2] ) ;
       // }])->where('id',11)->get();
       // return new \App\Http\Resources\GroupResource($user_list);
      //  $group = \App\Models\Group::find(18);

        return $group->users->pluck('id')->toArray();
    }

    public function senttogroup(){

    }



}
