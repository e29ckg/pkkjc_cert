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
/**
 *           
 */
$datas = array();
$datas_main = array();

$project_id = $data->id;
    // The request is using the POST method
    try{
        $sql = "SELECT *
                FROM project_user 
                WHERE project_id = $project_id";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);


        if($query->rowCount() > 0){                        //count($result)  for odbc
            // foreach($result as $rs){                
                
                // array_push($datas,array(
                //     'id'    => $rs->id,
                //     'year'  => $rs->year,
                //     'name'  => $rs->name,
                //     'detail' => $rs->detail,
                //     'img' => $rs->img,
                //     'date_train'  => $rs->date_train,
                //     'period'    => $rs->period,
                //     // 'template'  => $template,
                // ));
            // }

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'สำเร็จ', 'c_users' => $result));
            exit;
        }
     
        http_response_code(200);
        echo json_encode(array('status' => false, 'message' => 'ไม่พบข้อมูล '));
    
    }catch(PDOException $e){
        // echo "Faild to connect to database" . $e->getMessage();
        http_response_code(400);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
    }
}