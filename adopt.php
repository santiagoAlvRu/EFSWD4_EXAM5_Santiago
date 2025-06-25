<?php

session_start();

require_once "db_connect.php";

$petId = $_GET["id"];

$userId = $_SESSION["user"];

$sql = "INSERT INTO pet_adoption(`user_id`, `pet_id`) VALUES ($userId,$petId)";

if (mysqli_query($connect, $sql)) {
    header("Location: home.php");
}
