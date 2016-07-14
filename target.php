<?php
include 'FileUtil.php';
echo read('url.txt','r');
$urls =explode(DIVIDER,read('url.txt','r'));

function get_device_type()
{
    //全部变成小写字母
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $type = 'other';
    //分别进行判断
    if(strpos($agent, 'iphone') || strpos($agent, 'ipad'))
    {
        $type = 'ios';
    }

    if(strpos($agent, 'android'))
    {
        $type = 'android';
    }
    return $type;
}

if(strcmp(get_device_type(),'ios') == 0){
    header("location: ".$urls[1]);
}else if(strcmp(get_device_type(),'android') == 0){
    header("location: ".$urls[0]);
}else{  //最后走了这个
    header("location: http://www.baitongshiji.com/");
}

