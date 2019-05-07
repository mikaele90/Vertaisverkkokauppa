<?php

session_start();

include "database.php";

$credits_to_add = $_POST['credits'];

$sql = "UPDATE userDB SET Credits = (? + ?) WHERE userId = ?";

if($stmt = mysqli_prepare($link, $sql)){

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ddi", $param_credits, $param_credits_to_add,  $param_id);

    // Set parameters
    $param_user_credits = $_SESSION["credits"];
    $param_credits_to_add = $credits_to_add;
    $param_id = $_SESSION["id"];

    if(mysqli_stmt_execute($stmt)){

    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}

mysqli_stmt_close($stmt);
mysqli_close($link);

?>



