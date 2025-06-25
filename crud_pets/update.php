<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../login.php");
}

if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
}

require_once "../db_connect.php";
require_once "../functions.php";

$id = $_GET["id"];

$sql = "SELECT * FROM pets WHERE id =$id";

$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);

if (isset($_POST["update"])) {
    $name = cleanInputs($_POST["name"]);
    $breed = cleanInputs($_POST["breed"]);
    $gender = cleanInputs($_POST["gender"]);
    $size = cleanInputs($_POST["size"]);
    $age = cleanInputs($_POST["age"]);
    $picture = fileUpload($_FILES["picture"]);
    $address = cleanInputs($_POST["address"]);
    $vaccinated = cleanInputs($_POST["vaccine"]);
    $status = cleanInputs($_POST["status"]);
    $description = cleanInputs($_POST["description"]);

    if ($_FILES["picture"]["error"] == 0) {
        if ($row["picture"] != "pet.png") {
            unlink("../img/$row[picture]");
        }
        $sql = "UPDATE `pets` SET `name`='$name',`breed`='$breed',`gender`='$gender',`size`='$size',`age`=$age,`picture`='$picture[0]',`address`='$address',`vaccinated`='$vaccinated',`description`='$description',`status`='$status' WHERE id =$id";
    } else {
        $sql = "UPDATE `pets` SET `name`='$name',`breed`='$breed',`gender`='$gender',`size`='$size',`age`=$age,`address`='$address',`vaccinated`='$vaccinated',`description`='$description',`status`='$status' WHERE id =$id";
    }

    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
            Pet has been updated.
            <br>
            $picture[1]
          </div>";
        header("Refresh:3; url=index.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            Error found!
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
    <title>Update Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="form-card">
        <h2 class="text-center">Update Pet</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mt-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $row["name"] ?>">
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" aria-describedby="breed" name="breed" value="<?= $row["breed"] ?>">
            </div>
            <div class=" mb-3">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="gender" aria-describedby="gender" name="gender" value="<?= $row["gender"] ?>">
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <select name="size" class="form-control" id="size">
                    <option value="">---Select a size---</option>
                    <option value="X-Small" <?= $row["size"] == "X-Small" ? "selected" : "" ?>>X-Small</option>
                    <option value="Small" <?= $row["size"] == "Small" ? "selected" : "" ?>>Small</option>
                    <option value="Medium" <?= $row["size"] == "Medium" ? "selected" : "" ?>>Medium</option>
                    <option value="Large" <?= $row["size"] == "Large" ? "selected" : "" ?>>Large</option>
                    <option value="X-Large" <?= $row["size"] == "X-Large" ? "selected" : "" ?>>X-Large</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" aria-describedby="age" name="age" min="0" value="<?= $row["age"] ?>">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Current address</label>
                <input type="text" class="form-control" id="address" aria-describedby="address" name="address" value="<?= $row["address"] ?>">
            </div>
            <div class="mb-3">
                <label for="vaccine" class="form-label">Vaccinated</label>
                <select name="vaccine" class="form-control" id="vaccine">
                    <option value="">---Select an option---</option>
                    <option value="Yes" <?= $row["vaccinated"] == "Yes" ? "selected" : "" ?>>Yes</option>
                    <option value="No" <?= $row["vaccinated"] == "No" ? "selected" : "" ?>>No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" id="status">
                    <option value="">---Select an option---</option>
                    <option value="Adopted" <?= $row["status"] == "Adopted" ? "selected" : "" ?>>Adopted</option>
                    <option value="Available" <?= $row["status"] == "Available" ? "selected" : "" ?>>Available</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Add a description</label>
                <textarea name="description" id="description" class="form-control"><?= $row["description"] ?></textarea>
            </div>
            <div class="btn-group">
                <button name="update" type="submit" class="btn btn-primary">Update Pet</button>
                <a href="index.php" class="btn btn-warning">Back to Home</a>
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>