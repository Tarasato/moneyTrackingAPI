<?php

class Money {
    private $connDB;
    public $moneyId;
    public $moneyDetail;
    public $moneyDate;
    public $moneyInOut;
    public $moneyType;
    public $userId;
    public $message;
     public function __construct($connDB)
     {
         $this->connDB = $connDB;
     }
    
    public function getAllStatementByuserId()
    {
        $strSQL = "SELECT * FROM money_tb WHERE userId = :userId";
        $this->userId = intval(htmlspecialchars(strip_tags($this->userId)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->execute();
        return $stmt;
    }
    public function insertStatementAPI()
    {
        $strSQL = "INSERT INTO money_tb 
        (moneyDetail,moneyDate,moneyInOut,moneyType,userId)
        VALUES
        (:moneyDetail,:moneyDate,:moneyInOut,:moneyType,:userId);";
            
        $this->moneyDetail = htmlspecialchars(strip_tags($this->moneyDetail));
        $this->moneyDate = htmlspecialchars(strip_tags($this->moneyDate));
        $this->moneyInOut = htmlspecialchars(strip_tags($this->moneyInOut));
        $this->moneyType = htmlspecialchars(strip_tags($this->moneyType));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":moneyDetail", $this->moneyDetail);
        $stmt->bindParam(":moneyDate", $this->moneyDate);
        $stmt->bindParam(":moneyInOut", $this->moneyInOut);
        $stmt->bindParam(":moneyType", $this->moneyType);
        $stmt->bindParam(":userId", $this->userId);
        if ($stmt->execute()) {
        return true;
        } else {
        return false;
        }
    }
}