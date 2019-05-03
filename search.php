
<?php
require_once "database.php";


$search_value = "";
$search_value_err = "";



if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql="SELECT * FROM itemDB WHERE ItemName LIKE ? ";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_search_value);

        // Set parameters
        $search_value = strtolower(trim($_POST[strip_tags("search")]));

        //$search_value = $_POST["search"];
        $param_search_value = $search_value;

        if(mysqli_stmt_execute($stmt)){
            /* store result */
            //mysqli_stmt_store_result($stmt);

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

<form action="" method="post">
    <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search">
    <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit" value="Search">Search</button>
</form>
