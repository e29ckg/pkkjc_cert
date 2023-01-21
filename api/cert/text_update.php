<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header("'Access-Control-Allow-Credentials', 'true'");
// header('Content-Type: application/javascript');
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
include "../function.php";

$data = json_decode(file_get_contents("php://input"));

// http_response_code(200);
// echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $data));
// exit; 

// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $datas = array();    
    $project_text = $data->text;
    $template = $data->template;
    
    try{
        

            $id         = $project_text->id;
            $text_name  = $project_text->text_name;
            $text_font  = $project_text->text_font;
            $text_size  = $project_text->text_size;
            $text_y     = $project_text->text_y;

            $template_id =$template->id;
            $template_name =$template->template_name;

            $sql = "UPDATE project_text 
                    SET text_name =:text_name, 
                        text_font = :text_font, 
                        text_size =:text_size, 
                        text_y = :text_y                         
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':text_name',$text_name, PDO::PARAM_STR);
            $query->bindParam(':text_font',$text_font, PDO::PARAM_STR);
            $query->bindParam(':text_size',$text_size, PDO::PARAM_INT);
            $query->bindParam(':text_y',$text_y, PDO::PARAM_INT);
            $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->execute();    

            $sql = "UPDATE project_template
                    SET template_name =:template_name             
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':template_name',$template_name, PDO::PARAM_STR);
            $query->bindParam(':id',$template_id, PDO::PARAM_STR);
            $query->execute();    

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $project_text));
            exit;                
        
        
          
        
        
    }catch(PDOException $e){
        // echo "Faild to connect to database" . $e->getMessage();
        http_response_code(400);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
    }
}



