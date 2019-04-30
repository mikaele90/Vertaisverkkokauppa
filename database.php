<?php
/**
 * Created by PhpStorm.
 * User: Pate
 * Date: 30.4.2019
 * Time: 12.00
 */

$serverinnimi = "localhost";
$kayttajannimi = "Patrik";
$salasana = "dbpass";
$tietokanta = "verkkokauppa";
// Creating connection

$con = mysqli_connect($serverinnimi, $kayttajannimi, $salasana,$tietokanta);

// Checking connection
if (!$con) {
    die("Yhteys epäonnistui: " . mysqli_connect_error());
}
mysqli_set_charset($con,"utf8");

?>