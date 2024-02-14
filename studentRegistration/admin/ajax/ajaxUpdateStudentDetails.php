<?php
//require_once "../models/studentRegistrationModel.php";
require_once "../controllers/studentRegistrationController.php";

$model = new studentRegistrationModel();
$studentRegistrationObj = new studentRegistrationController();
if(isset($_FILES['img']) || isset($_POST['no_image'])){
    $studentUpdateId        =       $_POST['studentUpdateId'];
    $registrationNumber     =       $_POST['registrationNumber'];
    $firstName              =       $_POST['firstName'];
    $lastName               =       $_POST['lastName'];
    $fathersName            =       $_POST['fathersName'];
    $mothersName            =       $_POST['mothersName'];
    $dob                    =       $_POST['dob'];
    $mobile                 =       $_POST['mobile'];
    $address                =       $_POST['address'];
    $country                =       $_POST['countryId'];
    $state                  =       $_POST['stateId'];
    $city                   =       $_POST['cityId'];
    $pincode                =       $_POST['pin'];
    $email                  =       $_POST['email'];
    $gender                 =       $_POST['gender'];

    $reading                =       isset($_POST['reading']) ? 1 : 0;
    $music                  =       isset($_POST['music']) ? 1 : 0;
    $sports                 =       isset($_POST['sports']) ? 1 : 0;
    $travel                 =       isset( $_POST['travel']) ? 1 : 0;
    
    $qualificationIdArray   =       $_POST['qualificationId']; //string
    $examination            =       $_POST['examination'];
    $board                  =       $_POST['board'];
    $percentage             =       $_POST['percentage'];
    $yop                    =       $_POST['yop'];
    $statusArray            =       $_POST['status'];
    

    if(isset($_FILES['img']))
    {
        $imgName           =       $_FILES['img']['name'];
        $imgSize           =       $_FILES['img']['size'];
        $tmpName           =       $_FILES['img']['tmp_name'];
        $error             =       $_FILES['img']['error'];

        if($error === 0)
        {
            $uploadImage = $studentRegistrationObj-> imageFileUpload($imgName);
            $result = $model->updateStudentDetailsWithImage($registrationNumber, $uploadImage, $firstName, $lastName, $fathersName, $mothersName, $dob, 
                                                            $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $studentUpdateId);
            if(!$result)
            {
                die(mysqli_error($conn));
            }
            $studentRegistrationObj->moveUploadedImageToFolder($tmpName, $uploadImage);
        }
        else
        {
            $em = "unknown error occured!";
            $error = array('error'=> 1, 'em'=> $em);
            echo json_encode($error);
            exit();
        }
    }


    if(isset($_POST['no_image']))
    {
        $result = $model->updateStudentDetailsWithoutImage($registrationNumber, $firstName, $lastName, $fathersName, $mothersName, $dob,
                                                            $mobile, $address, $country, $state, $city, $pincode, $email, $gender, $studentUpdateId);
        if(!$result)
        {
            die(mysqli_error($conn));
        }
    }

    
    $result = $model->updateHobbies($reading, $music, $sports, $travel, $studentUpdateId);
    if(!$result)
    {
        die(mysqli_error($conn));
    }

    //qualifications Dynamic Row
    for($i=0; $i<count($examination);$i++)
    {
        $qualificationId = $qualificationIdArray[$i];//string
        $exam = $examination[$i];
        $brd = $board[$i];
        $per = $percentage[$i];
        $year = $yop[$i];
        $status = $statusArray[$i];

        //update
        if($status == 1)
        {
            $result = $model->updateQualifications($exam, $brd, $per, $year, $qualificationId);
            if(!$result)
            {
                die(mysqli_error($conn));
            }
        }

        //create
        if($status == 2)
        {
            $result = $model->setQualifications($studentUpdateId, $exam, $brd, $per, $year);
            if(!$result)
            {
                die(mysqli_error($conn));
            }
        }

        //delete
        if($status == 3)
        {
            $result = $model->deleteQualifications($qualificationId);
            if(!$result)
            {
                die(mysqli_error($conn));
            }
        }

    }

    $response = array("message" => "Data updated successfully");

    // Set the HTTP response code to 200 (OK)
    http_response_code(200);
    echo json_encode($response);
    
}
?>