<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use App\Exceptions\InvalidRequestException;
use Auth;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TeamResourceCollection;
use App\Models\Team;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('checklogin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //var_dump(Auth::user()->id);
        return redirect('chat/index.html');
    }

    public function test(){
       // throw new InvalidRequestException('err', 12325, 401);
        return new TeamResourceCollection(Team::where('user_id',2)->get());
    }

}
