<?php

//define credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'kayttaja');
define('DB_PASSWORD', 'dbpass');
define('DB_NAME', 'verkkokauppa');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME,);

mysqli_set_charset($link, "utf8");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>