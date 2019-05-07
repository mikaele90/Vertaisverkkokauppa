<?php
session_start();


echo 'Thank you '. $_POST['title'] . ' ' . $_POST['quantity'] . ', says the PHP file';


// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: registerform.php");
    exit;
}

$item_name = $_POST['title'];
$item_quantity = $_POST['quantity'];
$user_id = $_SESSION["id"];
$readyToExecNextQuery = false;

require_once 'database.php';
require_once 'nav-bar.php';

//MUISTA USERILLA PITÄÄ OLLA RAHAT!!!! ELI OTA HUOMIOON


$sql="SELECT ItemId, ItemPrice FROM itemdb WHERE ItemName = ?";

if($stmt = mysqli_prepare($link, $sql)){

    mysqli_stmt_bind_param($stmt, "s", $param_item_name);

    $param_item_name = trim($item_name);

    if(mysqli_stmt_execute($stmt)){
        /* store result */
        //mysqli_stmt_store_result($stmt);


        $result = mysqli_stmt_get_result($stmt);
        $num_rows = mysqli_num_rows($result);
        $jsonResult = json_encode($result);

        if($num_rows == 0){
            echo $browse_value_err = "No results to display.";
        } else{
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $final_item_id = $row["ItemId"];
                $final_item_price = $row["ItemPrice"];
            }
            mysqli_free_result($result);
            $readyToExecNextQuery = true;
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}

mysqli_stmt_close($stmt);


$sql="INSERT INTO orderdb (Quantity, ItemId, UserId) VALUES (?, ?, ?)";

if ($readyToExecNextQuery == true) {

    if($stmt = mysqli_prepare($link, $sql)){

        mysqli_stmt_bind_param($stmt, "iii", $param_quantity, $param_itemId, $param_user_id);

        $param_quantity = $item_quantity;
        $param_itemId = $final_item_id;
        $param_user_id = $user_id;



        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: login.php");
        } else{
            echo "Something went wrong. Please try again later.";
        }

    }
    mysqli_stmt_close($stmt);



}

mysqli_close($link);




?>