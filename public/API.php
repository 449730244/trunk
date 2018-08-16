<?php

const TOKEN = 'API';//请咨询接口提供者
//模拟前台请求服务器api接口

getDataFromServer();

function getDataFromServer()
{
    //时间戳
    $timeStamp = time();
    //随机数
    $randomStr = createNonceStr();
    //生成签名
    $signature = arithmetic($timeStamp, $randomStr);

    /**
    // 获取token
    $url = "http://c.com/gettoken?";
    $data   =   [
        'timestamp'=>$timeStamp,
        'randomstr'=>$randomStr,
        'signature'=>$signature
    ];
    $result = request_post($url,$data);
     **/

    /**
     //返回用户群组列表 system 默认为系统消息

    $url = "http://c.com/getuserlist?";
    $data   =   [
        'token'=>'yURrhwwDTSu2dHtJNhoG0bMXHafR5CXv',
    ];
     **/
    //返回用户群组列表 system 默认为系统消息

    $url = "http://c.com/radio?";
    $data   =   [
        'token'=>'AgkzO858zavsHWdSsA8cu6QSEBI6hcpn',
        'user'=>1,//传入用户id int
        'to_user'=>[5,2,3],//对方id   array
        'to_group'=>'',//群组id可以为空 int
        'message'=>'1231231231',//消息 string
    ];
    $result = request_post($url,($data));
    var_dump($result);
}

//curl模拟请求。
function request_post($url , $param) {
    if (empty($url) || empty($param)) {
        return false;
    }



    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    var_dump($data) ;
}

//随机生成字符串

function createNonceStr($length = 8)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return "z" . $str;
}

/**
 * @param $timeStamp 时间戳
 * @param $randomStr 随机字符串
 * @return string 返回签名
 */

function arithmetic($timeStamp, $randomStr)
{
    $arr['timeStamp'] = $timeStamp;
    $arr['randomStr'] = $randomStr;
    $arr['token'] = TOKEN;
    //按照首字母大小写顺序排序
    sort($arr, SORT_STRING);
    //拼接成字符串
    $str = implode($arr);
    //进行加密
    $signature = sha1($str);
    $signature = md5($signature);
    //转换成大写
    $signature = strtoupper($signature);
    return $signature;

}