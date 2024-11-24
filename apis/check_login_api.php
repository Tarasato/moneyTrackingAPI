<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/user.php";

$connDB = new ConnectDB();
$user = new User($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$user->userName = $data->userName;
$user->userPassword = $data->userPassword;

$result = $user->checkLoginAPI();

if ($result->rowCount() > 0) {
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);
    $resultArray = array(
        "message" => "1",
        "userId" => strval($userId),
        "userFullName" => $userFullName,
        "userBirthDate" => $userBirthDate,
        "userName" => $userName,
        "userPassword" => $userPassword, 
        "userImage" => $userImage
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode(array("message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"));
}
