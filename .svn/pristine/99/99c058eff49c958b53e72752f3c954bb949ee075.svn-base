<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Http\Request;

class InvalidRequestException extends Exception
{
    protected $statusCode;

    public function __construct(string $message = "", int $statusCode = 0, int $code = 400)
    {
        parent::__construct($message, $code);

        $this->statusCode = $statusCode;
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            // json() 方法第二个参数就是 Http 返回码
            return response()->json(['message' => $this->message, 'statusCode'=>$this->statusCode], $this->code);
        }

        return view('error', ['msg' => $this->message]);
    }
}
