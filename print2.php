<?php

$name = 'นายพเยาว์ สนพลาย เปลี่ยน';

// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf([
    // 'mode' => 'utf-8', 
    // 'format' => 'A4-L',
    // 'orientation' => 'L',
    
    // 'default_font' => 'kanit',
    'default_font' => 'prompt',
    // 'default_font' => 'NotoSerifThai',
    // 'default_font_size' => 42
]);
$mpdf->useDictionaryLBR = false;

ob_start(); // Start get HTML code
?>


<!DOCTYPE html>
<html>
<head>
<title>PDF</title>
<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
<style>
body {
    font-family: sarabun;
}
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h1>ตัวอย่างในการเก็บโค้ด HTML มาเป็น PDF</h1>
<table>
  <tr>
    <th>ชื่อ</th>
    <th>ที่อยู่</th>
    <th>ประเทศ</th>
  </tr>
  <tr>
    <td>น้องไก่ คนงาม</td>
    <td>นายบ้าน บ้าน</td>
    <td>ไทย</td>
  </tr>
  <tr>
    <td>นายรักเรียน</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
  <tr>
    <td>นายรักดี เปลี่ยม</td>
    <td>Roland Mendel</td>
    <td>Austria</td>
  </tr>
</table>

</body>
</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output("MyPDF.pdf");
ob_end_flush();
?>
ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF.pdf">คลิกที่นี้</a>
	