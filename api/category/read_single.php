<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    
    $database = new Database();
    $db = $database->connect();

    // isntantiate category object
    $category = new Category($db);

    // check if id is set
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    $category->read_single();

    $categoryArr = array(
        'id' => $category->id,
        'name' => $category->name,
        'created_at' => $category->created_at
    );
    print_r(json_encode($categoryArr));
?>