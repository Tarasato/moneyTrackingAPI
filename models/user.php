<?php

class User {
    private $connDB;
    public $userId;
    public $userFullName;
    public $userBirthDate;
    public $userName;
    public $userPassword;
    public $userImage;
      public $message;

    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }
   
   public function checkLoginAPI(){
    $strSQL = "SELECT * FROM user_tb WHERE userName = :userName AND userPassword = :userPassword";

    $this->userName = htmlspecialchars(strip_tags($this->userName));
    $this->userPassword = htmlspecialchars(strip_tags($this->userPassword));

    $stmt = $this->connDB->prepare($strSQL);

    $stmt->bindParam(":userName", $this->userName);
    $stmt->bindParam(":userPassword", $this->userPassword);

    $stmt->execute();
    return $stmt;
    }

    public function registerAPI(){
      $strSQL = "INSERT INTO user_tb
      (userFullName,userBirthDate,userName,userPassword,userImage) 
      VALUES
      (:userFullName,:userBirthDate,:userName,:userPassword,:userImage)";
          
      $this->userFullName = htmlspecialchars(strip_tags($this->userFullName));
      $this->userBirthDate = htmlspecialchars(strip_tags($this->userBirthDate));
      $this->userName = htmlspecialchars(strip_tags($this->userName));
      $this->userPassword = htmlspecialchars(strip_tags($this->userPassword));
      $this->userImage = htmlspecialchars(strip_tags($this->userImage));
  
      $stmt = $this->connDB->prepare($strSQL);
  
      $stmt->bindParam(":userFullName", $this->userFullName);
      $stmt->bindParam(":userBirthDate", $this->userBirthDate);
      $stmt->bindParam(":userName", $this->userName);
      $stmt->bindParam(":userPassword", $this->userPassword);
      $stmt->bindParam(":userImage", $this->userImage);
      
      if ($stmt->execute()) {
          return true;
      } else {
          return false;
      }
      }
}