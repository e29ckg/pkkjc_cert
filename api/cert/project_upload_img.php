<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

include "../connect.php";
include "../function.php";

// $data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
$data = json_decode(file_get_contents("php://input")); // collect input parameters and convert into readable format

$upload_path = '../../img/'; // set upload folder path 

$id = $_POST['id'];

// $fileName  =  $id;
$fileName  =  $_FILES['sendimage']['name'];
$tempPath  =  $_FILES['sendimage']['tmp_name'];
$fileSize  =  $_FILES['sendimage']['size'];

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
	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
	echo $errorMSG;
	exit;
}else{
	// $upload_path = '../../uploads/'; // set upload folder path 
	
	$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
		
	// valid image extensions
	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
					
	// allow valid image file formats
	if(in_array($fileExt, $valid_extensions))
	{				
		//check file not exist our upload folder path
		if(!file_exists($upload_path . $fileName))
		{
			if(!is_dir($upload_path)){
				mkdir($upload_path, 0777);
			}
			// check file size '5MB'
			if($fileSize < 5000000){
				// $fileName = time().'.' .$fileExt;
				$fileName = $id.time().'.' .$fileExt;

				$sql = "SELECT img FROM project WHERE id=$id ";
				$query = $conn->prepare($sql);
				$query->execute();
				$result = $query->fetchAll(PDO::FETCH_OBJ);
				if($result){
					$img = $result[0]->img;
					if($img != '' && file_exists($upload_path . $img)){
						unlink($upload_path . $img);
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
		}
		else
		{		
			$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
			// $errorMSG = json_encode(array("message" => "Sorry, มีภาพนี้อยู่แล้ว", "status" => false));	
			echo $errorMSG;
		}
	}
	else
	{		
		$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
		echo $errorMSG;		
	}
}
		
// if no error caused, continue ....
if(!isset($errorMSG))
{

	$sql = "UPDATE project SET img =:img WHERE id = :id ";        
        $query = $conn->prepare($sql);
        $query->bindParam(':img', $fileName, PDO::PARAM_STR);
        $query->bindParam(':id',$id, PDO::PARAM_INT);
        $query->execute();
	
		$img_link = $fileName;
		// $img_link = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'] . '/pkkjc_cert/img/'. $fileName;
	echo json_encode(array("message" => "Image Uploaded Successfully", "status" => true,"img" =>  $img_link));	
}

?>