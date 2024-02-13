<?php
include "../models/studentRegistrationModel.php"; 
$model = new studentRegistrationModel();
if(isset($_POST['countryId'])){
    $countryId = $_POST['countryId'];
    $result = $model->getStates($countryId);
    $dropdownOptions = '';
    while($row=mysqli_fetch_array($result)){
        $dropdownOptions .= '<option value="'.$row['stateName'].'+'.$row['stateId'].'">'.$row['stateName'].'</option>';
    }
    echo $dropdownOptions;
}
?>