
<?php
require_once "database.php";
$search_value;
$search_value=$_POST["search"];

$sql="SELECT * FROM itemDB WHERE ItemName LIKE '%$search_value%'";

$results=$link->query(strtolower($sql));

while($row=$results->fetch_assoc()){
    echo 'ItemName: '.$row["ItemName"];
    echo '</br>';
    echo '<div class="card">';
    echo '<img src="" alt="Denim Jeans" style="width:100%">';
    echo '<h1>Tailored Jeans</h1>';
    echo '<p class="price">$19.99</p>';
    echo '<p>Some text about the jeans..</p>';
    echo '<p><button>Add to Cart</button></p>';
    echo '</div>';
}
?>