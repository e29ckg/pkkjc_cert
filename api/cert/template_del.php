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

    try{
        $template     = $data->template;
        $id     = $template->id;

        unlink('../../template/'.$template->template_url);
        $sql = "DELETE FROM project_template WHERE id = $id";
        $conn->exec($sql);

        $sql = "DELETE FROM project_text WHERE project_template_id = $id";
        $conn->exec($sql);

        $sql = "DELETE FROM project_user WHERE project_template_id = $id";
        $conn->exec($sql);

        http_response_code(200);
        echo json_encode(array('status' => true, 'message' => 'DEL ok', 'tm_url' => '../../'.$template->template_url));
        exit;                
       
          
        
        
    }catch(PDOException $e){
        // echo "Faild to connect to database" . $e->getMessage();
        http_response_code(400);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
    }
}



