<?php
include "../models/studentRegistrationModel.php";

class studentRegistrationController
{
    public function setStudent($registrationNumber, $imageUrl, $firstName, $lastName, $fathersName, $mothersName, $dob, 
                                $mobile, $address, $countryId, $stateId, $cityId, $pinCode, $email, $gender)
    {
        $model = new studentRegistrationModel();
        $lastId = $model->setStudent($registrationNumber, $imageUrl, $firstName, $lastName, $fathersName, $mothersName, $dob, 
                                    $mobile, $address, $countryId, $stateId, $cityId, $pinCode, $email, $gender);
        return $lastId;
    }

    public function setHobbies($studentId, $reading, $music, $sports, $travel)
    {
        $model = new studentRegistrationModel();
        $result = $model->setHobbies($studentId, $reading, $music, $sports, $travel);
        return $result;
       
    }

    public function setQualifications($studentId, $examination, $board, $percentage, $yop)
    {
        $model = new studentRegistrationModel();
        $result = $model->setQualifications($studentId, $examination, $board, $percentage, $yop);
        return $result;
    }

    public function getCountries()
    {
        $model = new studentRegistrationModel();
        $countries = $model->getCountries();
        $dropdownOptions = '';
        while($row=mysqli_fetch_assoc($countries))
        {
            $countryId          =       $row['countryId'];
            $countryName        =       $row['countryName'];
            $dropdownOptions   .=       '<option value="'.$countryName.'+'.$countryId.'">'.ucfirst($countryName).'</option>';
        }
        return $dropdownOptions;
    }

    public function getCountriesUpdate()
    {
        $model = new studentRegistrationModel();
        $countries = $model->getCountries();
        $dropdownOptions = '';
        while($row=mysqli_fetch_assoc($countries))
        {
            $c_id               =       $row['countryId'];
            $c_name             =       $row['countryName'];
            $dropdownOptions   .=       '<option value="'.$c_name.'" data-country-id="'.$c_id.'">'.ucfirst($c_name).'</option>';
        }
        return $dropdownOptions;
    }

    public function getStudents()
    {
        $model = new studentRegistrationModel();
        $students = $model->getStudents();
        $studentsList = '';
        if($students->num_rows != 0)
        {
            while($row = mysqli_fetch_assoc($students))
            {
                $studentId              = $row['studentId'];
                $registrationNumber     = $row['registrationNumber'];
                $firstName              = $row['firstName'];
                $lastName               = $row['lastName'];
                $dob                    = $row['dob'];
                $gender                 = $row['gender'];
                $mobile                 = $row['mobile'];

                $studentsList          .= '<tr>
                                                <td>'.$registrationNumber.'</td>
                                                <td>'.$firstName.'</td>
                                                <td>'.$lastName.'</td>
                                                <td>'.$dob.'</td>
                                                <td>'.$gender.'</td>
                                                <td>'.$mobile.'</td>
                                                <td>
                                                    <input type="text" name="deleteStudId" value="'.$studentId.'" hidden>
                                                    <button class="btn btn-sm btn-success me-3" onclick="GetDetails('.$studentId.')">Edit</button>
                                                    <form action="" method="post" class="deleteStudentForm d-inline" id="DeleteStud">
                                                        <input name="studId" type="hidden" value="'.$studentId.'">
                                                        <button type="submit" name="deleteStudent" class="btn btn-sm btn-danger" style="display:inline">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>';
            }
       
        }
        else
        {
            $studentsList.='<tr>
                                <td colspan=7 style="text-align: center;">NO DATA FOUND</td>
                            </tr>';
        }

        return $studentsList;
        
    }

    public function imageFileUpload($imageFileName)
    {
        $filename_seperate = explode('.', $imageFileName);
        $file_extension = strtolower($filename_seperate[1]);
        $extension = array('jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG');//allowed extentons by the user
        if(in_array($file_extension, $extension)){//checkes whether the file selected by the user is allowed or not
            $newImageName = uniqid("IMG-", true).'.'.$file_extension;
            $uploadImage = '../images/uploads/'.$newImageName;//this to be insert in db
            // move_uploaded_file($imagefiletmp, $upload_image);
        }
        return $uploadImage;

    }

    public function moveUploadedImageToFolder($imageFileTmp, $imageUrl)
    {
        move_uploaded_file($imageFileTmp, $imageUrl);
    }

    public function deleteStudent($studId)
    {
        $model = new studentRegistrationModel();
        $result = $model->deleteStudent($studId);
        return $result;
    }
}
?>