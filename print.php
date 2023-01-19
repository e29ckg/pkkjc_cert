<?php
require_once __DIR__ . '/vendor/autoload.php';

// use Mpdf\Mpdf;
header("Content-type:application/pdf");
// header("Content-Disposition:inline;filename='$filename");

$name = 'นายพเยาว์ สนพลาย';
// $name = $_GET['name'];
// echo $name;


// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 
    'format' => 'A4-L',
    'orientation' => 'L',
    
    // 'default_font' => 'kanit',
    'default_font' => 'prompt',
    // 'default_font' => 'NotoSerifThai',
    'default_font_size' => 42
]);

$mpdf->SetTitle($name);
$mpdf->useDictionaryLBR = false;

$mpdf->AddPage();

$pagecount = $mpdf->setSourceFile('img/tm.pdf');
$tplId = $mpdf->importPage($pagecount);

$actualsize = $mpdf->useTemplate($tplId);

// Write some HTML code:
// $img_url = 'https://www.canva.com/design/DAFWHoQ0Atk/view';
// $img_url = './img/cert_tm.jpg';
// $mpdf->Image($img_url, 0, 0, 297, 210, '', '', true, false);
// $mpdf->Image($img_url, 0, 0,  297, 210, 'jpg', '', true, false);
// $mpdf->WriteHTML('Hello World');

$data = '<div style="text-align:center;font-weight: bold;">'
        .$name.
        '</div>';
$mpdf->WriteFixedPosHTML($data, 0, 69, 297, 210, 'auto');

$qr_code = '<img id="imgurl" src="https://chart.googleapis.com/chart?cht=qr&amp;chl=http://www.diw.go.th&amp;chs=80x80&amp;choe=UTF-8" border="0" width="80" height="80">';
$mpdf->WriteFixedPosHTML($qr_code, 15, 175, 297, 210, 'auto');

// Output a PDF file directly to the browser
$mpdf->Output();

?>

