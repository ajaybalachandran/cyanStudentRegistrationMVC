<?php
include "../dbconnection.php";
class studentRegistrationModel{

    public function setStudent($registrationNumber, $imageUrl, $firstName, $lastName, $fathersName, $mothersName, $dob, 
    $mobile, $address, $countryId, $stateId, $cityId, $pinCode, $email, $gender){
        global $conn;
        $sql = "INSERT INTO `student`(registrationNumber, imageUrl, firstName, lastName, fathersName, mothersName, dob, mobile, address, countryId, stateId, cityId, pinCode, email, gender) 
        VALUES('$registrationNumber', '$imageUrl', '$firstName', '$lastName', 
        '$fathersName', '$mothersName', '$dob', '$mobile', '$address', 
        $countryId, $stateId, $cityId, $pinCode, '$email', '$gender')";
        $result = mysqli_query($conn, $sql);
        $lastId=mysqli_insert_id($conn);
        return $lastId;
    }

    public function setHobbies($studentId, $reading, $music, $sports, $travel){
        global $conn;
        $sql = "INSERT INTO `hobbies`(studentId,reading,music,sports,travel)
        VALUES($studentId, $reading, $music, $sports, $travel)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function setQualifications($studentId, $examination, $board, $percentage, $yop){
        global $conn;
        $sql = "INSERT INTO `qualifications`(studentId,examination,board,percentage,yop)
        VALUES($studentId, '$examination', '$board', '$percentage', $yop)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getCountries(){
        global $conn;
        $sql = "SELECT * FROM `countries`";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getStates($countryId){
        global $conn;
        $sql = "SELECT * FROM `states` WHERE countryId=$countryId";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getCities($searchText, $stateId){
        global $conn;
        $sql = "SELECT * FROM `cities` WHERE cityName LIKE '$searchText%' AND stateId=$stateId";
        $result = mysqli_query($conn,$sql);
        return $result;
    }
    
    public function getStudents(){
        global $conn;
        $sql = "SELECT * FROM `student` WHERE status=1";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getStudentDetails($student_id){
        global $conn;
        $sql = "SELECT * FROM `student` WHERE studentId=$student_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getHobbieDetails($student_id){
        global $conn;
        $sql = "SELECT * FROM `hobbies` WHERE studentId=$student_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getQualificationDetails($student_id){
        global $conn;
        $sql = "SELECT * FROM `qualifications` WHERE studentId=$student_id AND status=1";   
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // public function getStatesByCountryName($country_name){
    //     global $conn;
    //     $sql = "SELECT id FROM `countries` WHERE country_name='$country_name'";
    //     $result = mysqli_query($conn, $sql);
    //     $country_id = mysqli_fetch_assoc($result);
    //     $states = $this->getStates($country_id['id']);
    //     return $states;
    // }

    public function updateStudentDetailsWithImage($reg_no, $upload_image, $first_name, $last_name, $fathers_name, $mothers_name, $dob, 
    $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $studentUpdateId){
        global $conn;
        $sql = "UPDATE `student`
        SET registration_no='$reg_no',image='$upload_image',
        first_name='$first_name',last_name='$last_name',
        fathers_name='$fathers_name',mothers_name='$mothers_name',
        dob='$dob',mobile='$mobile',address='$address',
        countryId=$country,stateId=$state,cityId=$city,
        pincode='$pincode',email='$email',gender='$gender' 
        WHERE id=$studentUpdateId";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function updateStudentDetailsWithoutImage($reg_no, $first_name, $last_name, $fathers_name, $mothers_name, $dob,
    $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $studentUpdateId){
        global $conn;
        $sql = "UPDATE `student`
        SET registrationNumber='$reg_no',
        firstName='$first_name',lastName='$last_name',
        fathersName='$fathers_name',mothersName='$mothers_name',
        dob='$dob',mobile='$mobile',address='$address',
        countryId=$country,stateId=$state,cityId=$city,
        pincode='$pincode',email='$email',gender='$gender' 
        WHERE studentId=$studentUpdateId";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function updateHobbies($reading, $music, $sports, $travel, $studentUpdateId){
        global $conn;
        $sql = "UPDATE `hobbies` SET reading=$reading, music=$music,
                sports=$sports, travel=$travel WHERE studentId=$studentUpdateId";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function updateQualifications($exam, $brd, $per, $year, $q_id){
        global $conn;
        $sql = "UPDATE `qualifications` SET examination='$exam',
                board='$brd', percentage=$per, yop='$year' WHERE qualificationId=$q_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function deleteQualifications($q_id){
        global $conn;
        $sql = "UPDATE `qualifications` SET status=0 WHERE qualificationId=$q_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function deleteStudent($studId){
        global $conn;
        $sql = "UPDATE student
        JOIN qualifications ON student.studentId = qualifications.studentId
        JOIN hobbies ON student.studentId = hobbies.studentId
        SET student.status = 0,
            qualifications.status = 0,
            hobbies.status = 0
        WHERE student.studentId = $studId";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function getCountryNameById($countryId){
        global $conn;
        $sql = "SELECT 	countryName FROM `countries` WHERE countryId=$countryId";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function getStateNameById($stateId){
        global $conn;
        $sql = "SELECT 	stateName FROM `states` WHERE stateId=$stateId";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function getCityNameById($cityId){
        global $conn;
        $sql = "SELECT cityName FROM `cities` WHERE cityId=$cityId";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getStudentRecord($studentId){
        global $conn;
        // $sql = "SELECT * 
        // FROM student 
        // JOIN hobbies ON student.studentId = hobbies.studentId AND student.status = 1 AND hobbies.status = 1 
        // JOIN qualifications ON student.studentId = qualifications.studentId AND qualifications.status = 1 
        // WHERE student.studentId=$studentId";
        $sql = "SELECT s.*, c.countryName, st.stateName, ci.cityName, h.*, q.*
                FROM student s
                JOIN countries c ON s.countryId = c.countryId
                JOIN states st ON s.stateId = st.stateId
                JOIN cities ci ON s.cityId = ci.cityId
                JOIN hobbies h ON s.studentId = h.studentId AND s.status = 1 AND h.status = 1
                JOIN qualifications q ON s.studentId = q.studentId AND q.status = 1
                WHERE s.studentId = $studentId";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}
?>