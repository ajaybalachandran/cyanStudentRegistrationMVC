<?php
include "../models/studentRegistrationModel.php";

class studentRegistrationController
{
    public function setStudent($registrationNumber, $imageUrl, $firstName, $lastName, $fathersName, $mothersName, $dob, 
                                $mobile, $address, $countryId, $stateId, $cityId, $pinCode, $email, $gender)
    {
        $objStudentRegistrationModel = new studentRegistrationModel();
        $lastId = $objStudentRegistrationModel->setStudent($registrationNumber, $imageUrl, $firstName, $lastName, $fathersName, $mothersName, $dob, 
                                    $mobile, $address, $countryId, $stateId, $cityId, $pinCode, $email, $gender);
        return $lastId;
    }

    public function setHobbies($studentId, $reading, $music, $sports, $travel)
    {
        $objStudentRegistrationModel = new studentRegistrationModel();
        $result = $objStudentRegistrationModel->setHobbies($studentId, $reading, $music, $sports, $travel);
        return $result;
       
    }

    public function setQualifications($studentId, $examination, $board, $percentage, $yop)
    {
        $objStudentRegistrationModel = new studentRegistrationModel();
        $result = $objStudentRegistrationModel->setQualifications($studentId, $examination, $board, $percentage, $yop);
        return $result;
    }

    public function getCountries()
    {
        $objStudentRegistrationModel = new studentRegistrationModel();
        $countries = $objStudentRegistrationModel->getCountries();
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
        $objStudentRegistrationModel = new studentRegistrationModel();
        $countries = $objStudentRegistrationModel->getCountries();
        $dropdownOptions = '';
        while($row=mysqli_fetch_assoc($countries))
        {
            $countryId          =       $row['countryId'];
            $countryName        =       $row['countryName'];
            $dropdownOptions   .=       '<option value="'.$countryName.'" data-country-id="'.$countryId.'">'.ucfirst($countryName).'</option>';
        }
        return $dropdownOptions;
    }

    public function getStudents()
    {
        $objStudentRegistrationModel = new studentRegistrationModel();
        $students = $objStudentRegistrationModel->getStudents();
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
                                                        <button type="submit" name="deleteStudent" class="btn btn-sm btn-danger deleteStudData" style="display:inline">Delete</button>
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
        $filenameSeperate = explode('.', $imageFileName);
        $fileExtension = strtolower($filenameSeperate[1]);
        $extension = array('jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG');//allowed extentons by the user
        //checkes whether the file selected by the user is allowed or not
        if(in_array($fileExtension, $extension))
        {
            $newImageName = uniqid("IMG-", true).'.'.$fileExtension;
            $uploadImage = '../images/uploads/'.$newImageName;//this to be insert in db
        }
        return $uploadImage;

    }

    public function moveUploadedImageToFolder($imageFileTmp, $imageUrl)
    {
        move_uploaded_file($imageFileTmp, $imageUrl);
    }

    public function deleteStudent($studId)
    {
        $objStudentRegistrationModel = new studentRegistrationModel();
        $result = $objStudentRegistrationModel->deleteStudent($studId);
        return $result;
    }
}
?>