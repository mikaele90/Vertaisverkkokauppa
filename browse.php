<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vertaisverkkokauppa :: Browse ::</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<?php
require_once 'database.php';
require_once 'nav-bar.php';

$sql="SELECT * FROM itemDB";

if($stmt = mysqli_prepare($link, $sql)){

    if(mysqli_stmt_execute($stmt)){
        /* store result */
        //mysqli_stmt_store_result($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $num_rows = mysqli_num_rows($result);

        if($num_rows == 0){
            echo $browse_value_err = "No results to display.";
        } else{
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                echo 'ItemName: '. $row["ItemName"];
                echo '</br>';
                echo '<div class="card">';
                echo '<img src="" alt="Denim Jeans" style="width:100%">';
                echo '<h1>Tailored Jeans</h1>';
                echo '<p class="price">$19.99</p>';
                echo '<p>Some text about the jeans..</p>';
                echo '<p><button>Add to Cart</button></p>';
                echo '</div>';
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
</script>
</html>

