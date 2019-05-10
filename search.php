<?php
require_once "database.php";

$search_value = "";
$search_value_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM ItemDB WHERE ItemName LIKE ? ";
    $searchArray = Array();
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_search_value);

        // Set parameters
        $search_value = strtolower(trim($_POST[strip_tags("search")]));
        $param_search_value = $search_value;

        //try to execute statement
        if (mysqli_stmt_execute($stmt)) {

            //store query results to result variable
            //get the amount of rows in the query and assign it to the $num_rows variable
            $result = mysqli_stmt_get_result($stmt);
            $num_rows = mysqli_num_rows($result);

            if ($num_rows == 0) {
                echo $search_value_err = "Search didnt find any results.";
            } else {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    array_push($searchArray, $row);
                }
                mysqli_free_result($result);
            }
        } else {
            //pitäsköhän täs olla näi muute dispayCompleteProductsList kusee
            //koska jos tää kusee toi js ei saa tota searchArrayt ja flippaa palasiks siks se tuol varotteliiki
            //("location: profile.php");
            //header
            //exit;
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'header.html'?>
</head>
<body>
    <?php require_once "nav-bar.html" ?>
    <div id="products_div" style="padding: 1.5em; margin= 1em;"></div>
    <div id="status" style="width: 20%; margin-left: 1.5em;"></div>
</body>
<script type="text/javascript">

    function addFunctionalityToButtons () {
        var buttons = document.getElementsByName("all");

        for(var i = 0; i < buttons.length; i++) {

            buttons[i].onclick = function() {

                /* Vihreä boxi setup */
                var statusElement = document.getElementById("status");
                statusElement.innerHTML = '<div class="alert alert-success">Tuote lisätty onnistuneesti!</div>';
                var styleAttr = document.createAttribute("style");
                styleAttr.value = "display: none; margin-left: 1.5em;";
                statusElement.setAttributeNode(styleAttr);

                console.log(buttons.length);

                var shopItem = this.parentElement.parentElement;
                var title = shopItem.getElementsByClassName("card")[0].textContent;
                var quantity = shopItem.getElementsByClassName("inputClass")[0].value;
                var variablesToSend = "title="+title+"&quantity="+quantity;
                var xhr = new XMLHttpRequest();
                var url = "orderProcess.php";
                xhr.open("POST", url, true);

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if(xhr.readyState === 4 && xhr.status === 200) {
                        var return_data = xhr.responseText;

                        /* Vihreä boxi pop-in */
                        styleAttr.value = "display: inline-block; margin-left: 1.5em;";

                        function callback(){
                            return function(){
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

        var jsonArrayFromPhp = <?php echo json_encode($searchArray); ?>;
        var strSearchArray = JSON.stringify(jsonArrayFromPhp);
        var parsedSearchArray = JSON.parse(strSearchArray);

        var productsDiv = document.getElementById('products_div');
        productsDiv.innerHTML = '';
        for (var i = 0; i < parsedSearchArray.length; i++) {
            var productNode = undefined;
            var product = parsedSearchArray[i];
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

    displayCompleteProductsList();

</script>
</html>
