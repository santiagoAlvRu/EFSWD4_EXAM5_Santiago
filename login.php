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

$email = $password = "";

$emailError = $passError = "";

if (isset($_POST["login"])) {
    $email = cleanInputs($_POST["email"]);
    $password = cleanInputs($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address";
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty!";
    }

    if (!$error) {
        $password = hash("sha256", $password);

        $sql = "SELECT * FROM `user` WHERE email ='$email' AND password ='$password'";

        $result = mysqli_query($connect, $sql);

        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            if ($row["status"] == "admin") {
                $_SESSION["admin"] = $row["id"];
                header("Location: dashboard.php");
            } else {
                $_SESSION["user"] = $row["id"];
                header("Location: home.php");
            }
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
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center text-primary mt-3">Login</h1>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="john@mail.com" value="<?= $email ?>">
                <span class="text-danger"><?= $emailError ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <span class="text-danger"><?= $passError ?></span>
            </div>
            <div class="mt-3">
                <button name="login" type="submit" class="btn btn-primary">Login</button>
                <br>
                <br>
                <span>Don't you have an account? <a href="register.php">Register here!</a></span>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>