<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: registerform.php");
    exit;
}

if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === true) {
    $sql="SELECT * FROM OrderDB INNER JOIN ItemDB ON OrderDB.ItemId = ItemDB.ItemId WHERE OrderDB.UserId = ? AND OrderDB.IsBought = ?;";
    $shopping_cart_array = Array();

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $param_user_id, $param_is_bought);

        $param_user_id = $_SESSION["id"];
        $param_is_bought = 0;

        if (mysqli_stmt_execute($stmt)) {
            /* store result */
            //mysqli_stmt_store_result($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $num_rows = mysqli_num_rows($result);
            $jsonResult = json_encode($result);

            if ($num_rows === 0) {
                echo $cart_value_err = "No results to display.";
            } else {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    array_push($shopping_cart_array, $row);
                }
                mysqli_free_result($result);
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'header.php' ?>
</head>
<body>
<?php require_once 'nav-bar.php'; ?>
<div id="shopping_cart_div"></div>
</body>
<script type="text/javascript">
    function displayCartContents() {

        var jsonArrayFromPhp = <?php echo json_encode($shopping_cart_array); ?>;
        var strCartArray = JSON.stringify(jsonArrayFromPhp);
        var parsedCartArray = JSON.parse(strCartArray);

        var shoppingCartDiv = document.getElementById('shopping_cart_div');
        shoppingCartDiv.innerHTML = '<p>Ostoskori</p>';
        var shoppingCartHeaders = ['#', 'Quantity', 'Product number', 'Product name', 'Price á', 'Total price'];
        var cartTableNode = document.createElement('table');
        cartTableNode.setAttribute('class', 'shopping_cart_table');

        var cartTdNode = document.createElement('td');
        var cartTrNode = document.createElement('tr');
        var cartThNode = document.createElement('th');

        shoppingCartDiv.appendChild(cartTableNode);
        cartTableNode.appendChild(cartTrNode);
        for (var i = 0; i < shoppingCartHeaders.length; i++) {
            cartThNode = document.createElement('th');
            cartThNode.innerHTML = shoppingCartHeaders[i];
            cartTrNode.appendChild(cartThNode);
        }
        for (var j = 0; j < parsedCartArray.length; j++) {
            cartTrNode = document.createElement('tr');
            cartTableNode.appendChild(cartTrNode);
            cartTdNode = document.createElement('td');
            cartTdNode.innerHTML = parsedCartArray[j].OrderId;
            cartTrNode.appendChild(cartTdNode);
            cartTdNode = document.createElement('td');
            cartTdNode.innerHTML = parsedCartArray[j].Quantity;
            cartTrNode.appendChild(cartTdNode);
            cartTdNode = document.createElement('td');
            cartTdNode.innerHTML = parsedCartArray[j].ItemId;
            cartTrNode.appendChild(cartTdNode);
            cartTdNode = document.createElement('td');
            cartTdNode.innerHTML = parsedCartArray[j].ItemName;
            cartTrNode.appendChild(cartTdNode);
            cartTdNode = document.createElement('td');
            cartTdNode.innerHTML = parseFloat(parsedCartArray[j].ItemPrice).toFixed(2);
            cartTrNode.appendChild(cartTdNode);
            cartTdNode = document.createElement('td');
            cartTdNode.innerHTML = (parseFloat(parsedCartArray[j].Quantity).toFixed(0) * parseFloat(parsedCartArray[j].ItemPrice).toFixed(2)).toFixed(2);
            cartTrNode.appendChild(cartTdNode);
        }
    }

    displayCartContents();
</script>
</html>