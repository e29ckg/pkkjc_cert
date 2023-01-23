<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header("'Access-Control-Allow-Credentials', 'true'");
// header('Content-Type: application/javascript');
header("Content-Type: application/json; charset=utf-8");

include "../connect.php";
include "../function.php";

// $data = json_decode(file_get_contents("php://input"));


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
/**
 *           
 */
$datas = array();
$datas_main = array();

    // The request is using the POST method
    try{
        $sql_main = "SELECT pf.*
                FROM profile AS pf";
        $query_main = $conn_main->prepare($sql_main);
        $query_main->execute();        
        $result_main = $query_main->fetchAll(PDO::FETCH_OBJ);
                        

        $sql = "SELECT pr.*
                FROM project AS pr 
                ORDER BY created_at DESC
                LIMIT 20";
        $query = $conn->prepare($sql);
        // $query->bindParam(':kkey',$data->kkey, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);


        if($query->rowCount() > 0){                        //count($result)  for odbc
            foreach($result as $rs){                

                // $sql = "SELECT prt.*
                //         FROM project_template AS prt                
                //         WHERE prt.project_id = $rs->id";
                // $query = $conn->prepare($sql);
                // $query->execute();
                // $res_template = $query->fetchAll(PDO::FETCH_OBJ);

                // $template = array();
                // foreach($res_template as $rst){

                    $sql = "SELECT project_user.*, project_template.template_name 
                            FROM project_user
                            INNER JOIN project_template 
                            ON project_template.id = project_user.project_template_id 
                            WHERE project_user.project_id =  $rs->id ";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $res_pr_u = $query->fetchAll(PDO::FETCH_OBJ);

                    // $sql = "SELECT *
                    //         FROM project_text                
                    //         WHERE project_id = $rs->id AND project_template_id = $rst->id";
                    // $query = $conn->prepare($sql);
                    // $query->execute();
                    // $res_text = $query->fetchAll(PDO::FETCH_OBJ);

                    // array_push($template,array(
                    //     'id'            => $rst->id,
                    //     'project_id'    => $rst->project_id,
                    //     'template_name' => $rst->template_name,
                    //     'size'          => $rst->size,
                    //     'orientation'   => $rst->orientation,
                    //     'template_url'  => $rst->template_url,
                    //     // 'text'          => $rst->text,
                    //     'user'          => $res_pr_u
                    // ));
                // }



                array_push($datas,array(
                    'id'    => $rs->id,
                    'year'  => $rs->year,
                    'name'  => $rs->name,
                    'detail' => $rs->detail,
                    'img' => $rs->img,
                    'date_train'  => $rs->date_train,
                    'period'    => $rs->period,
                    'c_users' => $res_pr_u
                ));
            }

            http_response_code(200);
            echo json_encode(array('status' => true, 'massege' => 'สำเร็จ', 'projects' => $datas));
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