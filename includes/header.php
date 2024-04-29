<?php
$page = basename(substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '.')));

$user = new User();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $user->logout();
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Character set and viewport for better compatibility -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Title of the page dynamically generated -->
    <title><?= $title ?> | Student Management System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" type="text/css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="./assets/bootstrap-icons/bootstrap-icons.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/styles.css" type="text/css">
</head>

<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom sticky-top">
        <div class="container">
            <!-- Brand logo and link to home page -->
            <a class="navbar-brand" href="index.php">
                <img src="./assets/images/student-50.png" alt="Logo" />
            </a>
            <!-- Responsive navigation toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navigation links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Home page link -->
                    <li class="nav-item">
                        <a class="nav-link<?= $page == 'index' ? ' active' : '' ?>" href="index.php">
                            <i class="bi bi-house text-danger"></i>
                            Home
                        </a>
                    </li>
                    <!-- Students page link -->
                    <li class="nav-item">
                        <a class="nav-link<?= $page == 'students' ? ' active' : '' ?>" href="students.php">
                            <i class="bi bi-people text-danger"></i>
                            Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $page == 'courses' ? ' active' : '' ?>" href="courses.php">
                            <i class="bi bi-book text-danger"></i>
                            Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $page == 'instructors' ? ' active' : '' ?>" href="instructors.php">
                            <i class="bi bi-person text-danger"></i>
                            Instructors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $page == 'departments' ? ' active' : '' ?>" href="departments.php">
                            <i class="bi bi-building text-danger"></i>
                            Departments
                        </a>
                    </li>
                </ul>
                <!-- <span class="me-3">
                    Welcome <?= isset($_SESSION['isLogged']) ? $_SESSION['username'] : 'Guest' ?>
                </span> -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="?action=logout" class="nav-link">
                            <i class="bi bi-person-fill-lock text-danger"></i>
                            Logout
                        </a>
                    </li>
                </ul>
                <!-- Search form -->
                <form action="search.php" class="d-flex" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" name="query" value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>" placeholder="Search" aria-label="Search">
                        <!-- Search button -->
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Closing tags for body and html will be in the footer include -->