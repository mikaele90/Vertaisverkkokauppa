<?php
// Initialize the session
session_start();
require_once 'database.php';

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

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
    <?php require_once 'header.html' ?>
    <title>Profile Page</title>
</head>
<body>

<?php require_once "nav-bar.html" ?>


<div class="page-header">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
</div>
<div style="display: inline-block">
    <p id="current_balance_p" style="font: 16px sans-serif;">Current account balance:
        <b> <?php echo $_SESSION["credits"] ?> </b>
        <button type="button" class="btn btn-info" id="display_add_credits" onclick="displayAddStoreCredits()">Add
            balance
        </button>
    </p>
    <form id="add_store_credits_form" style="display: none">
        <label>Insert amount of store credits to be transferred:
            <input type="number" min="1.00" maxlength="6" id="add_store_credits_input" placeholder="0"> €
        </label>
        <button type="button" id="confirm_add_store_credits_btn" class="btn btn-success" onclick="addStoreCredits()">
            Confirm transfer
        </button>
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
            //Should be float_val here, i can wish...
            var creditsToAdd = Number(addCreditsInput.value).toFixed(2);
            var variablesToSend = "credits=" + creditsToAdd;
            var xhr = new XMLHttpRequest();
            var url = "add-credits.php";
            xhr.open("POST", url, true);


            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {

                if (xhr.readyState === 4 && xhr.status === 200) {
                    var return_data = JSON.parse(xhr.responseText);
                    console.log(return_data);
                    document.getElementById('current_balance_p').innerHTML = 'Current account balance: <b>' + return_data + '</b> ' +
                        '<button type="button" class="btn btn-info" id="display_add_credits" onclick="displayAddStoreCredits()">Add balance' +
                        '</button>';
                    console.log('Return: ' + return_data);
                } else {
                    console.log('XHR attempt...');
                }

            };

            xhr.send(variablesToSend); // Request - Send this variable to PHP

            console.log('XHR SENT');


        } else {
            var errorNode = document.createElement('p');
            errorNode.innerHTML = 'Error adding credits: Must be at least 1 euro.';
            addCreditsForm.appendChild(errorNode);
            console.log('add credits error');
        }
    }
</script>
</html>