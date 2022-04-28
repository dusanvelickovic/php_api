<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate db & connect
    $database = new Database();
    $db = $database->connect();

    // instantiate blog post object
    $post = new Post($db);

    // blog post query
    $result = $post->read();
    // get row count
    $num = $result->rowCount();

    // check if any post
    if($num > 0){
        $postsArr = array();
        $postsArr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $postItem = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            // push to 'data'
            array_push($postsArr['data'], $postItem);
        }

        // turn it to json & output
        echo json_encode($postsArr);
    } else {
        echo json_encode(
            array('message' => 'No posts found')
        );
    }
?>