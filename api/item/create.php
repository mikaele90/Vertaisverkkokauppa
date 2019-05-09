<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../db/Database.php';
include_once '../models/Item.php';

// DB & connect
$database = new Database();
$db = $database->connect();

// Item object
$item = new Item($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$item->item_name = $data->itemname;
$item->item_description = $data->itemdescription;
$item->item_price = $data->itemprice;
$item->item_category_name = $data->itemcategory;

// Create item
if($item->create()) {
    echo json_encode(Array('message' => 'Item Created'));
} else {
    echo json_encode(Array('message' => 'Item Not Created'));
}

