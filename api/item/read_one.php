<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../db/Database.php';
include_once '../models/Item.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog item object
$item = new Item($db);

// Get ID
$item->item_id = isset($_GET['itemid']) ? $_GET['itemid'] : die();

// Get item
$item->read_one();

// Create array
$item_array = array(
    'itemid' => $item->item_id,
    'itemname' => $item->item_name,
    'itemcategory' => $item->item_category_name,
    'itemsubcategory' => $item->item_subcategory_name,
    'itemprice' => $item->item_price,
    'itemdescription' => $item->item_description,
    'imagelink' => $item->item_imagelink,
    'availability' => $item->item_availability
);

// Make JSON
print_r(json_encode($item_array));