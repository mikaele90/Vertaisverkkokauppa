<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vertaisverkkokauppa :: Browse ::</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/color-star-3-152-217610.png">
    <link rel="stylesheet" href="css/styles.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; align-content: center}
    </style>

</head>
<body>
<?php
require_once 'database.php';
require_once 'nav-bar.php';

$sql="SELECT * FROM itemDB";
$productArray = Array();


if($stmt = mysqli_prepare($link, $sql)){

    if(mysqli_stmt_execute($stmt)){
        /* store result */
        //mysqli_stmt_store_result($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $num_rows = mysqli_num_rows($result);
        $jsonResult = json_encode($result);

        if($num_rows == 0){
            echo $browse_value_err = "No results to display.";
        } else{
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                array_push($productArray, $row);
            }
            mysqli_free_result($result);
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}

?>
<div id="products_div">

</div>
</body>
<script>

    function addFunctionalityToButtons () {
        var buttons = document.getElementsByName("all");

        for(var i = 0; i <= buttons.length; i++) {

            buttons[i].onclick = function() {

                var shopItem = this.parentElement.parentElement;
                var title = shopItem.getElementsByClassName("idiot")[0].textContent;
                console.log(title);

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
                '<h1 class="idiot"  > ' + product.ItemName + '</h1>' +
                '<img src="images/products/' + product.ImageLink + '.png" alt="Denim Jeans" style="width:100%">' +
                '<p class="price">' + JSON.stringify(product.ItemPrice) + '€</p>' +
                '<p class="card">' + product.ItemDescription + '</p>' +
                '<p><button class="card" name="all"> Add to Cart</button></p>'
            productsDiv.appendChild(productNode);
        }
        addFunctionalityToButtons()
    }

    displayCompleteProductsList();

</script>
</html>

