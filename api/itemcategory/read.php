<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../db/Database.php';
include_once '../models/ItemCategory.php';

// DB & connect
$database = new Database();
$db = $database->connect();

// ItemCategory object
$category = new ItemCategory($db);

// ItemCategory read query
$result = $category->read();

// Get row count
$num = $result->rowCount();

// Check if any categories
if($num > 0) {
    // Cat array
    $category_array = Array();
    $category_array['data'] = Array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $single_category = Array(
            'itemid' => $item_id,
            'itemname' => $item_name,
            'itemcategory' => $item_category_name,
            'itemsubcategory' => $item_subcategory_name
        );

        // Push
        array_push($category_array['data'], $single_category);
    }

    // JSON & output
    echo json_encode($category_array);

} else {
    // No Categories
    echo json_encode(
        array('message' => 'Nothing Found')
    );
}
