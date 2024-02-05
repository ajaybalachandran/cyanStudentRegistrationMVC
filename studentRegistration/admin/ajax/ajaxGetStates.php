<?php
include "../models/studentRegistrationModel.php"; 
$model = new studentRegistrationModel();
if(isset($_POST['country_id'])){
    $cid = $_POST['country_id'];
    $result = $model->getStates($cid);
    // $states = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // echo json_encode($states);
    $dropdown_options = '';
    while($row=mysqli_fetch_array($result)){
        $dropdown_options .= '<option value="'.$row['state_name'].'+'.$row['id'].'">'.$row['state_name'].'</option>';
    }
    echo $dropdown_options;
}
?>