<?php
include "../models/studentRegistrationModel.php";

class studentRegistrationController{
    public function setStudent($reg_no, $upload_image, $first_name, $last_name, $fathers_name, $mothers_name, $dob, 
    $mobile, $address, $country, $state, $city, $pincode, $email, $gender){
        $model = new studentRegistrationModel();
        $lastId = $model->setStudent($reg_no, $upload_image, $first_name, $last_name, $fathers_name, $mothers_name, $dob, 
        $mobile, $address, $country, $state, $city, $pincode, $email, $gender);
        return $lastId;
    }

    public function setHobbies($stud_id, $reading, $music, $sports, $travel){
        $model = new studentRegistrationModel();
        $result = $model->setHobbies($stud_id, $reading, $music, $sports, $travel);
        return $result;
       
    }

    public function setQualifications($stud_id, $exam, $brd, $per, $year){
        $model = new studentRegistrationModel();
        $result = $model->setQualifications($stud_id, $exam, $brd, $per, $year);
        return $result;
    }

    public function getCountries(){
        $model = new studentRegistrationModel();
        $countries = $model->getCountries();
        $dropdown_options = '';
        while($row=mysqli_fetch_assoc($countries)){
            $c_id = $row['id'];
            $c_name = $row['country_name'];
            $dropdown_options.='<option value="'.$c_name.'+'.$c_id.'">'.ucfirst($c_name).'</option>';
        }
        return $dropdown_options;
    }

    public function getCountriesUpdate(){
        $model = new studentRegistrationModel();
        $countries = $model->getCountries();
        $dropdown_options = '';
        while($row=mysqli_fetch_assoc($countries)){
            $c_id = $row['id'];
            $c_name = $row['country_name'];
            $dropdown_options.= '<option value="'.$c_name.'" data-country-id="'.$c_id.'">'.ucfirst($c_name).'</option>';
        }
        return $dropdown_options;
    }

    public function getStudents(){
        $model = new studentRegistrationModel();
        $students = $model->getStudents();
        $students_list = '';
        if($students->num_rows != 0){
            while($row = mysqli_fetch_assoc($students)){
                $id = $row['id'];
                $reg_no = $row['registration_no'];
                $fname = $row['first_name'];
                $lname = $row['last_name'];
                $dob = $row['dob'];
                $gender = $row['gender'];
                $mobile = $row['mobile'];
                $students_list.= '<tr>
                <td>'.$reg_no.'</td>
                <td>'.$fname.'</td>
                <td>'.$lname.'</td>
                <td>'.$dob.'</td>
                <td>'.$gender.'</td>
                <td>'.$mobile.'</td>
                <td>
                    
                    <input type="text" name="deleteStudId" value="'.$id.'" hidden>
                    <button class="btn btn-sm btn-success me-3" onclick="GetDetails('.$id.')">Edit</button>
                    
                    
                    <form action="" method="post" class="deleteStudentForm d-inline" id="DeleteStud">
                        
                            <input name="stud_id" type="hidden" value="'.$id.'">
                        
                        
                        <button type="submit" name="delete_student" class="btn btn-sm btn-danger" style="display:inline">Delete</button>
                    </form>
                    
                    </td>
                </tr>';
            }
       
        }
        else{
            $students_list.='<tr>
                                <td colspan=7 style="text-align: center;">NO DATA FOUND</td>
                            </tr>';
        }
        return $students_list;
        
    }

    public function imageFileUpload($imagefilename){
        $filename_seperate = explode('.', $imagefilename);
        $file_extension = strtolower($filename_seperate[1]);
        $extension = array('jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG');//allowed extentons by the user
        if(in_array($file_extension, $extension)){//checkes whether the file selected by the user is allowed or not
            $new_img_name = uniqid("IMG-", true).'.'.$file_extension;
            $upload_image = '../images/uploads/'.$new_img_name;//this to be insert in db
            // move_uploaded_file($imagefiletmp, $upload_image);
        }
        return $upload_image;

    }

    public function moveUploadedImageToFolder($imagefiletmp, $upload_image){
        move_uploaded_file($imagefiletmp, $upload_image);
    }

    public function deleteStudent($stud_id){
        $model = new studentRegistrationModel();
        $result = $model->deleteStudent($stud_id);
        return $result;
    }
}
?>