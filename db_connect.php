<?php

$hostName = "localhost";
$userName = "root";
$password = "";
$dbName = "efswd5_exam5_pet_adoption_santiago";

$connect = mysqli_connect($hostName, $userName, $password, $dbName);

if (!$connect) {
    die("Connection failed!");
}
