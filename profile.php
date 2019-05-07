<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once 'database.php';

if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>

<?php require_once 'nav-bar.php' ?>


<div class="page-header">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
</div>
<div style="display: inline-block">
    <p style="font: 16px sans-serif;">Current account balance: <b><?php echo $_SESSION["credits"]; ?></b>
        <button type="button" class="btn btn-info" id="display_add_credits" onclick="displayAddStoreCredits()">Add balance</button></p>
    <form id="add_store_credits_form" style="display: none">
        <label>Insert amount of store credits to be transferred:
        <input type="number" min="1.00" maxlength="6" id="add_store_credits_input" placeholder="0"> €</label>
        <button type="button" id="confirm_add_store_credits_btn" class="btn btn-success" onclick="addStoreCredits()">Confirm transfer</button>
    </form>
</div>
<hr/>
<p>
    <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
    <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
</p>

</body>
<script type="text/javascript">
    function displayAddStoreCredits() {
        document.getElementById('add_store_credits_form').style.display = 'block';
    }

    function addStoreCredits() {
        console.log('add credits');
        var addCreditsForm = document.getElementById('add_store_credits_form');
        var addCreditsInput = document.getElementById('add_store_credits_input');
        if ((!(addCreditsInput.isEmpty)) && addCreditsInput.value >= 1) {
            console.log('add credits 2');
            var creditsToAdd = Number(addCreditsInput.value);
            var variablesToSend = "credits=" + creditsToAdd;
            var xhr = new XMLHttpRequest();
            var url = "add-credits.php";
            xhr.open("POST", url, true);


            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
<<<<<<< HEAD
                if(xhr.readyState == 4 && xhr.status == 200) {
                    var return_data = xhr.responseText;
                } else {
                    console.log('XHR error');
=======
                if(xhr.readyState === 4 && xhr.status === 200) {
                    console.log('XHR readyState: ' + xhr.readyState + ' // XHR Status: ' + xhr.status);
                    var return_data = xhr.responseText;
                }
                else {
                    console.log('attempting xhr...')
>>>>>>> 0e8e5b3aab8c77f6b90aa687cdff8e8f106e6f22
                }
            };

            xhr.send(variablesToSend); // Request - Send this variable to PHP
<<<<<<< HEAD
=======
            console.log('XHR SENT');
>>>>>>> 0e8e5b3aab8c77f6b90aa687cdff8e8f106e6f22
        }
        else {
            var errorNode = document.createElement('p');
            errorNode.innerHTML = 'Error adding credits: Must be at least 1 euro.';
            addCreditsForm.appendChild(errorNode);
            console.log('add credits error');
        }
    }
</script>
</html>