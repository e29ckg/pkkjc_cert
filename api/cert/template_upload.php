<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

include "../connect.php";
include "../function.php";

// $data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
$data = json_decode(file_get_contents("php://input")); // collect input parameters and convert into readable format

$upload_path = '../../template/'; // set upload folder path 

$id = $_POST['id'];

// $fileName  =  $id;
$fileName  =  $_FILES['sendpdf']['name'];
$tempPath  =  $_FILES['sendpdf']['tmp_name'];
$fileSize  =  $_FILES['sendpdf']['size'];

$template_name = 'ผู้เข้าร่วมโครงการ';
$template_size = 'A4';
$template_orientation = 'L';

$text_name  = 'ชื่อ-สกุล(ทดสอบ)';
$text_font  = 'prompt';
$text_size  = 36;
$text_y     = 69;

if(isset($_POST['template_name'])){
	$template_name = $_POST['template_name']; 
}
if(isset($_POST['template_name'])){
	$template_size = $_POST['template_size']; 
}
if(isset($_POST['template_name'])){
	$template_orientation = $_POST['template_orientation']; 
}

if(isset($_POST['text_name'])){
	$text_font = $_POST['text_name']; 
}
if(isset($_POST['text_font'])){
	$text_font = $_POST['text_font']; 
}
if(isset($_POST['text_size'])){
	$text_size = $_POST['text_size']; 
}
if(isset($_POST['text_y'])){
	$text_y = $_POST['text_y']; 
}

// http_response_code(200);
// echo json_encode(array(
//     'status' => true, 
//     'massege' =>  'upload -mg Ok',  
//     'respJSON' => $fileExt
// ));
// exit;
	
if(empty($id)){	
	$errorMSG = json_encode(array("message" => "Not ", "status" => false));	
	echo $errorMSG;
	exit;
}



if(empty($fileName)){
	$errorMSG = json_encode(array("message" => "please select pdf", "status" => false));	
	echo $errorMSG;
	exit;
}else{
	// $upload_path = '../../uploads/'; // set upload folder path 
	
	$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
		
	// valid image extensions
	$valid_extensions = array('pdf'); 
					
	// allow valid image file formats
	if(in_array($fileExt, $valid_extensions))
	{				
		//check file not exist our upload folder path
		if(!file_exists($upload_path . $fileName)){
			if(!is_dir($upload_path)){
				mkdir($upload_path, 0777);
			}
			// check file size '5MB'
			if($fileSize < 5000000){
				// $fileName = time().'.' .$fileExt;
				$fileName = $id.time().'.' .$fileExt;

				$sql = "SELECT template_url FROM project_template WHERE id=$id ";
				$query = $conn->prepare($sql);
				$query->execute();
				$result = $query->fetchAll(PDO::FETCH_OBJ);
				if($result){
					$template = $result[0]->template;
					if($template != '' && file_exists($upload_path . $template)){
						unlink($upload_path . $template);
					}
				}

				move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
				// echo json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
				// exit;
			}

			else{		
				$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
				echo $errorMSG;
			}
		}else{		
			$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false, 'upload_path' => $upload_path.$fileName));	
			// $errorMSG = json_encode(array("message" => "Sorry, มีภาพนี้อยู่แล้ว", "status" => false));	
			echo $errorMSG;
		}
	}
	else
	{		
		$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false, 'fileExt' => $fileExt));	
		echo $errorMSG;		
	}
}
		
// if no error caused, continue ....
if(!isset($errorMSG))
{

	// $sql = "UPDATE project_template SET template_url =:template WHERE id = :id ";   
	$template_id = time(); 
	$sql = "INSERT INTO project_template(id, project_id, template_name, size, orientation, template_url) 
			VALUE(:template_id, :project_id, :template_name, :size, :orientation, :template_url);";       
	$query = $conn->prepare($sql);
	$query->bindParam(':template_id',$template_id, PDO::PARAM_STR);
	$query->bindParam(':project_id',$id, PDO::PARAM_STR);
	$query->bindParam(':template_name', $template_name, PDO::PARAM_STR);
	$query->bindParam(':size', $template_size, PDO::PARAM_STR);
	$query->bindParam(':orientation', $template_orientation, PDO::PARAM_STR);
	$query->bindParam(':template_url', $fileName, PDO::PARAM_STR);
	$query->execute();

    $template = array();
    array_push($template,array(
        "id"    => $template_id,
        "template_name"  => $template_name,
        "project_id"  => $id,
        "size"  => $template_size,
        "orientation"  => $template_orientation,
        "template_url"  => '/pkkjc_cert/template/'.$fileName,
        "template_act"  => 'update',
    ));


	$sql = "INSERT INTO project_text(id, project_id, project_template_id, text_name, text_font, text_size, text_y) 
			VALUE(:text_id, :project_id, :project_template_id, :text_name, :text_font, :text_size, :text_y);";       
	$query = $conn->prepare($sql);
	$query->bindParam(':text_id',$template_id, PDO::PARAM_STR);
	$query->bindParam(':project_id',$id, PDO::PARAM_STR);
	$query->bindParam(':project_template_id', $template_id, PDO::PARAM_STR);
	$query->bindParam(':text_name', $text_name, PDO::PARAM_STR);
	$query->bindParam(':text_font', $text_font, PDO::PARAM_STR);
	$query->bindParam(':text_size', $text_size, PDO::PARAM_INT);
	$query->bindParam(':text_y', $text_y, PDO::PARAM_INT);
	$query->execute();

	$text = array();
    array_push($text,array(
        "id"    => $template_id,
        "project_id"  => $id,
        "project_template_id"  => $template_id,
        "text_name"  => $text_name,
        "text_font"  => $text_font,
        "text_size"  => $text_size,
        "text_y"  => $text_y
    ));

    
	$img_link = $fileName;
		// $img_link = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'] . '/pkkjc_cert/template/'. $fileName;
	echo json_encode(array("message" => "Image Uploaded Successfully", "status" => true,"template" =>  $template, 'text' => $text));	
}

?>