<?php
include "../controllers/studentRegistrationController.php";
$studentRegistrationObj = new studentRegistrationController();
if(isset($_POST['submit'])){
   
    $registrationNumber         =       $_POST['registrationNumber'];
    $firstName                  =       $_POST['firstName'];
    $lastName                   =       $_POST['lastName'];
    $fathersName                =       $_POST['fathersName'];
    $mothersName                =       $_POST['mothersName'];
    $dob                        =       $_POST['dob'];
    $mobile                     =       $_POST['mobile'];
    $address                    =       $_POST['address'];
    $countryId                  =       explode("+", $_POST['country'])[1];
    $stateId                    =       explode("+", $_POST['state'])[1];
    $cityId                     =       $_POST['cityId'];
    $pinCode                    =       $_POST['pinCode'];
    $email                      =       $_POST['email'];
    $gender                     =       $_POST['gender'];

    // Initialize hobby variables
    $reading                    =       isset($_POST['reading']) ? 1 : 0;
    $music                      =       isset($_POST['music']) ? 1 : 0;
    $sports                     =       isset($_POST['sports']) ? 1 : 0;
    $travel                     =       isset($_POST['travel']) ? 1 : 0;

    $examinationArray           =       $_POST['examination'];
    $boardArray                 =       $_POST['board'];
    $percentageArray            =       $_POST['percentage'];
    $yopArray                   =       $_POST['yop'];

    $image                      =       $_FILES['profile_image'];
    $imageFileName              =       $image['name'];
    $imageFileError             =       $image['error'];
    $imageFileTmp               =       $image['tmp_name'];
    if($imageFileError == 0){
        
        //for creating path of image file to insert into db
        $imageUrl = $studentRegistrationObj->imageFileUpload($imageFileName);
        $studentId = $studentRegistrationObj->setStudent($registrationNumber, $imageUrl, $firstName, $lastName, $fathersName, $mothersName, $dob, 
                                                        $mobile, $address, $countryId, $stateId, $cityId, $pinCode, $email, $gender);
        if($studentId)
        {
            echo "Student Data inserted Successfully";
        }
        else
        {
            die("Student Data not inserted!!!!!!");
        }

        //for move the uploaded image file into the specified folder
        $studentRegistrationObj->moveUploadedImageToFolder($imageFileTmp, $imageUrl);
        $hobbiesResult = $studentRegistrationObj->setHobbies($studentId, $reading, $music, $sports, $travel);
        if($hobbiesResult)
        {
            echo "Hobbies Data inserted Successfully";
        }
        else
        {
            die("Hobbies Data not inserted!!!!!!");
        }
        for($i=0; $i<count($examinationArray);$i++)
        {
            $examination = $examinationArray[$i];
            $board = $boardArray[$i];
            $percentage = $percentageArray[$i];
            $yop = $yopArray[$i];
            $qualificationsResult = $studentRegistrationObj->setQualifications($studentId, $examination, $board, $percentage, $yop);
        }
    }
    header('location:studentRegistrationView.php');
    
}

