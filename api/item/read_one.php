<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Item.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog item object
$post = new Item($db);

// Get ID
$post->item_id = isset($_GET['id']) ? $_GET['id'] : die();

// Get item
$post->read_single();

// Create array
$post_arr = array(
    'id' => $post->item_id,
    'title' => $post->item_subcategory_name,
    'body' => $post->item_price,
    'author' => $post->item_description,
    'category_id' => $post->item_name,
    'category_name' => $post->item_category_name
);

// Make JSON
print_r(json_encode($post_arr));