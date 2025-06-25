<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("login.php");
    exit();
}

require_once "db_connect.php";

$adminRow = null;
$userRow = null;

if (isset($_SESSION["admin"])) {
    $adminId = $_SESSION["admin"];
    $adminSql = "SELECT * FROM `user` WHERE id = $adminId";
    $adminResult = mysqli_query($connect, $adminSql);
    $adminRow = mysqli_fetch_assoc($adminResult);
}

if (isset($_SESSION["user"])) {
    $userId = $_SESSION["user"];
    $userSql = "SELECT * FROM `user` WHERE id = $userId";
    $userResult = mysqli_query($connect, $userSql);
    $userRow = mysqli_fetch_assoc($userResult);
}

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "<h4 class='text-danger'>Invalid pet ID!</h4>";
    exit();
}

$sql = "SELECT * FROM pets WHERE id =$id";

$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<h4 class='text-danger'>No pet found!</h4>";
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Details</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg custom-navbar shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
                <?php if ($adminRow): ?>
                    <img src="img/<?= $adminRow["picture"] ?>" alt="admin pic" width="40" height="40"
                        class="rounded-circle border border-light">
                <?php elseif ($userRow): ?>
                    <img src="img/<?= $userRow["picture"] ?>" alt="user pic" width="40" height="40"
                        class="rounded-circle border border-light">
                <?php endif; ?>
                <span class="fw-bold text-white">The Paw Portal</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <?php if ($adminRow): ?>
                            <a class="nav-link text-white fw-semibold" href="../dashboard.php">Dashboard</a>
                        <?php elseif ($userRow): ?>
                            <a class="nav-link text-white fw-semibold" href="home.php">Home</a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <?php if ($adminRow): ?>
                            <a class="nav-link text-white fw-semibold" href="update.php?id=<?= $adminRow["id"] ?>">Edit Profile</a>
                        <?php elseif ($userRow): ?>
                            <a class="nav-link text-white fw-semibold" href="update.php?id=<?= $userRow["id"] ?>">Edit Profile</a>
                        <?php endif; ?>
                    </li>
                    <?php if ($adminRow): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-semibold" href="crud_pets/index.php">Pets</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($userRow): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-semibold" href="seniors.php">Our Seniors</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-semibold" href="../logout.php?logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5 d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded-4 position-relative text-center" style="width: 30rem;">
            <div class="position-absolute top-0 end-0 m-2 badge bg-info text-dark fs-6">Looking for a Home</div>
            <img src="img/<?= $row["picture"] ?>" class="card-img-top rounded-top-4" alt="<?= $row["name"] ?>" style="height: 250px; object-fit: cover;">
            <div class="card-body p-4">
                <h3 class="card-title text-primary fw-bold mb-3"><?= $row["name"] ?></h3>
                <p class="card-text mb-2"><strong>Breed:</strong> <?= $row["breed"] ?></p>
                <p class="card-text mb-2"><strong>Gender:</strong> <?= $row["gender"] ?></p>
                <p class="card-text mb-2"><strong>Size:</strong> <?= $row["size"] ?></p>
                <p class="card-text mb-2"><strong>Age:</strong> <?= $row["age"] ?> years</p>
                <p class="card-text mb-2"><strong>Temporary Address:</strong> <?= $row["address"] ?></p>
                <p class="card-text mb-2"><strong>Vaccinated:</strong> <?= $row["vaccinated"] ?></p>
                <p class="card-text mb-2"><strong>Status:</strong> <?= $row["status"] ?></p>
                <p class="card-text mt-3"><strong>Description:</strong><br><span class="text-muted"><?= $row["description"] ?></span></p>
                <?php if (!isset($_SESSION["admin"])): ?>
                    <a href="adopt.php?id=<?= $row['id'] ?>" class="btn btn-outline-success rounded-pill px-4">Adopt Me!</a>
                <?php endif; ?>
            </div>
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