<?php
include "../models/studentRegistrationModel.php"; 
$model = new studentRegistrationModel();
if(isset($_POST['update_id'])){
    $user_id = $_POST['update_id'];
    
    $result = $model->getStudentDetails($user_id);
    $student = mysqli_fetch_assoc($result);

    //now extract the country name using the country id. to set the value of country dropdown in views using jquery
    $countryId = $student['countryId'];
    $result = $model->getCountryNameById($countryId);
    $countryName = mysqli_fetch_assoc($result);

    //now extract the state name using the state id. to set the value of state dropdown in views using jquery
    $stateId = $student['stateId'];
    $result = $model->getStateNameById($stateId);
    $stateName = mysqli_fetch_assoc($result);

    //now extract the city name using the city id. to set the value of city input box in views using jquery
    $cityId = $student['cityId'];
    $result = $model->getCityNameById($cityId);
    $cityName = mysqli_fetch_assoc($result);

    $result = $model->getHobbieDetails($user_id);
    $hobbies = mysqli_fetch_assoc($result);

    $result = $model->getQualificationDetails($user_id);
    $qualifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Combine all data into a single record
    $student_record = array_merge($student, $countryName, $stateName, $cityName, $hobbies);
    $student_record['qualifications'] = $qualifications;
    echo json_encode($student_record);

}else{
    $response['status'] = 200;
    $response['message'] = "Invalid or data not found";
}
?>