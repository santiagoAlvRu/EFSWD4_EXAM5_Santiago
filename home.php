<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit();
}

require_once "db_connect.php";

$id = isset($_SESSION["user"]) ? $_SESSION["user"] : $_SESSION["admin"];

$sql = "SELECT * FROM `user` WHERE id =$id";

$result = mysqli_query($connect, $sql);

$rowUser = mysqli_fetch_assoc($result);


$sqlPets = "SELECT * FROM pets";

$resultPets = mysqli_query($connect, $sqlPets);

$rowsPets = mysqli_fetch_all($resultPets, MYSQLI_ASSOC);

$cards = "";

if (mysqli_num_rows($resultPets) > 0) {
    foreach ($rowsPets as $row) {
        $cards .= "
<div class='col mb-4 d-flex justify-content-center'>
    <div class='card h-100 shadow-lg border-0 rounded-4' style='max-width: 20rem;'>
        <img src='img/$row[picture]' class='card-img-top2 rounded-top-4' alt='Pet photo' style='height: 200px; object-fit: cover;'>
        <div class='card-body text-center p-4'>
            <h4 class='card-title text-primary fw-bold mb-2'>$row[name]</h4>
            <p class='card-text mb-1'><strong>Breed:</strong> $row[breed]</p>
            <p class='card-text mb-1'><strong>Gender:</strong> $row[gender]</p>
            <p class='card-text mb-1'><strong>Size:</strong> $row[size]</p>
            <p class='card-text mb-1'><strong>Age:</strong> $row[age] years</p>
            <p class='card-text mb-3'><strong>Status: </strong> $row[status]</p>
            <a href='details.php?id=$row[id]' class='btn btn-outline-primary rounded-pill px-4'>More Details</a>
            <hr>
            <a href='adopt.php?id=$row[id]' class='btn btn-outline-success rounded-pill px-4'>Adopt Me!</a>
        </div>
    </div>
</div>
";
    }
} else {
    $cards = "<p class='text-danger'>No results found</p>";
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
    <title>Welcome <?= $rowUser["fname"] ?>!</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg custom-navbar shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                <img src="img/<?= $rowUser["picture"] ?>" alt="admin pic" width="40" height="40" class="rounded-circle border border-light">
                <span class="fw-bold text-white">The Paw Portal</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="update.php?id=<?= $rowUser["id"] ?>">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="seniors.php">Our Seniors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-semibold" href="logout.php?logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h2 class="text-center mt-3">Welcome <?= $rowUser["fname"] ?>!</h2>

    <div class="container mt-5 mb-4">
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1">
            <?= $cards ?>
        </div>
    </div>

    <footer class="custom-footer text-center text-white py-4 mt-5">
        <div class="container">
            <p class="mb-1 fw-semibold">🐾 The Paw Portal — Where Love Finds a Home 🏡</p>
            <p class="mb-0 small">&copy; <?= date("Y") ?> The Paw Portal. All rights reserved.</p>
            <p class="small">Made with ❤️ for our furry friends.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>