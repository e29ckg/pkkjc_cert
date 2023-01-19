<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header("'Access-Control-Allow-Credentials', 'true'");
// header('Content-Type: application/javascript');
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
// include "../function.php";

$data = json_decode(file_get_contents("php://input"));


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
/**
 *           
 */
// $da = $data->da; 
$pro_user_id = $data->id;

$datas = array();
$datas_main = array();

    // The request is using the POST method
    try{
       
        $sql = "SELECT pr_u.*, pr_u.name as uname, pr.*
                FROM project_user AS pr_u
                INNER JOIN project AS pr ON pr_u.project_id = pr.id
                WHERE pr_u.id = $pro_user_id";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);


        if($query->rowCount() > 0){                        //count($result)  for odbc
            // foreach($result as $rs){

                // array_push($datas,array(
                //     'id' => $rs->id,
                //     'year' => $rs->year,
                //     'name' => $rs->name,
                //     'date_train'  => $rs->date_train,
                //     'period'  => $rs->period,
                //     'project_user'  => $res_pr_u
                // ));
            // }

            http_response_code(200);
            echo json_encode(array(
                'status'    => true, 
                'massege'   => 'สำเร็จ', 
                'resp'      => $result));
            exit;
        }
     
        http_response_code(200);
        echo json_encode(array('false' => true, 'massege' => 'ไม่พบข้อมูล '));
    
    }catch(PDOException $e){
        // echo "Faild to connect to database" . $e->getMessage();
        http_response_code(400);
        echo json_encode(array('status' => false, 'massege' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
    }
}