<?php
function json_data($message, int $statusCode = 0, int $code = 200){
    return response()->json(['message'=>$message,'statusCode'=>$statusCode], $code);
}