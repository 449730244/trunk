<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdvertisingSpace;

class ApiController extends Controller
{
    public function AdvertisingSpaces(){
        $list = AdvertisingSpace::query()->get(['id','name as text']);
        return response()->json($list);
    }
}
