
<?php
require_once "database.php";
require_once "nav-bar.php";

$search_value = "";
$search_value_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql="SELECT * FROM itemDB WHERE ItemName LIKE ? ";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_search_value);

        // Set parameters
        $search_value = strtolower(trim($_POST[strip_tags("search")]));
        $param_search_value = $search_value;
        //try to execute statement
        if(mysqli_stmt_execute($stmt)){

            //store query results to result variable
            //get the amount of rows in the query and assign it to the $num_rows variable
            $result = mysqli_stmt_get_result($stmt);
            $num_rows = mysqli_num_rows($result);

            if($num_rows == 0){
                echo $search_value_err = "Search didnt find any results.";
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
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; align-content: center}
    </style>
</head>

</html>
