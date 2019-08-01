<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
//header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
//Access-Control-Allow-Methods, Authorization, X-Request-With');

include_once '../../config/Database.php';
include_once '../../model/Post.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set id
$post->id = $data->id;

//Call delete function
if ($post->delete()){
    echo json_encode(array('message'=>'Post deleted successfully.'));
}else{
    echo json_encode(array('message'=>'Post not deleted'));
}
