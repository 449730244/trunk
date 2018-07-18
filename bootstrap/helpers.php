<?php
function json_data($message, int $statusCode = 0, int $code = 200){
    return response()->json(['message'=>$message,'statusCode'=>$statusCode], $code);
}

function avatar($avatar){
    if ($avatar){
        if (starts_with($avatar, '/')){
            return $avatar;
        }else{
            return '/'.$avatar;
        }

    }else{
        return '/chat/img/user.png';
    }
}

function getFilesize($num){
    $p = 0;
    $format='bytes';
    if($num>0 && $num<1024){
        $p = 0;
        return number_format($num).' '.$format;
    }
    if($num>=1024 && $num<pow(1024, 2)){
        $p = 1;
        $format = 'KB';
    }
    if ($num>=pow(1024, 2) && $num<pow(1024, 3)) {
        $p = 2;
        $format = 'MB';
    }
    if ($num>=pow(1024, 3) && $num<pow(1024, 4)) {
        $p = 3;
        $format = 'GB';
    }
    if ($num>=pow(1024, 4) && $num<pow(1024, 5)) {
        $p = 3;
        $format = 'TB';
    }
    $num /= pow(1024, $p);
    return number_format($num, 2).' '.$format;
}