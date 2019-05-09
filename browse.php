<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'header.php' ?>
</head>
<body>
<?php
require_once 'database.php';
require_once 'nav-bar.php';

$sql = "SELECT * FROM ItemDB";
$productArray = Array();

$boolean_ready_to_exec_html_and_js = false;

if ($stmt = mysqli_prepare($link, $sql)) {

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
                array_push($productArray, $row);
            }
            $boolean_ready_to_exec_html_and_js = true;
            mysqli_free_result($result);
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}
mysqli_stmt_close($stmt);

mysqli_close($link);

?>
<div id="products_div" style="padding: 1.5em; margin= 1em;"></div>
<div id="status" style="width: 20%; margin-left: 1.5em;"></div>
</body>


<script>

    function addFunctionalityToButtons() {
        var buttons = document.getElementsByName("all");

        for (var i = 0; i < buttons.length; i++) {

            buttons[i].onclick = function () {

                /* Vihreä boxi setup */
                var statusElement = document.getElementById("status");
                statusElement.innerHTML = '<div class="alert alert-success">Item added succesfly!</div>';
                var styleAttr = document.createAttribute("style");
                styleAttr.value = "display: none; margin-left: 1.5em;";
                statusElement.setAttributeNode(styleAttr);

                console.log(buttons.length);

                var shopItem = this.parentElement.parentElement;
                var title = shopItem.getElementsByClassName("card")[0].textContent;
                var quantity = shopItem.getElementsByClassName("inputClass")[0].value;
                var variablesToSend = "title=" + title + "&quantity=" + quantity;
                var xhr = new XMLHttpRequest();
                var url = "orderProcess.php";
                xhr.open("POST", url, true);

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var return_data = xhr.responseText;

                        /* Vihreä boxi pop-in */
                        styleAttr.value = "display: inline-block; margin-left: 1.5em;";

                        function callback() {
                            return function () {
                                styleAttr.value = "display: none; margin-left: 1.5em;";
                            }
                        }

                        setTimeout(callback(), 2000);
                    }
                };
                xhr.send(variablesToSend); // Request - Send this variable to PHP

            }
        }
    }

    function displayCompleteProductsList() {

        var jsonArrayFromPhp = <?php echo json_encode($productArray); ?>;
        var strProductArray = JSON.stringify(jsonArrayFromPhp);
        var parsedProductArray = JSON.parse(strProductArray);

        var productsDiv = document.getElementById('products_div');
        productsDiv.innerHTML = '';
        for (var i = 0; i < parsedProductArray.length; i++) {
            var productNode = undefined;
            var product = parsedProductArray[i];
            console.log(JSON.stringify(product));
            productNode = document.createElement('div');
            productNode.setAttribute('class', 'card');
            productNode.innerHTML =
                '<div class="card_div">' +
                '<label class="card"><h1 class="card"> ' + product.ItemName + '</h1></label>' +
                '<img src="images/products/' + product.ImageLink + '.png" alt="' + product.ItemName + ' Picture" style="width:100%">' +
                '<p class="price">' + JSON.stringify(product.ItemPrice) + '€</p>' +
                '<p class="card">' + product.ItemDescription + '</p>' +
                '<label><input type=number min = "1" id = "InputID" value = "1" onKeyDown="return false" class = "inputClass" name="quantity" > kpl</label>' +
                '<p><button class="card" name="all">Add to Cart</button></p>' +
                '</div>';

            productsDiv.appendChild(productNode);
        }
        addFunctionalityToButtons()
    }


    if (<?php echo $boolean_ready_to_exec_html_and_js ?>) {
        displayCompleteProductsList();
    } else alert("Fatal db error, try again later.");





</script>
</html>

