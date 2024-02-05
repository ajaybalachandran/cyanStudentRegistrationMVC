<?php
include "../models/studentRegistrationModel.php"; 
$model = new studentRegistrationModel();
if(isset($_POST['state_id'])){
    $output = '';
    $sid = $_POST['state_id'];
    $search_txt =  $_POST['search_text'];
    $result = $model->getCities($search_txt, $sid);
    $output = '<ul class="list-unstyled">';
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result)){
            $output .='<li class="citynames">'.$row["city_name"].'<input class="hiddenCityId" name="cityId" type="hidden" value="'.$row["id"].'">'.'</li>';
        }
    }
    else{
        $output .= '<li>City Not Found</li>';
    }
    $output .= '</ul>';
    echo $output;
}
?>