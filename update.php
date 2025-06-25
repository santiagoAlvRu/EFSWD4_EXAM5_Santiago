<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("login.php");
    exit();
}

require_once "db_connect.php";
require_once "functions.php";

$id = $_GET["id"];

$sql = "SELECT * FROM `user` WHERE id =$id";

$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);

$backBtn = "home.php";

if (isset($_POST["update"])) {
    $fname = cleanInputs($_POST["fname"]);
    $lname = cleanInputs($_POST["lname"]);
    $date_of_birth = cleanInputs($_POST["date_of_birth"]);
    $address = cleanInputs($_POST["address"]);
    $picture = fileUpload($_FILES["picture"]);
    $email = cleanInputs($_POST["email"]);

    if ($_FILES["picture"]["error"] == 0) {
        if ($row["picture"] != "avatar.png") {
            unlink("img/$row[picture]");
        }
        $sql = "UPDATE `user` SET `fname`='$fname',`lname`='$lname',`email`='$email',`date_of_birth`='$date_of_birth',`address`='$address',`picture`='$picture[0]' WHERE id =$id";
    } else {
        $sql = "UPDATE `user` SET `fname`='$fname',`lname`='$lname',`email`='$email',`date_of_birth`='$date_of_birth',`address`='$address' WHERE id =$id";
    }

    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
        Data has been updated, 
        <br>
        {$picture[1]}
      </div>";
        header("Refresh: 4; url='dashboard.php'");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
        Error found, 
        <br>
        {$picture[1]}
      </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Edit Profile</title>
</head>

<body>
    <div class="form-card">
        <h1 class="text-center text-primary mb-4">Edit Profile</h1>
        <form method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?= $row["fname"] ?>">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?= $row["lname"] ?>">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date of birth</label>
                <input type="date" class="form-control" id="date" name="date_of_birth" value="<?= $row["date_of_birth"] ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= $row["address"] ?>">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Profile picture</label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $row["email"] ?>">
            </div>
            <div class="btn-group">
                <button name="update" type="submit" class="btn btn-warning">Update profile</button>
                <a href="<?= $backBtn ?>" class="btn btn-primary">Back Home</a>
            </div>
        </form>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>