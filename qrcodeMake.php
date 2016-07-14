<?php
/**
 * 生成二维码
 * Created by PhpStorm.
 * User: btsj
 * Date: 2016/7/13 0013
 * Time: 下午 18:21
 */
include dirname(__File__) .'/phpqrcode/phpqrcode.php';
include 'FileUtil.php';

if(!isset($_POST['submit'])){
    exit('非法访问!');
}
$android_url = $_POST['android_url'];
$ios_url = $_POST['ios_url'];
$code_size = $_POST['code_size'];
$has_logo = $_POST['has_logo'];
$code_correct_level = $_POST['code_correct_level'];
$logo_in_qrcode_percent = $_POST['logo_in_qrcode_percent'];

$platforms = $_POST['platforms'];
$platformsCount = sizeOf($platforms);       //平台个数


save("url.txt",'w',$android_url.DIVIDER.$ios_url);


$value = 'http://192.168.123.1/4-qrcodeUI/target.php/'; //二维码内容
$errorCorrectionLevel = $code_correct_level;//容错级别
$matrixPointSize = $code_size;//二维码点大小


//-------1.生成不带logo的二维码--------------------------------------------------------------------------------------
if(strcmp($has_logo,'no') == 0){
    $outputImageName;
    if($platformsCount == 2){
        QRcode::png($value,'1_no_logo_android_ios.png',$errorCorrectionLevel, $matrixPointSize, 2);
        $outputImageName = '1_no_logo_android_ios.png';

    }else if($platformsCount == 1){
        if(strcmp($platforms[0],'android') == 0){
            QRcode::png($android_url,'1_no_logo_android.png',$errorCorrectionLevel, $matrixPointSize, 2);
            $outputImageName = '1_no_logo_android.png';
        }else if(strcmp($platforms[0],'ios') == 0){
            QRcode::png($ios_url,'1_no_logo_ios.png',$errorCorrectionLevel, $matrixPointSize, 2);
            $outputImageName = '1_no_logo_ios.png';
        }
    }
    echo '<img src='.$outputImageName.'>';
    return;
}
//-------2.生成带logo的二维码--------------------------------------------------------------------------------------
$bgImageName;
if($platformsCount == 2){
    QRcode::png($value,'2_no_logo_android_ios.png',$errorCorrectionLevel, $matrixPointSize, 2);
    $bgImageName = '2_no_logo_android_ios.png';
}else if($platformsCount == 1){
    if(strcmp($platforms[0],'android') == 0){
        QRcode::png($android_url,'2_no_logo_android.png',$errorCorrectionLevel, $matrixPointSize, 2);
        $bgImageName = '2_no_logo_android.png';
    }else if(strcmp($platforms[0],'ios') == 0){
        QRcode::png($ios_url,'2_no_logo_ios.png',$errorCorrectionLevel, $matrixPointSize, 2);
        $bgImageName = '2_no_logo_ios.png';
    }
}
$logo = 'logo.png';//准备好的logo图片
$QR = $bgImageName;//已经生成的原始二维码图

if ($logo !== FALSE) {
    $QR = imagecreatefromstring(file_get_contents($QR));
    $logo = imagecreatefromstring(file_get_contents($logo));
    $QR_width = imagesx($QR);//二维码图片宽度
    $QR_height = imagesy($QR);//二维码图片高度
    $logo_width = imagesx($logo);//logo图片宽度
    $logo_height = imagesy($logo);//logo图片高度
    $logo_qr_width = $QR_width / $logo_in_qrcode_percent;    //logo图片在二维码中的宽度
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;
    $from_width = ($QR_width - $logo_qr_width) / 2;
    //重新组合图片并调整大小
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
        $logo_qr_height, $logo_width, $logo_height);
}
//输出图片
$outputWithLogoImageName;
if($platformsCount == 2){
    $outputWithLogoImageName = '2_has_logo_android_ios.png';
}else if($platformsCount == 1){
    if(strcmp($platforms[0],'android') == 0){
        $outputWithLogoImageName = '2_has_logo_android.png';
    }else if(strcmp($platforms[0],'ios') == 0){
        $outputWithLogoImageName = '2_has_logo_ios.png';
    }
}
imagepng($QR, $outputWithLogoImageName);
echo '<img src='.$outputWithLogoImageName.'>';