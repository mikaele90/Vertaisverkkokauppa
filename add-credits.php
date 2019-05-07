<?php

session_start();

$sql = "UPDATE userDB SET Credits = ? WHERE userId = ?";

if($stmt = mysqli_prepare($link, $sql)){

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ii", $param_credits, $param_id);

    // Set parameters
    $param_credits = null;
    $param_id = $_SESSION["id"];

    if(mysqli_stmt_execute($stmt)){

    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}

mysqli_stmt_close($stmt);
mysqli_close($link);

?>