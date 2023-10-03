<?php

class StudentDAO{
    private $db;
    private $databaseConnectionObj;

    public function __construct(){
        $this->databaseConnectionObj = new DatabaseConnection();
        $this->db = $this->databaseConnectionObj->connect();
    }
    

    public function GetAllStudents()
    {

        $sql = "SELECT * FROM Student";
        $raw_result = $this->db->prepare($sql);
        if (!$raw_result->execute()) {
            $raw_result = null;
            exit();
        }
        $allTraineesData = $raw_result->fetchAll(PDO::FETCH_ASSOC);
        $dataArr = [];
        foreach ($allTraineesData as $data) {
            $traineeInfo = new Student($data['Id'], $data['Name'], $data['Email'], $data['DateOfBirth']);
            array_push($dataArr, $traineeInfo);
        }

        return $dataArr;
    }


    public function GetStudent($studentId)
    {
        if($studentId <= 0) {
            // TODO: return type should be same datatype
            return false;
        }
        $sql = "SELECT * FROM Student WHERE Id = :studentId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();

        $aStudent = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aStudent !== false) {
            $studentObj = new Student($aStudent['Id'], $aStudent['Name'], $aStudent['Email'], $aStudent['DateOfBirth']);
            return $studentObj;
        }

        return false;
    }
    public function AddStudent($student)
    {

        $sql = "INSERT INTO Student ( `Name`, `Email`, `DateOfBirth`)
                VALUES (
                  :name,
                  :email,
                  :dateOfBirth
                )";
    $stmt=$this->db->prepare($sql);
    $name=$student->GetName();
    $email=$student->GetEmail();
    $dob=$student->GetDateOfBirth();
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':dateOfBirth',$dob);
    $stmt->execute();
    $lastInsertId=$this->db->lastInsertId();
    return $lastInsertId;

    }


}
?>