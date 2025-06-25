<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

require_once "db_connect.php";

$id = $_SESSION["admin"];

$sql = "SELECT * FROM `user` WHERE id =$id";

$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);

// admin can see all users and edit users

$sqlUsers = "SELECT * FROM `user` WHERE status != 'admin'";
$resultUsers = mysqli_query($connect, $sqlUsers);

$layout = "";

if (mysqli_num_rows($resultUsers) > 0) {
    while ($userRow = mysqli_fetch_assoc($resultUsers)) {
        $layout .= "
<div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center'>
    <div class='card shadow-lg border-0 rounded-4 position-relative text-center' style='width: 16rem;'>
        <div class='position-absolute top-0 end-0 m-2 badge bg-secondary'>User</div>
        <img src='img/{$userRow["picture"]}' alt='User Image' class='card-img-top rounded-top-4' style='height: 180px; object-fit: cover; object-position: center;'>
        <div class='card-body p-3 d-flex flex-column'>
            <h5 class='card-title text-primary fw-bold mb-2'>{$userRow["fname"]} {$userRow["lname"]}</h5>
            <p class='card-text text-muted small mb-1'><strong>Email:</strong> {$userRow["email"]}</p>
            <p class='card-text text-muted small mb-3'><strong>Address:</strong> {$userRow["address"]}</p>
            <a href='update.php?id={$userRow["id"]}' class='btn btn-outline-warning rounded-pill mt-auto px-3'>Update</a>
        </div>
    </div>
</div>";
    }
} else {
    $layout = "No result found!";
}

mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg custom-navbar shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                <img src="img/<?= $row["picture"] ?>" alt="admin pic" width="40" height="40" class="rounded-circle border border-light">
                <span class="fw-bold text-white">The Paw Portal</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="crud_pets/index.php">Pets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="crud_pets/create.php">Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="update.php?id=<?= $row["id"] ?>">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-semibold" href="logout.php?logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h2 class="text-center text-black mb-5 mt-4">Welcome Admin, <?= $row["fname"] ?>!</h2>

    <div class="container">
        <div class="row row-cols-3">
            <?= $layout ?>
        </div>
    </div>

    <footer class="custom-footer text-center text-white py-4 mt-5">
        <div class="container">
            <p class="mb-1 fw-semibold">🐾 The Paw Portal — Where Love Finds a Home 🏡</p>
            <p class="mb-0 small">&copy; <?= date("Y") ?> The Paw Portal. All rights reserved.</p>
            <p class="small">Made with ❤️ for our senior furry friends.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>