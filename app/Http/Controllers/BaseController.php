<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/4
 * Time: 18:03
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GatewayClient\Gateway;

class BaseController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '192.168.1.240:97';


    }

}