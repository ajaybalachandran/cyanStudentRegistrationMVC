<?php
include "../controllers/studentRegistrationController.php";
require_once "../mpdf/vendor/autoload.php";
$html ='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test mpdf style</title>
    <style>
        *{
            font-family: sans-serif;
            box-sizing: border-box;
        }
        .PersonalInfoTable
        {
            border-collapse: separate;
            width: 100%;
            border-spacing: 0 5px;
        }
        .eduTable
        {
            border-collapse: collapse;
            width: 100%;
        }
        th, td 
        {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            
        }
        .PersonalInfoTable td:nth-child(odd){
            background-color:#f0f0f0;
            width: 15%;
        }
        .PersonalInfoTable td:nth-child(even){
            width: 35%;
            margin-right: 10px;
            
        }
        td:nth-child(n+2), th:nth-child(n+2) 
        {
            border-left: none;
        }
       
    </style>
</head>
<body>
    <div class="container">
        <div class="row">

            <table class="PersonalInfoTable">
                <tr>
                    <th colspan="5" style="background-color:#D8D8D8; border: none;">PERSONAL INFORMATION</th>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td>Akash</td>
                    
                    <td>Last Name</td>
                    <td>Santhosh</td>
                </tr>
                <tr>
                    <td>Father&#39;s Name</td>
                    <td>Santhosh K</td>
                    <td>Mother&#39;s Name</td>
                    <td>Geetha</td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td>12-04-1997</td>
                    <td>Gender</td>
                    <td>
                        <table class="PersonalInfoTable" style="border-collapse: collapse; padding: 0; margin: 0;">
                            <tr>
                                <td style="width: 33.33%; border: none; background-color: #fff; padding: 0;">
                                    <div style="display: flex; justify-content: center;">
                                        <div>
                                            <span>&#x2611;</span>
                                            <span>Male</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 33.33%; border: none; background-color: #fff; padding: 0;">
                                    <div style="display: flex; justify-content: center;">
                                        <div>
                                            <span>&#x2610;</span>
                                            <span>Female</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 33.33%; border: none; background-color: #fff; padding: 0;">
                                    <div style="display: flex; justify-content: center;">
                                        <div>
                                            <span>&#x2610;</span>
                                            <span>Others</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Mobile Number</td>
                    <td>9698787655</td>
                    <td>Email Id</td>
                    <td>akashsanthosh22@gmail.com</td>
                </tr>
                <tr>
                    <td rowspan="2">Address</td>
                    <td rowspan="2">Akash Nivas,<br> Sopanam Jn,<br> Perinad P.O</td>
                    <td>Country</td>
                    <td style="border-left: none;">India</td>
                </tr>
                <tr>
                    <td rowspan="1" style="border-left: none;">State</td>
                    <td rowspan="1" style="border-left: none;">Kerala</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td>Kollam</td>
                    <td>Pin Code</td>
                    <td>691001</td>
                </tr>
                <tr>
                    <td>Hobbies</td>
                    <td colspan="3">
                        <table class="PersonalInfoTable" style="border-collapse: collapse; padding: 0; margin: 0;">
                            <tr>
                                <td style="width: 25%; border: none; background-color: #fff; padding: 0;">
                                    <div style="display: flex; justify-content: center;">
                                        <div>
                                            <span>&#x2611;</span>
                                            <span>Reading</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 25%; border: none; background-color: #fff; padding: 0;">
                                    <div style="display: flex; justify-content: center;">
                                        <div>
                                            <span>&#x2610;</span>
                                            <span>Music</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 25%; border: none; background-color: #fff; padding: 0;">
                                    <div style="display: flex; justify-content: center;">
                                        <div>
                                            <span>&#x2611;</span>
                                            <span>Sports</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 25%; border: none; background-color: #fff; padding: 0;">
                                    <div style="display: flex; justify-content: center;">
                                        <div>
                                            <span>&#x2610;</span>
                                            <span>Travel</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
               
            </table>

            <table class="PersonalInfoTable">
                <tr class="" style="border-spacing: 0 5px;">
                    <th colspan="5" style="background-color:#D8D8D8; width: 100%; border: none;">EDUCATIONAL QUALIFICATIONS</th>
                </tr>
                <table class="eduTable">
                    <tr>
                        <th>SL NO</th>
                        <th>EXAMINATION</th>
                        <th>BOARD</th>
                        <th>PERCENTAGE</th>
                        <th>YEAR OF PASSING</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>sslc</td>
                        <td>cbse</td>
                        <td>83</td>
                        <td>2013</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Plus Two</td>
                        <td>Kerala State</td>
                        <td>80</td>
                        <td>2015</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Degree</td>
                        <td>Kerala University</td>
                        <td>70</td>
                        <td>2018</td>
                    </tr>
                </table>
                
            </table>
            
            
            
        </div>
    </div>
    
</body>
</html>';
if(isset($_GET['studentId']))
{
    $studentId = $_GET['studentId'];
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4','orientation' => 'P', 'default_font' =>'Myriad Pro','default_font_size' =>9 ]);
    $mpdf->SetTitle('STUDENT REGISTRATION FORM');
    $mpdf->SetSubject('STUDENT REGISTRATION FORM');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    exit; // Ensure that no further output is sent
}
?>