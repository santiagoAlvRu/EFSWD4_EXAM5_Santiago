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

$adminId = $_SESSION["admin"];
$adminSql = "SELECT * FROM `user` WHERE id = $adminId";
$adminResult = mysqli_query($connect, $adminSql);
$adminRow = mysqli_fetch_assoc($adminResult);

$sql = "SELECT * FROM pets";

$result = mysqli_query($connect, $sql);

$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$cards = "";


if (mysqli_num_rows($result) > 0) {
    foreach ($rows as $row) {
        $cards .= "
        <div class='col-12 col-sm-6 col-md-4 col-lg-4 d-flex justify-content-center mb-4'>
            <div class='card h-100 shadow-sm' style='max-width: 20rem;'>
                <img src='../img/{$row['picture']}' class='card-img-top mt-3' alt='Pet photo'>
                <div class='card-body text-center d-flex flex-column'>
                    <h4 class='card-title mb-3'>{$row['name']}</h4>
                    <p class='card-text mb-1'><b>Breed:</b> {$row['breed']}</p>
                    <p class='card-text mb-1'><b>Gender:</b> {$row['gender']}</p>
                    <p class='card-text mb-1'><b>Size:</b> {$row['size']}</p>
                    <p class='card-text mb-3'><b>Age:</b> {$row['age']} Years</p>
                    <div class='mt-auto d-flex justify-content-center gap-2 flex-wrap'>
                        <a href='../details.php?id={$row['id']}' class='btn btn-primary btn-sm'>More details</a>
                        <a href='update.php?id={$row['id']}' class='btn btn-warning btn-sm'>Update</a>
                        <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                    </div>
                </div>
            </div>
        </div>";
    }
} else {
    $cards = "<p class='text-danger'>No results found</p>";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg custom-navbar shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="../dashboard.php">
                <img src="../img/<?= $adminRow["picture"] ?>" alt="admin pic" width="40" height="40"
                    class="rounded-circle border border-light">
                <span class="fw-bold text-white">The Paw Portal</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="../dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="index.php">Pets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="create.php">Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="../update.php?id=<?= $adminRow["id"] ?>">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-semibold" href="../logout.php?logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1">
            <?= $cards ?>
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