<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/user.php";

$connDB = new ConnectDB();
$user = new User($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$user->userFullName = $data->userFullName;
$user->userBirthDate = $data->userBirthDate;
$user->userName = $data->userName; 
$user->userPassword = $data->userPassword; 
$user->userImage = $data->userImage;

//เอารูปที่ส่งมาซึ่งเป็นbase64 เก็บไว้ในตัวแปรตัวหนึ่ง
$picture_temp = $data->userImage;
//ตั้งชื่อรูปใหม่เพื่อใช้กับbase 64
$picture_filename = "ProfilePic_" . uniqid() . "_" . round(microtime(true)*1000) . ".png";
//เอารูปที่ส่งมาซึ้งเป็นbase64 แปลงให้เป็นรูปภาพ แล้วเอาไปไว้ที่ picupload/user/
//file_putcontents(ที่อยู่ของรูป, ตัวไฟล์ที่จะอัพโหลด);
file_put_contents( "./../picupload/user/".$picture_filename, base64_decode(string: $picture_temp));
//เอาชื่อไฟล์ไปกำหนให้กับตัวแปรที่จะเก็บลงตารางฐานข้อมูล
$user->userImage = $picture_filename;

$result = $user ->registerAPI();

if ($result == true){
    $resultArray = array("message" => "1");
    
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE);   
}else{
    $resultArray = array("message" => "0");  
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE); 
    
}