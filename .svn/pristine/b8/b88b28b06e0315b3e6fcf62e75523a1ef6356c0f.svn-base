<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;
use Validator;
use App\Models\VistorMessage;

use App\Http\Resources\VistorMessageResourceCollection;

class VistorMessagesController extends BaseController
{
    public function __construct(){
        $this->middleware('checklogin', ['except' => ['index']]);
        $this->middleware('checkIsCustomerService', ['except' => ['index']]);
    }

    /**
     * 访客和客服的聊天记录
     * @param Request $request
     * @return VistorMessageResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, VistorMessage $vistorMessage){
        $mark =$request->input("mark"); //访客标识
        $service_id = (int)$request->input("service_id"); //客服ID
        $validator = Validator::make($request->all(), [
            'mark' => 'required',
            'service_id' => 'required|integer',
        ], [
            'mark.required' => '访客标识不能空',
            'service_id.required' => '请选择客服',
            'service_id.integer' => '客服参数错误',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'statusCode' => 41001], 401);
        }

        $sn = $vistorMessage->createSn($mark, $service_id);

        $messages = VistorMessage::where('sn',$sn)
            ->orderBy('created_at','desc')
            ->paginate(30);

        return new VistorMessageResourceCollection($messages);
    }
}
