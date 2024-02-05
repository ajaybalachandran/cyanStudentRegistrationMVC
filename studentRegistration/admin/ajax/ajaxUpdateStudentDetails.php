<?php
//require_once "../models/studentRegistrationModel.php";
require_once "../controllers/studentRegistrationController.php";

$model = new studentRegistrationModel();
$studentRegistrationObj = new studentRegistrationController();
if(isset($_FILES['img']) || isset($_POST['no_image'])){
    $student_update_id = $_POST['student_update_id'];
    $reg_no = $_POST['reg_no'];
    $first_name = $_POST['fname'];
    $last_name =  $_POST['lname'];
    $fathers_name =   $_POST['father_name'];
    $mothers_name =   $_POST['mother_name'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $country = $_POST['countryId'];
    $state = $_POST['stateId'];
    $city = $_POST['cityId'];
    $pincode = $_POST['pin'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    $reading = isset($_POST['reading']) ? 1 : 0;
    $music = isset($_POST['music']) ? 1 : 0;
    $sports = isset($_POST['sports']) ? 1 : 0;
    $travel = isset( $_POST['travel']) ? 1 : 0;
    
    $q_ids = $_POST['qualification_id']; //string
    $examination = $_POST['examination'];
    $board = $_POST['board'];
    $percentage = $_POST['percentage'];
    $yop = $_POST['yop'];
    $status_array = $_POST['status'];

    

    

    if(isset($_FILES['img'])){
        // echo "image sselected";
        $img_name = $_FILES['img']['name'];
        $img_size = $_FILES['img']['size'];
        $tmp_name = $_FILES['img']['tmp_name'];
        $error = $_FILES['img']['error'];


        // echo "hai";
        // echo $img_name,$img_size,$tmp_name,$error;

        if($error === 0){
            
            $upload_image = $studentRegistrationObj-> imageFileUpload($img_name);
            $result = $model->updateStudentDetailsWithImage($reg_no, $upload_image, $first_name, $last_name, $fathers_name, $mothers_name, $dob, 
                    $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $student_update_id);
            if(!$result){
                die(mysqli_error($conn));
            }
            $studentRegistrationObj->moveUploadedImageToFolder($tmp_name, $upload_image);
        }else{
            $em = "unknown error occured!";
            $error = array('error'=> 1, 'em'=> $em);
            echo json_encode($error);
            exit();
        }

        
        
       
        
    
    }
    if(isset($_POST['no_image'])){
        // echo "image not selected";
        
        $result = $model->updateStudentDetailsWithoutImage($reg_no, $first_name, $last_name, $fathers_name, $mothers_name, $dob,
        $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $student_update_id);
        if(!$result){
            die(mysqli_error($conn));
        }
    }

    
    $result = $model->updateHobbies($reading, $music, $sports, $travel, $student_update_id);
    if(!$result){
        die(mysqli_error($conn));
    }





    //new
    for($i=0; $i<count($examination);$i++){

        $q_id = $q_ids[$i];//string
        $exam = $examination[$i];
        $brd = $board[$i];
        $per = $percentage[$i];
        $year = $yop[$i];
        $status = $status_array[$i];

        //update
        if($status == 1){
            $result = $model->updateHobbies($reading, $music, $sports, $travel, $student_update_id);
            if(!$result){
                die(mysqli_error($conn));
            }
        }

        //create
        if($status == 2){
            $result = $model->setQualifications($student_update_id, $exam, $brd, $per, $year);
            if(!$result){
                die(mysqli_error($conn));
            }
        }

        //delete
        if($status == 3){
            
            $result = $model->deleteQualifications($q_id);
            if(!$result){
                die(mysqli_error($conn));
            }
        }

    }
    
    
    $response = array("message" => "Data updated successfully");

    // Set the HTTP response code to 200 (OK)
    http_response_code(200);
    echo json_encode($response);
    // header("location:home.php");
    

    
}
?>