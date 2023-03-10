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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$template = $data->template;
$users = $data->users;
$datas = array();

    // The request is using the POST method
    try{
        
            foreach($users as $rs){
                if(isset($rs->ch) && $rs->ch == true){

                    $name = $rs->fname.$rs->name.' '.$rs->sname;
                    $user_status = 1;
                    $active = 1;
    
                    $project_template_id = $template->id;
                    $project_id             = $template->project_id;
    
                    $sql = "INSERT INTO project_user(project_id, project_template_id, user_id, name, user_status, active) 
                        VALUE(:project_id, :project_template_id, :user_id, :name, :user_status, :active);";        
                    $query = $conn->prepare($sql);
                    $query->bindParam(':project_id',$project_id, PDO::PARAM_STR);
                    $query->bindParam(':project_template_id',$project_template_id, PDO::PARAM_STR);
                    $query->bindParam(':user_id',$rs->user_id, PDO::PARAM_INT);
                    $query->bindParam(':name',$name, PDO::PARAM_STR);
                    $query->bindParam(':user_status',$user_status, PDO::PARAM_INT);
                    $query->bindParam(':active',$active, PDO::PARAM_INT);
                    $query->execute();
                }


                // array_push($datas,array(
                //     'id'    => $rs->id,
                //     'name'  => $rs->name,
                //     'DN'  => $rs->DN,
                //     'srt'  => $rs->srt
                // ));
            }
            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => '??????????????????', 'data' => $data,'user'=>$users));
            exit;
     
     
        // http_response_code(200);
        // echo json_encode(array('false' => true, 'message' => '????????????????????????????????? '));
    
    }catch(PDOException $e){
        // echo "Faild to connect to database" . $e->getMessage();
        http_response_code(400);
        echo json_encode(array('status' => false, 'message' => '??????????????????????????????????????????..' . $e->getMessage()));
    }
}