<?php
$conn=mysqli_connect("localhost","root","","myDb") or die("cannot connect");
require_once __DIR__ . '/vendor/autoload.php';

$sql = "SELECT * FROM  grocerydynamicdata";
$result = $conn->query($sql);
$data = [];
$i = 0;
while ($row = $result->fetch_assoc()) {
  $data[$i] = $row;
  $i++;
}

require_once 'vendor/autoload.php'; // Include the mPDF library
$mpdf = new \Mpdf\Mpdf(); // Create an instance of mPDF
$html = '
<table id="example" class="display" style="border-collapse: collapse;">
<thead>
  <tr>
    <th style="border: 1px solid black;">ID</th>
    <th style="border: 1px solid black;">CUSTOMER ID</th>
    <th style="border: 1px solid black;">DESCRIPTION</th>
    <th style="border: 1px solid black;">PRODUCT</th>
    <th style="border: 1px solid black;">QUALITY</th>
    <th style="border: 1px solid black;">PRICE</th>

  </tr>
</thead>
<tbody>';

foreach ($data as $key => $row) {
 $key=$key+1;
 $reg=100;
  $html .= '
  <tr>
  <td style="border: 1px solid black;">' . $key . '</td>
  <td style="border: 1px solid black;">' . $row['productDetailsId'] . '</td>
  <td style="border: 1px solid black;">' . $row['customerId'] . '</td>
  <td style="border: 1px solid black;">' . $row['product'] . '</td>
  <td style="border: 1px solid black;">' . $row['qty'] . '</td>
  <td style="border: 1px solid black;">' . $row['price'] . '</td>	

  </tr>';
}
$html .= '
</tbody>
</table>';

$mpdf->WriteHTML($html); // Write the HTML content to the PDF
$mpdf->Output(); // Output the PDF

?>