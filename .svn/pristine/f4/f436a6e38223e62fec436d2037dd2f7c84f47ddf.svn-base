<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/4
 * Time: 18:03
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Traits\GatewayClient;

class BaseController extends Controller
{
    use GatewayClient;

    public function __construct()
    {
        $this->middleware('checklogin');


    }

}