if(isset($_POST['delete_student'])){
    $id = $_POST['stud_id'];
    
    $result = $studentRegistrationObj->deleteStudent($id);
    if($result){
        // echo "Deleted sucessfully";
        header('location:studentRegistrationView.php');
    }else{
        die("Connection failed: " .mysqli_connect_error());

    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <section class="header">
    <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand nav_brand" href="#">EduRegister</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" >
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./index2.php">Register</a>
            </li>
            
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <section class="content">
    
    <!-- ----------------------------------------------------------------------------------Registration Modal---------------------------------------------------------------------------------- -->
    <div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="container-fluid p-0 m-0">
                    <div class="row ">
                        <div class="col d-flex justify-content-center align-items-center " >
                            <div class="reg bg-light  px-5 py-3 border border-secondary-subtle rounded">

                                <!-- Form Started -->
                                <form action="" method="POST" enctype="multipart/form-data" id="reg_form"> 
                                <div class="row g-0 mb-4" >
                                    <div class="col-1 main_heading_side"></div>
                                    <div class="col-10">
                                        <div class="text-center position-relative">
                                            <h2 class="text-uppercase main_heading" style="margin: 0;">Registration Form</h2>
                                        </div>
                                    </div>
                                    <div class="col-1 d-flex align-items-center justify-content-center main_heading_side">
                                    <div class="">
                                        <button class="btn btn btn-outline-danger " type="button" data-bs-dismiss="modal">
                                        <i class="fa-solid  fa-rectangle-xmark "></i>
                                        </button>
                                        
                                    </div>
                                    </div>
                                </div>
                                    <div>

                                    </div>

                                    <div>
                                        <!-- Reg no and Image Starts -->
                                        <div class="row form_row ">
                                            <div class="col-lg-6 pe-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_reg_no" class="fw-semibold">Registration No</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input class="input_fields" type="number" name="registrationNumber" id="id_reg_no" style="width: 100%;">

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6 ps-lg-5">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <img id="imagePreview" src="../images/dummy_prof.png" alt="Image Preview" class="img-fluid me-0 dummy_img" style="max-width: 100px;">
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="row align-items-center" style="height: 100%;">
                                                            <div class="col">
                                                                <input type="file" name="profile_image" class="input_fields file_upload_btn" style="border: none;">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Reg no and Image Ended -->

                                        <!-- First name and Last name starts -->
                                        <div class="row form_row">
                                            <div class="col-lg-6 pe-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_first_name" class="fw-semibold">First Name</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="firstName" class="input_fields" id="id_first_name" placeholder="">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 ps-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_lname" class="fw-semibold">Last Name</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="lastName" class="input_fields" id="id_lname" placeholder="">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- First name and Last name Ended -->

                                        <div class="row form_row">
                                            <div class="col-lg-6 pe-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_father_name" class="fw-semibold">Father's Name</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="fathersName" class="input_fields" id="id_father_name" placeholder="">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 ps-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_mother_name" class="fw-semibold">Mother's Name</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="mothersName" class="input_fields" id="id_mother_name" placeholder="">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dob and mobile starts -->
                                        <div class="row form_row">
                                            <div class="col-lg-6 pe-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_dob" class="fw-semibold">Date Of Birth</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="dob" class="input_fields" id="id_dob" >

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 ps-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_mob" class="fw-semibold">Mobile</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="mobile" class="input_fields" id="id_mob" placeholder="">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Dob and mobile Ends -->

                                        <!-- Address and country starts -->
                                        <div class="row form_row">
                                            <div class="col-lg-6 pe-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_address" class="fw-semibold">Address</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <textarea name="address" id="id_address" cols="" rows=""  class=""></textarea>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 ps-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_country" class="fw-semibold">Country</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <select name="country"  id="id_country">
                                                            <option value="">Choose Country</option>
                                                            <?php 
                                                                $result = $studentRegistrationObj->getCountries();
                                                                echo $result;
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Address and country Ends -->

                                        <!-- State and city Starts -->
                                        <div class="row form_row">
                                            <div class="col-lg-6 pe-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_state" class="fw-semibold">State</label>

                                                    </div>
                                                    <div class="col-lg-8">
                                                        <select name="state" id="id_state">
                                                            <option value="">Choose State</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 ps-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_city" class="fw-semibold">City</label>

                                                    </div>
                                                    <div class="col-lg-8 city_names">
                                                        <input type="text" name="city" class="input_fields" id="id_city" autocomplete="off">
                                                        <div  id="countryList"></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- State and city Ends -->

                                        <!-- Pincode and Email Starts -->
                                        <div class="row form_row">
                                            <div class="col-lg-6 pe-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_pin" class="fw-semibold">Pincode</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="pinCode" class="input_fields" id="id_pin" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 ps-lg-5">
                                                <div class="row align-items-center" style="height: 100%;">
                                                    <div class="col-lg-4">
                                                        <label for="id_email" class="fw-semibold">Email</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="email" name="email" class="input_fields" id="id_email" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pincode and Email Ends -->

                                        <!-- Gender Starts -->
                                        <div class="row form_row align-items-center mt-3" style="height: auto;">
                                            <div class="col">
                                                <label for="" class="fw-semibold">Gender </label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="gender" id="male" value="male" >
                                                <label for="male">Male</label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="gender" id="female" value="female">
                                                <label for="female">Female</label>
                                            </div>
                                            <div class="col">
                                                <input type="radio" name="gender" id="others" value="others">
                                                <label for="others">Others</label>
                                            </div>
                                            <div class="col">

                                            </div>
                                        </div>
                                        <!-- Gender Ends -->


                                        <div class="row form_row align-items-center mt-3"  style="height: auto;">
                                            <div class="col">
                                                <label for="" class="fw-semibold">Hobbies</label>
                                            </div>
                                            <div class="col">
                                                <input type="checkbox" name="reading" value="reading" id="id_reading">
                                                <label for="id_reading">Reading</label>
                                            </div>
                                            <div class="col">
                                                <input type="checkbox" name="music" value="music" id="id_music">
                                                <label for="id_music">Music</label>
                                            </div>
                                            <div class="col">
                                                <input type="checkbox" name="sports" value="sports" id="id_sports">
                                                <label for="id_sports">Sports</label>
                                            </div>
                                            <div class="col">
                                                <input type="checkbox" name="travel" value="travel" id="id_travel">
                                                <label for="id_travel">Travel</label>
                                            </div>

                                        </div>

                                        <div class="row form_row mt-3">
                                            <div class="col">
                                                <label for="" class="fw-semibold">Qualifications</label>

                                            </div>
                                        </div>
                                        <div class="row form_row ">
                                            <div class="col">
                                                <div style="width: 100%;">
                                                    <table style="width: 100%;" class="table table-secondary table-bordered" id="id_qualification_table">
                                                        <tr>
                                                            <th>Sl.No.&nbsp;&nbsp;&nbsp;</th>
                                                            <th>Examination</th>
                                                            <th>Board</th>
                                                            <th>Percentage</th>
                                                            <th colspan="2">Year of Passing</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>1</p>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="examination[]" class="table_input" style="margin-right: 5px;">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="board[]" class="table_input" style="margin-right: 5px;">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="percentage[]" class="table_input" style="margin-right: 5px;">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="yop[]" class="table_input" style="margin-right: 5px;">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-secondary" id="id_add_btn">
                                                                    <span>
                                                                        <i class="fa-solid fa-plus"></i>
                                                                    </span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        
                                                    </table>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    

                                        <div class="row">
                                            <div class="col-4"></div>
                                            <div class="col-4 d-flex flex-column align-items-center">
                                                <div>
                                                    <button type="submit" class="reg_button" name="submit">Register</button>

                                                </div>
                                            </div>
                                            <div class="col-4"></div>
                                            
                                        </div>

                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Update modal -->
    <div class="modal fade modal-xl" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true" >
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="container-fluid p-0 m-0">
                <div class="row ">
                    <div class="col d-flex justify-content-center align-items-center " >
                        <div class="reg bg-light  px-5 py-3 border border-secondary-subtle rounded">
                            <form class="studform" id="updateForm" enctype="multipart/form-data">
                             <!-- Form Started -->
                              <div class="row g-0 mb-4" >
                                <div class="col-1 main_heading_side"></div>
                                <div class="col-10">
                                  <div class="text-center position-relative">
                                    <h2 class="text-uppercase main_heading" style="margin: 0;">Update Details</h2>
                                    
                                </div>
                                </div>
                                <div class="col-1 d-flex align-items-center justify-content-center main_heading_side">
                                  <div class="">
                                    <button class="btn btn btn-outline-danger " type="button" data-bs-dismiss="modal">
                                      <i class="fa-solid  fa-rectangle-xmark "></i>
                                    </button>
                                    
                                  </div>
                                </div>
                              </div>
                                <div>

                                </div>

                                <div>
                                    <!-- Reg no and Image Starts -->
                                    <div class="row form_row ">
                                        <div class="col-lg-6 pe-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="update_id_reg_no" class="fw-semibold">Registration No</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input class="input_fields" type="number" name="reg_no" id="update_id_reg_no" style="width: 100%;">

                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-6 ps-lg-5">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img id="UpdateimagePreview" src="../images/dummy_prof.png" alt="Image Preview" class="img-fluid me-0 dummy_img" style="max-width: 100px;">
                                                </div>
                                                <div class="col-8">
                                                    <div class="row align-items-center" style="height: 100%;">
                                                        <div class="col">
                                                            <input type="file" name="name_update_profile_image" id="update_profile_pic" class="input_fields file_upload_btn" style="border: none;">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Reg no and Image Ended -->

                                    <!-- First name and Last name starts -->
                                    <div class="row form_row">
                                        <div class="col-lg-6 pe-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_first_name" class="fw-semibold">First Name</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="fname" class="input_fields" id="id_update_first_name" placeholder="">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ps-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_lname" class="fw-semibold">Last Name</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="lname" class="input_fields" id="id_update_lname" placeholder="">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- First name and Last name Ended -->

                                    <div class="row form_row">
                                        <div class="col-lg-6 pe-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_father_name" class="fw-semibold">Father's Name</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="father_name" class="input_fields" id="id_update_father_name" placeholder="">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ps-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_mother_name" class="fw-semibold">Mother's Name</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="mother_name" class="input_fields" id="id_update_mother_name" placeholder="">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dob and mobile starts -->
                                    <div class="row form_row">
                                        <div class="col-lg-6 pe-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_dob" class="fw-semibold">Date Of Birth</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="date" name="dob" class="input_fields" id="id_update_dob" >

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ps-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_mob" class="fw-semibold">Mobile</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="number" name="mobile" class="input_fields" id="id_update_mob" placeholder="">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Dob and mobile Ends -->

                                    <!-- Address and country starts -->
                                    <div class="row form_row">
                                        <div class="col-lg-6 pe-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_address" class="fw-semibold">Address</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <textarea name="address" id="id_update_address" cols="" rows=""  class=""></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ps-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_country" class="fw-semibold">Country</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <select name="country" id="id_update_country">
                                                        
                                                        <?php
                                                            $result = $studentRegistrationObj->getCountriesUpdate();
                                                            echo $result;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Address and country Ends -->

                                    <!-- State and city Starts -->
                                    <div class="row form_row">
                                        <div class="col-lg-6 pe-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_state" class="fw-semibold">State</label>

                                                </div>
                                                <div class="col-lg-8">
                                                    <select name="state" id="id_update_state">
                                                        <option value="">Choose State</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ps-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_city" class="fw-semibold">City</label>

                                                </div>
                                                <div class="col-lg-8 city_names_update">
                                                    <input type="text" name="city" class="input_fields" id="id_update_city" autocomplete="off">
                                                    <div  id="countryListUpdate"></div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- State and city Ends -->

                                    <!-- Pincode and Email Starts -->
                                    <div class="row form_row">
                                        <div class="col-lg-6 pe-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_pin" class="fw-semibold">Pincode</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="number" name="pin" class="input_fields" id="id_update_pin" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ps-lg-5">
                                            <div class="row align-items-center" style="height: 100%;">
                                                <div class="col-lg-4">
                                                    <label for="id_update_email" class="fw-semibold">Email</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="email" name="email" class="input_fields" id="id_update_email" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pincode and Email Ends -->

                                    <!-- Gender Starts -->
                                    <div class="row form_row align-items-center mt-3" style="height: auto;">
                                        <div class="col">
                                            <label for="" class="fw-semibold">Gender </label>
                                        </div>
                                        <div class="col">
                                            <input type="radio" name="gender" id="id_male" value="male">
                                            <label for="male">Male</label>
                                        </div>
                                        <div class="col">
                                            <input type="radio" name="gender" id="id_female" value="female">
                                            <label for="female">Female</label>
                                        </div>
                                        <div class="col">
                                            <input type="radio" name="gender" id="id_others" value="others">
                                            <label for="others">Others</label>
                                        </div>
                                        <div class="col">

                                        </div>
                                    </div>
                                    <!-- Gender Ends -->


                                    <div class="row form_row align-items-center mt-3"  style="height: auto;">
                                        <div class="col">
                                            <label for="" class="fw-semibold">Hobbies</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" name="reading" value="reading" id="id_update_reading">
                                            <label for="id_update_reading">Reading</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" name="music" value="music" id="id_update_music">
                                            <label for="id_update_music">Music</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" name="sports" value="sports" id="id_update_sports">
                                            <label for="id_update_sports">Sports</label>
                                        </div>
                                        <div class="col">
                                            <input type="checkbox" name="travel" value="travel" id="id_update_travel">
                                            <label for="id_update_travel">Travel</label>
                                        </div>

                                    </div>

                                    <div class="row form_row mt-3">
                                        <div class="col">
                                            <label for="" class="fw-semibold">Qualifications</label>

                                        </div>
                                    </div>
                                    <div class="row form_row ">
                                        <div class="col">
                                            <div >
                                                <table class="table table-secondary table-bordered" id="id_update_qualification_table">
                                                    <tr>
                                                        <th>Sl.No.&nbsp;&nbsp;&nbsp;</th>
                                                        <th>Examination</th>
                                                        <th>Board</th>
                                                        <th>Percentage</th>
                                                        <th >Year of Passing</th>
                                                        <th>
                                                            <button type="button" class="btn btn-sm btn-secondary" id="id_update_add_btn">
                                                                <span>
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                    <span id="id_qualifications_content">
                                                        
                                                    </span>
                                                    
                                                </table>
                                                <input type="hidden" name="student_update_id" id="hiddendata">
                                            </div>
                                            
                                        </div>
                                    </div>

                                  

                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4 d-flex flex-column align-items-center">
                                            <div>
                                                <button type="submit" class="reg_button" name="submit_update" id="submit_update" value="update">Update</button>

                                            </div>
                                            
                                        </div>
                                        <div class="col-4"></div>
                                        
                                    </div>

                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
      <div class="card mt-3">
        <h5 class="card-header card_header">
          <div class="row" style="height: 100%;">
            <div class="col d-flex justify-content-center align-items-center" >
              <div>
                STUDENT DETAILS 
              </div>
            </div>
            <div class="col d-flex justify-content-center align-items-center">
              <div>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Register Now</button>
              </div>
            </div>
          </div>
          
          <div class="d-inline-block">
          </div>
        </h5>
        <div class="card-body">
          <table class="table table-striped mt-2 display" id="stud_table">
            <thead>
                <tr>
                <th>Regstration No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Mobile</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $students_list = $studentRegistrationObj->getStudents();
                    echo $students_list;
                ?>
            </tbody>
            
          </table>
        </div>
      </div>


        

        
        
        
                
        
    </div>
  </section>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 15px;
        }
        .card_header{
            height: 4rem;
            background-color: #333 !important;
            color: #fff !important;
            }

        .modal{
            padding: 0 !important;
            margin: 0 !important;
        }
        .modal-content{
            padding: 0px !important;
            margin: 0 !important;
        }
        
        body{
            background-image: url(../images/bg-registration-form-1.jpg);
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .reg{
            width: 100%;
            height: auto;
        }
        .form_row{
            margin-bottom: 1rem;
        }  
        .input_fields, textarea, select{
            width: 100%;
            height: auto; 
            /* 2rem */
            margin-bottom:3px !important;
            border: none;
            border-bottom: 2px solid black;
            background-color: #ffffff00;
        }
        .other_section{
            margin-bottom:10px !important;
        }
        input:focus, textarea:focus, select:focus{
            outline: none;
        }
        textarea{
            width: 100%;
        }
        table tr .input_fields{
            margin-right: 2px;
            border-bottom: 2px solid black;
        }
        .reg_button {
            border: none;
            width: 150px;
            height: 40px;
            margin: auto;
            
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            background: #333;
            font-size: 15px;
            color: #fff;
            
        }
        .dummy_img{
            border: 2px solid black;
            border-radius: 10px;
        }

        .main_heading{
            padding: 10px 0px 10px 0px;
            margin-bottom: 20px;
            color: #fff;
            background: #333;
        }
        .main_heading_side{
            background: #333;
        }

        .table_input{
            margin-bottom:3px !important;
            border: none;
            border-bottom: 2px solid black;
            background-color: #ffffff00;
        }
        .city_names, .city_names_update{
            position: relative;
        }
        #countryList, #countryListUpdate {
            position: absolute;
            left: 0;
            right: 0;
            margin:0 10px;
            z-index: 1;
            box-sizing: content-box;
            background-color: #fff;
            max-height: 200px;

        }
        .citynames:hover{
            cursor: pointer;
            background-color: #e0e0e6;
        }
    </style> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
        function GetDetails(updateid){
            // console.log(updateid)
            $("#hiddendata").val(updateid);


            $.post("../ajax/ajaxGetStudentDetails.php",{update_id:updateid},function(data,status){
                // console.log("this is response data")
                console.log(data);
                var userid = JSON.parse(data);
                userid.forEach(student => {
                    $('#update_id_reg_no').val(student.registrationNumber);
                    $('#id_update_first_name').val(student.firstName);
                    $('#id_update_lname').val(student.lastName);
                    $('#id_update_father_name').val(student.fathersName);
                    $('#id_update_mother_name').val(student.mothersName);
                    $('#id_update_dob').val(student.dob);
                    $('#id_update_mob').val(student.mobile);
                    $('#id_update_address').val(student.address);
                    $('#id_update_country').val(student.countryName);

                    $.post("../ajax/ajaxGetStatesUpdate.php",{countryId:student.countryId},function(data,status){
                        //let matched_states = JSON.parse(data);
                        $("#id_update_state option:gt(0)").remove();
                        $('#id_update_state').append(data);
                        $('#id_update_state').val(student.stateName);
                    }); 

                    $('#id_update_city').val(student.cityName);
                    $('#id_update_pin').val(student.pinCode);
                    $('#id_update_email').val(student.email);

                    $('#id_male').prop('checked', student.gender == 'male' ? true : false);
                    $('#id_female').prop('checked', student.gender == 'female' ? true : false);
                    $('#id_others').prop('checked', student.gender == 'others' ? true : false);

                    $('#id_update_reading').prop('checked', student.reading == 1 ? true : false);
                    $('#id_update_music').prop('checked', student.music == 1 ? true : false);
                    $('#id_update_sports').prop('checked', student.sports == 1 ? true : false);
                    $('#id_update_travel').prop('checked', student.travel == 1 ? true : false);

                    var qualificationsArray = student.qualifications;
                    console.log(qualificationsArray);
                    //deynamic row
                    var slno = 1 ;
                    $("#id_update_qualification_table").find("tr:gt(0)").remove();
                    for(i in qualificationsArray)
                    {
                        // console.log(qualificationsArray[i]);
                        var html = '';
                        html += '<tr><td><p>'+slno+'</p><input type="hidden" name="qualification_id[]" id="existing_update_hidden_id'+slno+'"></td>';
                        html += '<td><input type="text" name="examination[]" id="id_update_examination'+slno+'" class="table_input" style="margin-right: 5px;"></td>';
                        html += '<td><input type="text" name="board[]" id="id_update_board'+slno+'" class="table_input" style="margin-right: 5px;"></td>';
                        html += '<td><input type="text" name="percentage[]" id="id_update_percentage'+slno+'" class="table_input" style="margin-right: 5px;"></td>';
                        html += '<td><input type="text" name="yop[]" id="id_update_yop'+slno+'" class="table_input" style="margin-right: 5px;"></td>';
                        html += '<td><button type="button" class="btn btn-sm btn-danger update_remove" name="remove"><span><i class="fa-solid fa-minus"></i></span></button>';
                        html += '<input type="hidden" name="status[]" id="existing_hidden_status'+slno+'" value=1></td>'
                        html += '</tr>';
                        $('#id_update_qualification_table').append(html);
                        $('#existing_update_hidden_id'+slno).val(qualificationsArray[i].qualificationId);
                        $('#id_update_examination'+slno).val(qualificationsArray[i].examination);
                        $('#id_update_board'+slno).val(qualificationsArray[i].board);
                        $('#id_update_percentage'+slno).val(qualificationsArray[i].percentage);
                        $('#id_update_yop'+slno).val(qualificationsArray[i].yop);
                    
                        slno += 1;
                    }
                   
                    console.log("-------------------------");
                    
                });
              
            });
            $("#updateModal").modal("show");
        }

        //dropdown update
        $(document).ready(function(){
            $(document).on('change', '#id_update_country', function(e){
                let c_id = $(this).find("option:selected").data("country-id");
                console.log("country id is: "+ c_id)
                
                $.post("../ajax/ajaxGetStatesUpdate.php",{countryId:c_id},function(data,status){
                    //var states = JSON.parse(data);
                    $("#id_update_state option:gt(0)").remove();
                    $('#id_update_state').append(data);
                    // $('#id_country').val(c_array[0])
                    $('#id_update_city').val("");
                });
                
            });
        });

        $(document).on('change', '#id_update_state', function(e){
            $('#id_update_city').val("");
        });


        //while submits the update form
        $(document).ready(function(){
            $('#updateForm').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                
                if($('#update_profile_pic')[0].files[0]){
                    // console.log("image is here")
                    formData.append('img', $('#update_profile_pic')[0].files[0]);
                }else{
                    formData.append('no_image', 'no image is selected');
                }
                let countryId = $('#id_update_country').find("option:selected").data("country-id");
                let stateId = $('#id_update_state').find("option:selected").data("state-id");
                console.log(countryId,stateId)
                formData.append('countryId', countryId);
                formData.append('stateId', stateId);

                
                $.ajax({
                    url: '../ajax/ajaxUpdateStudentDetails.php',
                    type: 'POST',
                    data: formData,
                    dataType:"JSON",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        // console.log("success")
                        // console.log(data)
                        // This should contain the server's response
                        $("#updateModal").modal("hide");
                        location.reload();

                    }
                });
            });
        });



        $("#updateModal").on('shown.bs.modal', function(){

            // Initialize slno to the number of existing rows 
            var slno = $('#id_update_qualification_table tr').length ;
            // console.log("this is the tr len:" + slno)
            var count = 1;

            $('#id_update_add_btn').click(function(){
                // console.log("clicked" ,slno);
                var html = '';
                html += '<tr class="dynamic-element"><td><p>'+slno+'</p><input type="hidden" name="qualification_id[]" id="update_hidden_id'+count+'"></td>';
                html += '<td><input type="text" name="examination[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><input type="text" name="board[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><input type="text" name="percentage[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><input type="text" name="yop[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><button type="button" class="btn btn-sm btn-danger update_remove" name="update_remove"><span><i class="fa-solid fa-minus"></i></span></button>';
                html += '<input type="hidden" name="status[]" id="new_hidden_status'+count+'" value=2></td>'
                html += '</tr>';
                $('#id_update_qualification_table').append(html);
                $('#update_hidden_id'+count).val("new");
                
                
                slno += 1;
                count += 1;
            });

            
            $(document).on('click', '.update_remove', function(){
                console.log("remove clicked\n");
                // var remove_id = $(this).closest('tr').find('input[type="hidden"]').val();
                // console.log("this is remove id"+remove_id)

                var firstHiddenInput = $(this).closest('tr').find('input[type="hidden"]:eq(0)').val();//qid
                var secondHiddenInput = $(this).closest('tr').find('input[type="hidden"]:eq(1)').val();//status
                console.log(firstHiddenInput, secondHiddenInput)
                if(firstHiddenInput=='new'){
                    $(this).closest('tr').remove();
                }
                if(firstHiddenInput != 'new'){
                    $(this).closest('tr').hide();
                    $(this).closest('tr').find('input[type="hidden"]:eq(1)').val(3);

                }

                

                $('#id_update_qualification_table tr:visible').each(function(index) {
                    $(this).find('td:first p').text(index);
                });
                slno -= 1;
                
                

            });
        });

        $('#updateModal').on('hidden.bs.modal', function () {
            location.reload();
        });

        // $('#updateModal').on('hidden.bs.modal', function () {
        //     // Remove dynamically added elements
        //     $("#id_update_qualification_table").find("tr:gt(0)").remove();
        // });
    </script>
    <script>
        $(document).ready(function(){
            // Initialize slno to the number of existing rows 
            var slno = $('#id_qualification_table tr').length ;

            $('#id_add_btn').click(function(){
                console.log("clicked" ,slno);
                var html = '';
                html += '<tr><td><p>'+slno+'</p></td>';
                html += '<td><input type="text" name="examination[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><input type="text" name="board[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><input type="text" name="percentage[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><input type="text" name="yop[]" class="table_input" style="margin-right: 5px;"></td>';
                html += '<td><button type="button" class="btn btn-sm btn-danger remove" name="remove"><span><i class="fa-solid fa-minus"></i></span></button></td>';
                html += '</tr>';
                $('#id_qualification_table').append(html);
                slno += 1;
            });

            //if we dynamically add a button or element here it is remove button with class name remove. 
            //in this case we will use the following method to access the dynamically added html element.

            // $('.remove').click(function(){
            //     console.log("remove clicked");
            //     //this is not working because of button with .remove class is dynamically added 
            // });

            $(document).on('click', '.remove', function(){
                console.log("remove clicked");
                $(this).closest('tr').remove();

                // Update slno for remaining rows
                $('#id_qualification_table tr').each(function(index) {
                    $(this).find('td:first p').text(index);
                });

                slno -= 1;
            });

            // $('#reg_form').submit(function(e) {
            //     // Check each input in the form
            //     $('input, textarea, select').each(function() {
            //         // If the input is empty
            //         if (!$(this).val()) {
            //             // Prevent form submission
            //             e.preventDefault();
            //             // Optionally, you can show an alert or highlight the empty field
            //             alert('Please fill all the fields');
            //             $(this).css('border', '1px solid red');
            //             // Exit the loop
            //             return false;
            //         }
            //     });
            //     if (!$('input[name="gender"]:checked').length) {
            //         e.preventDefault();
            //         alert('Please select a radio option');
            //     }
                

            // });
        
        });


        $(document).on('submit', '#reg_form', function(e){

            // Check each input in the form
            $('#reg_form:visible').find('input, textarea, select').each(function() {
                // If the input is empty
                if (!$(this).val()) {
                    // Prevent form submission
                    e.preventDefault();
                    // Optionally, you can show an alert or highlight the empty field
                    alert('Please fill all the fields');
                    $(this).css('border', '1px solid red');
                    // Exit the loop
                    return false;
                }
            });
            if (!$('input[name="gender"]:checked').length) {
                e.preventDefault();
                alert('Please select a radio option');
            }
            

        });

        //dropdown registration
        $(document).ready(function(){
            $(document).on('change', '#id_country', function(e){
                let c_datas = $('#id_country').val();
                let c_array = c_datas.split("+")
                // let c_value = $('#id_country').val();
                console.log(c_array);
                // $('#id_country').val(c_array[0])
                
                $.post("../ajax/ajaxGetStates.php",{country_id:c_array[1]},function(data,status){
                    //var states = JSON.parse(data);
                    $("#id_state option:gt(0)").remove();
                    $('#id_state').append(data);

                   
                });
                
            });
        });

        //city auto complete registration

            
            $(document).on('keyup', '#id_city', function(e){
                let s_datas = $('#id_state').val();
                let s_array = s_datas.split("+")
                // let s_value = $('#id_state').val();
                var tvalue = $( this ). val();
                if(tvalue == ''){
                    $('#countryList').empty().fadeOut();
                }
                // console.log(tvalue, s_value)
                if (tvalue != ""){
                    $.post("../ajax/ajaxCityAutoComplete.php",{	stateId:s_array[1],searchText:tvalue},function(data,status){
                        // var cities = JSON.parse(data);
                        $('#countryList').fadeIn();
                        $("#countryList").html(data);

                        // for (let index in cities){
                        //     console.log(cities[index].city_name);
                        //     let html = '<p>'+cities[index].city_name+'</p>';
                        //     $("#countryList").html(html);
                        // }

                    
                        // $('#countryList').html('<p>'+cities[index].city_name+'</p>');
            
                    });
                }
                $(document).on('click', 'li', function(){
                    $('#id_city').val($(this).text());
                    $('#countryList').fadeOut();
                    $('li').not(this).remove();
                });
                
            });

        
        //city auto complete update 

        $(document).on('keyup', '#id_update_city', function(e){
            let stateId = $('#id_update_state option:selected').data('state-id');
            // let s_array = s_datas.split("+")
            // let s_value = $('#id_state').val();
            var tvalue = $( this ). val();
            if(tvalue == ''){
                $('#countryListUpdate').empty().fadeOut();
            }
            // console.log(tvalue, s_value)
            if (tvalue != ""){
                $.post("../ajax/ajaxCityAutoComplete.php",{state_id:stateId,search_text:tvalue},function(data,status){
                    // var cities = JSON.parse(data);
                    $('#countryListUpdate').fadeIn();
                    $("#countryListUpdate").html(data);

                    // for (let index in cities){
                    //     console.log(cities[index].city_name);
                    //     let html = '<p>'+cities[index].city_name+'</p>';
                    //     $("#countryList").html(html);
                    // }

                
                    // $('#countryList').html('<p>'+cities[index].city_name+'</p>');
        
                });
            }
            $(document).on('click', 'li', function(){
                $('#id_update_city').val($(this).text());
                $('#countryListUpdate').fadeOut();
                $('li').not(this).remove();

                
            });
            
        });

    </script>
</body>
</html>
