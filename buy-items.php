<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION["id"];
    $credits = $_SESSION["credits"];
    $cart_total = $_POST["cartTotal"];
    if ($credits < $cart_total) {
        echo 'Not enough credits on account';
        exit;
    }
    echo $cart_total;

    $sql = "UPDATE UserDB SET Credits = ? - ? WHERE UserId = ?";
    $sql2 = "UPDATE OrderDB SET IsBought = ? WHERE OrderDB.UserId = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ddi", $param_current_user_credits, $param_buy_cost, $param_user_id);

        // Set parameters
        $param_current_user_credits = floatval($credits);
        $param_buy_cost = floatval($cart_total);
        $param_user_id = $user_id;

        if (mysqli_stmt_execute($stmt)) {
            echo $new_credits = $param_current_user_credits - $param_buy_cost;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    mysqli_stmt_close($stmt);

    if ($stmt = mysqli_prepare($link, $sql2)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_is_bought_boolean, $param_user_id);

        // Set parameters
        $param_is_bought_boolean = 1;
        $param_user_id = $user_id;

        if (mysqli_stmt_execute($stmt)) {
            echo 'Items bought';
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}