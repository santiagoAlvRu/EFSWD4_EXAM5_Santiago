<?php

session_start();

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}

if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
}

require_once "db_connect.php";
require_once "functions.php";

$error = false;

$fname = $lname = $email = $date_of_birth = $address = $picture = $password = "";
$fnameError = $lnameError = $emailError = $dobError = $addressError = $passError = "";

if (isset($_POST["sign-up"])) {
    $fname = cleanInputs($_POST["fname"]);
    $lname = cleanInputs($_POST["lname"]);
    $date_of_birth = cleanInputs($_POST["date_of_birth"]);
    $address = cleanInputs($_POST["address"]);
    $picture = fileUpload($_FILES["picture"]);
    $email = cleanInputs($_POST["email"]);
    $password = cleanInputs($_POST["password"]);

    if (empty($fname)) {
        $error = true;
        $fnameError = "Please enter your first name";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $fnameError = "Name must have at least 3 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $fnameError = "Name must contain only letters and spaces";
    }

    if (empty($lname)) {
        $error = true;
        $lnameError = "Please, enter your last name";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $lnameError = "Last name must have at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $lnameError = "Last name must contain only letters and spaces.";
    }

    if (empty($date_of_birth)) {
        $error = true;
        $dobError = "Date of birth can't be empty";
    }

    if (empty($address)) {
        $error = true;
        $addressError = "Address can't be empty";
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passError = "Password must contain at least 6 characters";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email";
    } else {
        $sqlEmail = "SELECT email FROM `user` WHERE email ='$email'";
        $resultEmail = mysqli_query($connect, $sqlEmail);
        if (mysqli_num_rows($resultEmail) != 0) {
            $error = true;
            $emailError = "Email already in use";
        }
    }
    if (!$error) {
        $password = hash("sha256", $password);

        $sql = "INSERT INTO `user`(`fname`, `lname`, `email`, `date_of_birth`, `address`, `picture`, `password`) VALUES ('$fname','$lname','$email','$date_of_birth','$address','$picture[0]','$password')";

        $result = mysqli_query($connect, $sql);

        if ($result) {
            echo "<div class='alert alert-success'>
                <p>New account has been created.
                <br>
                $picture[1]</p>
            </div>";
            header("Refresh:4; url: login.php");
        } else {
            echo "<div class='alert alert-danger'>
                <p>Something went wrong, please try again later</p>
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
    <link rel="stylesheet" href="css/styles.css">
    <title>Register</title>
</head>

<body>

    <div class="container">
        <h1 class="text-center text-primary mt-3">Sign Up</h1>
        <form method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="John" value="<?= $fname ?>">
                <span class="text-danger"><?= $fnameError ?></span>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Wick" value="<?= $lname ?>">
                <span class="text-danger"><?= $lnameError ?></span>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date of birth</label>
                <input type="date" class="form-control" id="date" name="date_of_birth" value="<?= $date_of_birth ?>">
                <span class="text-danger"><?= $dobError ?></span>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= $address ?>">
                <span class="text-danger"><?= $addressError ?></span>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Profile picture</label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="john@mail.com" value="<?= $email ?>">
                <span class="text-danger"><?= $emailError ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <span class="text-danger"><?= $passError ?></span>
            </div>
            <div class="mt-3 mb-3">
                <button name="sign-up" type="submit" class="btn btn-primary">Create account</button>
                <span class="text-center mx-5">You already have an account? <a href="login.php">Sign in here</a></span>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>