<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vertaisverkkokauppa :: Browse ::</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="images/color-star-3-152-217610.png">

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
        echo "lol";
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
</body>
<script>
    function getCompleteProductsList() {


        var jsonArrayFromPhp = <?php echo json_encode($productArray) ?>;
        var strProductArray = JSON.stringify(jsonArrayFromPhp);
        var parsedProductArray = JSON.parse(strProductArray);
        console.log(strProductArray);
        console.log(parsedProductArray);
    }

    getCompleteProductsList();
</script>
</html>

