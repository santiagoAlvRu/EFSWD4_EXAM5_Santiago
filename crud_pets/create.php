<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit();
}

require_once "../db_connect.php";
require_once "../functions.php";

$error = false;

$name = $breed = $gender = $size = $age = $picture = $address = $vaccine = $description = $status = "";
$nameError = $breedError = $genderError = $addressError = "";

if (isset($_POST["create"])) {
    $name = cleanInputs($_POST["name"]);
    $breed = cleanInputs($_POST["breed"]);
    $gender = cleanInputs($_POST["gender"]);
    $size = cleanInputs($_POST["size"]);
    $age = cleanInputs($_POST["age"]);
    $picture = fileUpload($_FILES["picture"], "pet");
    $address = cleanInputs($_POST["address"]);
    $vaccine = cleanInputs($_POST["vaccine"]);
    $description = cleanInputs($_POST["description"]);
    $status = cleanInputs($_POST["status"]);

    if (empty($name)) {
        $error = true;
        $nameError = "Please enter the name";
    } elseif (strlen($name) < 2) {
        $error = true;
        $nameError = "Name must have at least 2 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $error = true;
        $nameError = "Name must contain only letters and spaces";
    }

    if (empty($breed)) {
        $error = true;
        $breedError = "Please enter a breed";
    } elseif (strlen($breed) < 3) {
        $error = true;
        $breedError = "Breed must have at least 3 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $breed)) {
        $error = true;
        $breedError = "Breed must contain only letters and spaces";
    }

    if (empty($gender)) {
        $error = true;
        $genderError = "Please enter a gender";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $gender)) {
        $error = true;
        $genderError = "Gender must contain only letters and spaces";
    }

    if (empty($address)) {
        $error = true;
        $addressError = "Please enter an address";
    }

    if (!$error) {
        $sql = "INSERT INTO `pets`(`name`, `breed`, `gender`, `size`, `age`, `picture`, `address`, `vaccinated`, `description`, `status`) VALUES ('$name','$breed','$gender','$size',$age,'$picture[0]','$address','$vaccine','$description','$status')";

        if (mysqli_query($connect, $sql)) {
            echo "<div class='alert alert-success' role='alert'>
            New record has been created.
            <br>
            $picture[1]
          </div>";
            header("refresh: 3; url= index.php");
        } else {
            echo "<div class='alert alert-danger' role='alert'>
            error found.
            <br>
            $picture[1]
          </div>";
        }
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
    <link rel="stylesheet" href="../css/styles.css">
    <title>Create</title>
</head>

<body>
    <div class="form-card">
        <h2 class="text-center text-primary mb-3">Create Pet</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mt-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $name ?>">
                <span class="text-danger"><?= $nameError ?></span>
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" aria-describedby="breed" name="breed" value="<?= $breed ?>">
                <span class="text-danger"><?= $breedError ?></span>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="gender" aria-describedby="gender" name="gender" value="<?= $gender ?>">
                <span class="text-danger"><?= $genderError ?></span>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <select name="size" class="form-control" id="size" required>
                    <option selected value="">---Select a size---</option>
                    <option value="X-Small">X-Small</option>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                    <option value="X-Large">X-Large</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" aria-describedby="age" name="age" min="0">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Current address</label>
                <input type="text" class="form-control" id="address" aria-describedby="address" name="address" value="<?= $address ?>">
                <span class="text-danger"><?= $addressError ?></span>
            </div>
            <div class="mb-3">
                <label for="vaccine" class="form-label">Vaccinated</label>
                <select name="vaccine" class="form-control" id="vaccine" required>
                    <option selected value="">---Select an option---</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" id="status" required>
                    <option selected value="">---Select an option---</option>
                    <option value="Adopted">Adopted</option>
                    <option value="Available">Available</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Add a description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <button name="create" type="submit" class="btn btn-primary">Create Pet</button>
            <a href="index.php" class="btn btn-warning">Back to Pets</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>