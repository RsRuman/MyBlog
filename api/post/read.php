<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/Post.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//blog post query
$result = $post->read();

//get row count
$num = $result->rowCount();

//check if any post exist or not
if($num > 0){
    //Post array
    $posts_arr = array();
    $posts_arr['data'] = array();
    
    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );
        
        //push array to data
        array_push($posts_arr['data'], $post_item);
    }
    
    //turn to JSON & output
    echo json_encode($posts_arr);
}
else
{
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}

?>