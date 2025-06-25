<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../login.php");
}

if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
}

require_once "../db_connect.php";

$id = $_GET["id"];

$sql = "SELECT * FROM pets WHERE id =$id";

$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);

if ($row["picture"] != "pet.png") {
    unlink("../img/$row[picture]");
}

$delete = "DELETE FROM pets WHERE id =$id";

if (mysqli_query($connect, $delete)) {
    header("Location: index.php");
} else {
    echo "Error deleting pet";
}

mysqli_close($connect);
