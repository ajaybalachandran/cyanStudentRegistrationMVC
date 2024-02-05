<?php
include "../dbconnection.php";
class studentRegistrationModel{

    public function setStudent($reg_no, $upload_image, $first_name, $last_name, $fathers_name, $mothers_name, $dob, 
    $mobile, $address, $country, $state, $city, $pincode, $email, $gender){
        global $conn;
        $sql = "INSERT INTO `student`(registration_no,image,first_name,last_name,fathers_name,mothers_name,dob,mobile,address,countryId,stateId,cityId,pincode,email,gender) 
        VALUES('$reg_no', '$upload_image', '$first_name', '$last_name', 
        '$fathers_name', '$mothers_name', '$dob', '$mobile', '$address', 
        $country, $state, $city, '$pincode', '$email', '$gender')";
        $result = mysqli_query($conn, $sql);
        $lastId=mysqli_insert_id($conn);
        return $lastId;
    }

    public function setHobbies($stud_id, $reading, $music, $sports, $travel){
        global $conn;
        $sql = "INSERT INTO `hobbies`(student_id,reading,music,sports,travel)
        VALUES($stud_id, $reading, $music, $sports, $travel)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function setQualifications($stud_id, $exam, $brd, $per, $year){
        global $conn;
        $sql = "INSERT INTO `qualifications`(student_id,examination,board,percentage,yop)
        VALUES($stud_id, '$exam', '$brd', '$per', $year)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getCountries(){
        global $conn;
        $sql = "SELECT * FROM `countries`";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getStates($country_id){
        global $conn;
        $sql = "SELECT * FROM `states` WHERE country_id=$country_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getCities($search_txt, $state_id){
        global $conn;
        $sql = "SELECT * FROM `cities` WHERE city_name LIKE '$search_txt%' AND state_id=$state_id";
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
        $sql = "SELECT * FROM `student` WHERE student.id=$student_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getHobbieDetails($student_id){
        global $conn;
        $sql = "SELECT * FROM `hobbies` WHERE student_id=$student_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function getQualificationDetails($student_id){
        global $conn;
        $sql = "SELECT * FROM `qualifications` WHERE student_id=$student_id AND status=1";   
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
    $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $student_update_id){
        global $conn;
        $sql = "UPDATE `student`
        SET registration_no='$reg_no',image='$upload_image',
        first_name='$first_name',last_name='$last_name',
        fathers_name='$fathers_name',mothers_name='$mothers_name',
        dob='$dob',mobile='$mobile',address='$address',
        countryId=$country,stateId=$state,cityId=$city,
        pincode='$pincode',email='$email',gender='$gender' 
        WHERE id=$student_update_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function updateStudentDetailsWithoutImage($reg_no, $first_name, $last_name, $fathers_name, $mothers_name, $dob,
    $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $student_update_id){
        global $conn;
        $sql = "UPDATE `student`
        SET registration_no='$reg_no',
        first_name='$first_name',last_name='$last_name',
        fathers_name='$fathers_name',mothers_name='$mothers_name',
        dob='$dob',mobile='$mobile',address='$address',
        countryId=$country,stateId=$state,cityId=$city,
        pincode='$pincode',email='$email',gender='$gender' 
        WHERE id=$student_update_id";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function updateHobbies($reading, $music, $sports, $travel, $student_update_id){
        global $conn;
        $sql = "UPDATE `hobbies` SET reading=$reading, music=$music,
                sports=$sports, travel=$travel WHERE student_id=$student_update_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function deleteQualifications($q_id){
        global $conn;
        $sql = "UPDATE `qualifications` SET status=0 WHERE id=$q_id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function deleteStudent($stud_id){
        global $conn;
        $sql = "UPDATE student
        JOIN qualifications ON student.id = qualifications.student_id
        JOIN hobbies ON student.id = hobbies.student_id
        SET student.status = 0,
            qualifications.status = 0,
            hobbies.status = 0
        WHERE student.id = $stud_id";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function getCountryNameById($countryId){
        global $conn;
        $sql = "SELECT 	country_name FROM `countries` WHERE id=$countryId";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function getStateNameById($stateId){
        global $conn;
        $sql = "SELECT 	state_name FROM `states` WHERE id=$stateId";
        $result = mysqli_query($conn,$sql);
        return $result;
    }

    public function getCityNameById($cityId){
        global $conn;
        $sql = "SELECT city_name FROM `cities` WHERE id=$cityId";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}
?>