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

//get id
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//read single
$post->readSingle();

//Create array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'created_at' => $post->created_at,
    'category_name' => $post->category_name
);

print_r(json_encode($post_arr));
?>