<?php

session_start();

include "database.php";

$credits_to_add = $_POST['credits'];
$credits_to_add = floatval($credits_to_add);

$sql = "SELECT Credits FROM userDB WHERE UserId =  ? ";

if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    $param_id = $_SESSION["id"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $credits);

            if (mysqli_stmt_fetch($stmt)) {
                $_SESSION["credits"] = $credits;

            }
        }
    }
}

mysqli_stmt_close($stmt);

$sql = "UPDATE userDB SET Credits = ? + ? WHERE userId = ?";

if ($stmt = mysqli_prepare($link, $sql)) {

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ddi", $param_user_credits, $param_credits_to_add, $param_id);

    // Set parameters
    $param_user_credits = $_SESSION["credits"];
    $param_credits_to_add = floatval($credits_to_add);

    $param_id = $_SESSION["id"];

    if (mysqli_stmt_execute($stmt)) {
        echo $new_credits = $param_user_credits + $param_credits_to_add;
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}



mysqli_stmt_close($stmt);








mysqli_close($link);



?>



