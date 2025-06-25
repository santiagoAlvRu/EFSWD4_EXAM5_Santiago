<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("login.php");
    exit();
}

if (isset($_SESSION["admin"])) {
    header("dashboard.php");
}

require_once "db_connect.php";

$petId = $_GET["id"];

$userId = $_SESSION["user"];

$sql = "INSERT INTO pet_adoption(`user_id`, `pet_id`) VALUES ($userId,$petId)";

if (mysqli_query($connect, $sql)) {
    header("Location: home.php");
}
