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
    $project = $data->project;
    $id = date("Ymdhis");
    
    try{
        if($project->act == 'insert'){
            if($project->name == ''){
                http_response_code(200);
                echo json_encode(array('status' => false, 'message' => 'no name'));
                exit;
            }
            $created_at = date("Y-m-d h:i:s");
            if(isset($project->date_train)){

                $date_train = date("Y-m-d h:i:s",$project->date_train);
            }

            $sql = "INSERT INTO project(id, project.year, `name`, date_train, detail, period, created_at) 
                    VALUE(:id, :year, :name, :date_train, :detail, :period, :created_at);";        
            $query = $conn->prepare($sql);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query->bindParam(':year',$project->year, PDO::PARAM_STR);
            $query->bindParam(':name',$project->name, PDO::PARAM_STR);
            $query->bindParam(':date_train',$date_train, PDO::PARAM_STR);
            $query->bindParam(':detail',$project->detail, PDO::PARAM_STR);            
            $query->bindParam(':period',$project->period, PDO::PARAM_INT);            
            $query->bindParam(':created_at',$created_at);
            $query->execute();

            // $sql = "INSERT INTO project_template(project_id, template_name, size, orientation) 
            //         VALUE(:project_id, 'ผู้เข้าร่วม', 'A4', 'L');";        
            // $query = $conn->prepare($sql);
            // $query->bindParam(':project_id',$id, PDO::PARAM_STR);
            // $query->execute();

            // $sql = "INSERT INTO project_text(project_id, project_template_id, text_name, text_size, text_font, text_y) 
            //         VALUE(:project_id, :project_template_id, 'ชื่อ - สกุล', 36, 'prompt', 69);";        
            // $query = $conn->prepare($sql);
            // $query->bindParam(':project_id',$id, PDO::PARAM_STR);
            // $query->bindParam(':project_template_id',$id, PDO::PARAM_STR);
            // $query->execute();

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok'));
            exit;                
        } 

        if($project->act == 'update'){
            $id      = $project->id;
            $name    = $project->name;
            $year    = $project->year;
            $date_train    = $project->date_train;
            $detail    = $project->detail;
            $period    = $project->period;

            $sql = "UPDATE project 
                    SET name =:name, 
                        year =:year, 
                        date_train = :date_train, 
                        detail = :detail, 
                        period = :period                         
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':name',$name, PDO::PARAM_STR);
            $query->bindParam(':year',$year, PDO::PARAM_STR);
            $query->bindParam(':date_train',$date_train, PDO::PARAM_STR);
            $query->bindParam(':date_train',$date_train, PDO::PARAM_STR);
            $query->bindParam(':detail',$detail, PDO::PARAM_STR);
            $query->bindParam(':period',$period, PDO::PARAM_STR);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query->execute();    

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $project));
            exit;                
        }  
        if($project->act == 'name_y_update'){
            $id      = $project->id;
            $name_y    = $project->name_y;

            $sql = "UPDATE project_template 
                    SET name_y =:name_y                       
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':name_y',$name_y, PDO::PARAM_INT);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query->execute();    

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $project));
            exit;                
        }  
        if($project->act == 'name_font_update'){
            $id      = $project->id;
            $name_font    = $project->name_font;

            $sql = "UPDATE project_template 
                    SET name_font =:name_font                       
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':name_font',$name_font, PDO::PARAM_INT);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query->execute();    

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $project));
            exit;                
        }  
        if($project->act == 'name_font_size_update'){
            $id      = $project->id;
            $name_font_size    = $project->name_font_size;

            $sql = "UPDATE project 
                    SET name_font_size =:name_font_size                       
                    WHERE id = :id";   

            $query = $conn->prepare($sql);
            $query->bindParam(':name_font_size',$name_font_size, PDO::PARAM_INT);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query->execute();    

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'ok', 'responseJSON' => $project));
            exit;                
        }  
        if($project->act == 'del'){
            $id     = $project->id;
            $sql = "DELETE FROM project WHERE id = $id";
            $conn->exec($sql);

            $sql = "SELECT prt.*
                    FROM project_template AS prt                
                    WHERE prt.project_id = $id";
            $query = $conn->prepare($sql);
            $query->execute();
            $res_template = $query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0){
                foreach($res_template as $rtm){

                    // if(!($rtm->template == '' || $rtm->template == null)){    
                        unlink('../../template/'.$rtm->template_url);
                    // }
                }
            }

            $sql = "DELETE FROM project_template WHERE project_id = $id";
            $conn->exec($sql);

            $sql = "DELETE FROM project_text WHERE project_id = $id";
            $conn->exec($sql);

            $sql = "DELETE FROM project_user WHERE project_id = $id";
            $conn->exec($sql);

            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'DEL ok'));
            exit;                
        }  
          
        
        
    }catch(PDOException $e){
        // echo "Faild to connect to database" . $e->getMessage();
        http_response_code(400);
        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด..' . $e->getMessage()));
    }
}



