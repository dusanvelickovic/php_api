<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    
    // instantiate db
    $database = new Database();
    $db = $database->connect();

    // instantiate category
    $category = new Category($db);

    // read query
    $result = $category->read();

    $num = $result->rowCount();

    if($num > 0){
        $categoryArr = array();
        $categoryArr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $categoryItem = array(
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );

            array_push($categoryArr['data'], $categoryItem);
        }

        echo json_encode($categoryArr);
    } else{
        echo json_encode(
            array('message' => "No categories found")
        );
    }
?>