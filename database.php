<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
<<<<<<< HEAD
define('DB_USERNAME', 'kayttaja');
define('DB_PASSWORD', 'dbpass');
=======
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '123456');
>>>>>>> e7525035981c16d4d6f6202800c1bb8b0a885fb3
define('DB_NAME', 'verkkokauppa');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>