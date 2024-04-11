<?php
// Starting session to enable session usage throughout the application
session_start();

/**
 * Function to establish a database connection
 * @return PDO The PDO instance for database connection
 */
function dbConn()
{
    // Database connection variables
    $DATABASE_HOST = 'localhost'; // Database host
    $DATABASE_USER = 'root'; // Database username
    $DATABASE_PASS = ''; // Database password
    $DATABASE_NAME = 'student_manament_system'; // Database name

    try {
        // Establishing a connection to the database using PDO
        return new PDO('mysql:host=' . $DATABASE_HOST . '; dbname=' . $DATABASE_NAME . '; charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // Output an error message if the connection fails
        exit('Failed to connect to database: ' + $exception);
    }
}

/**
 * Function to generate the header of the template
 * @param string $title The title of the page
 */
function template_header($title)
{
    echo <<<EOT
            <!DOCTYPE html>
            <html>
            <head>
                <!-- Character set and viewport for better compatibility -->
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <!-- Title of the page dynamically generated -->
                <title>$title | Student Management System</title>
                <!-- Favicon -->
                <link rel="icon" type="image/x-icon" href="assets/images/favicon.png">
                <!-- Bootstrap CSS -->
                <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                <!-- Bootstrap Icons -->
                <link rel="stylesheet" href="assets/bootstrap-icons/bootstrap-icons.css">
            </head>
            <body>
                <!-- Navigation bar -->
                <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
                    <div class="container">
                        <!-- Brand logo and link to home page -->
                        <a class="navbar-brand" href="index.php">
                            <img src="assets/images/student-50.png" alt="Logo" />
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
                                    <a class="nav-link" href="index.php">
                                        <i class="bi bi-house"></i>
                                        Home
                                    </a>
                                </li>
                                <!-- Students page link -->
                                <li class="nav-item">
                                    <a class="nav-link" href="students.php">
                                        <i class="bi bi-people"></i>
                                        Students
                                    </a>
                                </li>
                                <!-- Add student page link -->
                                <li class="nav-item">
                                    <a class="nav-link" href="add.php">
                                        <i class="bi bi-plus-lg"></i>
                                        Add Student
                                    </a>
                                </li>
                            </ul>
                            <!-- Search form -->
                            <form action="search.php" class="d-flex" role="search">
                                <div class="input-group">
                                    <input class="form-control" type="search" name="query" placeholder="Search" aria-label="Search">
                                    <!-- Search button -->
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </nav>
        EOT;
}

/**
 * Function to generate the footer of the template
 */
function template_footer()
{
    echo <<<EOT
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            </body>
        </html>
    EOT;
}
