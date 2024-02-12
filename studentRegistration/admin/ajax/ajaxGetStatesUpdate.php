<?php
include "../models/studentRegistrationModel.php"; 
$model = new studentRegistrationModel();

//while populate & onchange country
if(isset($_POST['countryId'])){
    $c_id = $_POST['countryId'];
    $result = $model->getStates($c_id);
    $dropdown_options = '';
    while($row=mysqli_fetch_array($result)){
        $dropdown_options .= '<option value="'.$row['stateName'].'" data-state-id="'.$row['stateId'].'">'.$row['stateName'].'</option>';
    }
    echo $dropdown_options;
}

// onchange country
// if(isset($_POST['country_id'])){
//     $cid = $_POST['country_id'];
//     $result = $model->getStates($cid);
//     $dropdown_options = '';
//     while($row=mysqli_fetch_array($result)){
//         $dropdown_options .= '<option value="'.$row['state_name'].'" data-state-id="'.$row['id'].'">'.$row['state_name'].'</option>';
//     }
//     echo $dropdown_options;
// }
?>