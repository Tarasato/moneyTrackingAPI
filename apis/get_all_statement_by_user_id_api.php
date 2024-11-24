<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); //POST, PUT, DELETE
header("Access-Control-Allow-Headers: Content-Type"); 
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/money.php";

$connDB = new ConnectDB();
$money = new Money($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$money->userId = $data->userId;

$result = $money->getAllStatementByuserId();

if($result->rowCount() > 0){
    $resultInfo = array();
    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($resultData);
        $resultArray = array(
            "message" => "1",
            "moneyId" => strval($moneyId),
            "moneyDetail" => $moneyDetail,
            "moneyDate" => $moneyDate,
            "moneyInOut" => strval($moneyInOut),
            "moneyType" => strval($moneyType),
            "userId" => strval($userId)
        );
        array_push($resultInfo, $resultArray);
    }
    echo json_encode($resultInfo, JSON_UNESCAPED_UNICODE);
}else{
    echo json_encode(array("message" => "0"));
}
