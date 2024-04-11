<!-- 
    This code snippet implements a search functionality for student records based on the provided search query. 
    It retrieves matching records from the database and displays them in a table format on the search results page.
 -->

<?php
// Including functions.php file for necessary functions
include 'functions.php';

// Initializing a count variable to store the number of search results
$count = 0;

// Checking if a search query is provided
if (isset($_GET['query'])) {
    // Checking if the search query is not empty
    if (!empty($_GET['query'])) {
        // Establishing a database connection
        $conn = dbConn();

        // Retrieving the search term from the URL query parameter
        $search_term = $_GET['query'];

        // Querying the database for students matching the search term
        $stmt = $conn->query("SELECT * FROM students
                                WHERE first_name LIKE '%$search_term%'
                                OR last_name LIKE '%$search_term%'
                                OR student_number LIKE '%$search_term%'
                                ORDER BY student_number DESC
                            ");

        // Fetching all matching students from the database
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Counting the number of search results
        $count = $stmt->rowCount();
    } else {
        // Redirecting to students.php if the search query is empty
        header('Location: students.php');
        exit;
    }
} else {
    // Redirecting to students.php if no search query is specified
    $output = [
        'message' => 'No query specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: students.php');
    exit;
}
?>

<?= template_header('Search') ?>
<!-- HTML content for search results page -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mt-4 mb-3">Search Results</h2>
            <!-- Displaying the number of search results and the search query -->
            <p>We have found <span class="fw-bold"><?= $count ?></span> record(s) for search: <span class="fw-bold"><?= $_GET['query'] ?></span></p>
            <!-- Link to go back to the students.php page -->
            <a href="students.php" class="fw-bold text-decoration-none">
                <i class="bi bi-chevron-left"></i> Back
            </a>
            <div class="mt-2">
                <!-- Displaying search results in a table -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">St. Number</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($students) : ?>
                            <?php foreach ($students as $student) : ?>
                                <tr>
                                    <!-- Displaying student details in table rows -->
                                    <th class="align-middle" scope="row"><?= $student['student_number'] ?></th>
                                    <td class="align-middle"><?= $student['first_name'] ?></td>
                                    <td class="align-middle"><?= $student['last_name'] ?></td>
                                    <td class="align-middle"><?= $student['age'] ?></td>
                                    <td class="align-middle"><?= $student['gender'] ?></td>
                                    <td class="align-middle"><?= $student['email'] ?></td>
                                    <td class="align-middle"><?= $student['phone_number'] ?></td>
                                    <td class="align-middle"><?= $student['address'] ?></td>
                                    <!-- Links to update and delete student records -->
                                    <td class="text-end align-middle">
                                        <a href="update.php?studentId=<?= $student['student_number'] ?>" class="btn btn-primary py-1 px-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="delete.php?studentId=<?= $student['student_number'] ?>" class="btn btn-danger py-1 px-2">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <!-- Displaying a message if no search results found -->
                            <tr>
                                <td colspan="9" class="text-center">There are no records matching your search.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= template_footer() ?>