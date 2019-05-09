<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$boolean_ready_to_exec_html_and_js = false;

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
                echo '';
            } else {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    array_push($shopping_cart_array, $row);
                }
                mysqli_free_result($result);
                $boolean_ready_to_exec_html_and_js = true;
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
    <hr/>
    <div id="buy_button_div"><button id="buy_button" class="btn btn-success" onclick="buyItems()">Osta tuotteet</button></div>
</body>
<script type="text/javascript">
    function displayCartContents() {

        var jsonArrayFromPhp = <?php echo json_encode($shopping_cart_array); ?>;
        var strCartArray = JSON.stringify(jsonArrayFromPhp);
        var parsedCartArray = JSON.parse(strCartArray);
        var orderTotal = 0;
        var cartTotal = 0;

        var shoppingCartDiv = document.getElementById('shopping_cart_div');
        shoppingCartDiv.innerHTML = '<h2>Ostoskori</h2>';
        if (parsedCartArray.length === 0) {
            shoppingCartDiv.innerHTML =
                '<h2>Ostoskori</h2>' +
                '<br><p>Ostoskori on tyhjä</p>';
            document.getElementById('buy_button').setAttribute('class','btn btn-success disabled');
            document.getElementById('buy_button').setAttribute('onclick','');
            return 0;
        } else {
            document.getElementById('buy_button').setAttribute('class','btn btn-success');
            document.getElementById('buy_button').setAttribute('onclick','buyItems()');
        }
        var shoppingCartHeaders = ['#', 'Quantity', 'Product number', 'Product name', 'Price á', 'Total price', 'Remove from cart'];
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
            cartTdNode.innerHTML = parseFloat(parsedCartArray[j].ItemPrice).toFixed(2) + ' €';
            cartTrNode.appendChild(cartTdNode);
            cartTdNode = document.createElement('td');
            orderTotal = (parseFloat(parsedCartArray[j].Quantity).toFixed(0) * parseFloat(parsedCartArray[j].ItemPrice).toFixed(2)).toFixed(2);
            cartTotal += parseFloat(orderTotal);
            cartTdNode.innerHTML = orderTotal + ' €';
            cartTrNode.appendChild(cartTdNode);
            cartTdNode = document.createElement('td');
            cartTdNode.innerHTML = '<button class="btn btn-secondary" id=remove_button>Remove</button>';
            cartTrNode.appendChild(cartTdNode);
        }
        cartTrNode = document.createElement('tr');
        cartTableNode.appendChild(cartTrNode);
        for (var k = 0; k < (shoppingCartHeaders.length - 2); k++) {
            cartThNode = document.createElement('th');
            cartTrNode.appendChild(cartThNode);
        }
        cartThNode = document.createElement('th');
        cartThNode.innerHTML = parseFloat(cartTotal).toFixed(2) + ' €';
        cartTrNode.appendChild(cartThNode);
        return cartTotal;
    }

    function buyItems() {
        var variablesToSend = "cartTotal=" + cartTotal;
        var xhr = new XMLHttpRequest();
        var url = "buy-items.php";
        xhr.open("POST", url, true);

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {
                var return_data = xhr.responseText;
                console.log(return_data);
                console.log('Return: ' + return_data);
                if (return_data === 'Not enough credits on account') {
                    var shoppingCartDiv = document.getElementById('shopping_cart_div');
                    shoppingCartDiv.innerHTML =
                        '<h2>Ostoskori</h2>' +
                        '<br><p>Massit loppu!</p>';
                    document.getElementById('buy_button').setAttribute('class','btn btn-success disabled');
                    document.getElementById('buy_button').setAttribute('onclick','');
                    return 0;
                }
            } else {
                console.log('XHR attempt...');
            }

        };

        xhr.send(variablesToSend); // Request - Send this variable to PHP

        console.log('XHR SENT');
    }

    if (<?php echo $boolean_ready_to_exec_html_and_js ?>) {
        var cartTotal = displayCartContents();
        console.log(cartTotal);
    } else alert("Fatal db error, try again later.");


</script>
</html>