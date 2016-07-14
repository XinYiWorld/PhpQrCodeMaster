<?php
/**
 * Created by PhpStorm.
 * User: btsj
 * Date: 2016/7/13 0013
 * Time: 下午 18:50
 */
CONST DIVIDER = '@#$%';

 function save($fileName,$mode,$txt){
    $myfile = fopen($fileName, $mode) or die("Unable to open file!");
    fwrite($myfile, $txt);
    fclose($myfile);
}

function read($fileName,$mode){
    $handle = fopen($fileName,$mode);//读取二进制文件时，需要将第二个参数设置成'rb'
    //通过filesize获得文件大小，将整个文件一下子读到一个字符串中
    $contents = fread($handle, filesize ($fileName));
    fclose($handle);
    return $contents;
}