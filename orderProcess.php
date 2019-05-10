<?php
session_start();

//echo 'Thank you ' . $_POST['title'] . ' ' . $_POST['quantity'] . ', says the PHP file';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$item_name = $_POST['title'];
$item_quantity = $_POST['quantity'];
$user_id = $_SESSION["id"];
$readyToExecNextQuery = false;

require_once 'database.php';

//MUISTA USERILLA PITÄÄ OLLA RAHAT!!!! ELI OTA HUOMIOON

$final_item_price = "";

$sql = "SELECT ItemId, ItemPrice FROM itemdb WHERE ItemName = ?";

if ($stmt = mysqli_prepare($link, $sql)) {

    mysqli_stmt_bind_param($stmt, "s", $param_item_name);

    $param_item_name = trim($item_name);

    if (mysqli_stmt_execute($stmt)) {
        /* store result */
        //mysqli_stmt_store_result($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $num_rows = mysqli_num_rows($result);
        $jsonResult = json_encode($result);

        if ($num_rows == 0) {
            echo $browse_value_err = "No results to display.";
        } else {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $final_item_id = $row["ItemId"];
                $final_item_price = $row["ItemPrice"];
            }
            mysqli_free_result($result);
            $readyToExecNextQuery = true;
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

mysqli_stmt_close($stmt);


$sql1 = "SELECT Credits FROM userdb WHERE userId = ?";


$readyToExecNextQuery2 = false;

if ($readyToExecNextQuery == true) {

    if ($stmt1 = mysqli_prepare($link, $sql1)) {

        mysqli_stmt_bind_param($stmt1, "i", $user_id);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt1)) {
            // Store result
            mysqli_stmt_store_result($stmt1);

            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt1) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt1, $Credits);
                if (mysqli_stmt_fetch($stmt1)) {

                    $user_credits = $Credits;

                    if ((floatval($final_item_price) * floatval($item_quantity)) <= $user_credits) {
                        $readyToExecNextQuery2 = true;

                    }

                }
                // lisää elset
            }

        }

    }
    mysqli_stmt_close($stmt1);

}

$sql2 = "INSERT INTO orderdb (Quantity, ItemId, UserId) VALUES (?, ?, ?)";

if ($readyToExecNextQuery2 == true) {

    if ($stmt2 = mysqli_prepare($link, $sql2)) {
        mysqli_stmt_bind_param($stmt2, "iii", $param_quantity, $param_itemId, $param_user_id);
        $param_quantity = $item_quantity;
        $param_itemId = $final_item_id;
        $param_user_id = $user_id;

        if (mysqli_stmt_execute($stmt2)) {
            // Redirect to login page
            header("location: login.php");
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt2);


}

mysqli_close($link);
