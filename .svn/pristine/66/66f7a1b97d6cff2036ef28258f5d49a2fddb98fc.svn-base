<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HtmlController extends Controller
{
    public function groupBox(){
        $userlist = User::all();
        return view('chat.create_group_box', ['userlist' => $userlist]);
    }
}
