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

function getbrowser() {

    $agent  = $_SERVER['HTTP_USER_AGENT'];
    $browser  = '';
    $browser_ver  = '';

    if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {
        $browser  = 'OmniWeb';
        $browser_ver   = $regs[2];
    }

    if (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $browser  = 'Netscape';
        $browser_ver   = $regs[2];
    }

    if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
        $browser  = 'Safari';
        $browser_ver   = $regs[1];
    }

    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
        $browser  = 'Internet Explorer';
        $browser_ver   = $regs[1];
    }

    if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
        $browser  = 'Opera';
        $browser_ver   = $regs[1];
    }

    if (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {
        $browser  = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
        $browser_ver   = $regs[1];
    }

    if (preg_match('/Maxthon/i', $agent, $regs)) {
        $browser  = '(Internet Explorer ' .$browser_ver. ') Maxthon';
        $browser_ver   = '';
    }
    if (preg_match('/360SE/i', $agent, $regs)) {
        $browser       = '(Internet Explorer ' .$browser_ver. ') 360SE';
        $browser_ver   = '';
    }
    if (preg_match('/SE 2.x/i', $agent, $regs)) {
        $browser       = '(Internet Explorer ' .$browser_ver. ') 搜狗';
        $browser_ver   = '';
    }

    if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
        $browser  = 'FireFox';
        $browser_ver   = $regs[1];
    }

    if (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {
        $browser  = 'Lynx';
        $browser_ver   = $regs[1];
    }

    if(preg_match('/Chrome\/([^\s]+)/i', $agent, $regs)){
        $browser  = 'Chrome';
        $browser_ver   = $regs[1];

    }

    if ($browser != '') {
        return ['browser'=>$browser,'version'=>$browser_ver];
    } else {
        return ['browser'=>'unknow browser','version'=>'unknow browser version'];
    }
}