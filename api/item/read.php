<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../db/Database.php';
include_once '../models/Item.php';

// DB & connect
$database = new Database();
$db = $database->connect();

// Item object
$item = new Item($db);

// Item query
$results = $item->read();
// Get row count
$num_rows = $results->rowCount();

// Check if any items
if($num_rows > 0) {
    // Item array
    $items_array = Array();
    $items_array['data'] = Array();

    while($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = Array(
            'itemid' => $item_id,
            'itemname' => $item_name,
            'itemcategory' => $item_category_name,
            'itemsubcategory' => $item_subcategory_name,
            'itemprice' => $item_price,
            'itemdescription' => $item_description,
            'imagelink' => $item_imagelink,
            'availability' => $item_availability
        );

        // Push to "data"
        array_push($items_array, $post_item);
        array_push($items_array['data'], $post_item);
    }

    // JSON & output
    echo json_encode($items_array);

} else {
    // No Posts
    echo json_encode(
        array('message' => 'Nothing Found')
    );
}
