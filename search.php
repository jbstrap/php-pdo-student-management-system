<?php
$title = 'Search Students';
include './classes/User.php';
$user = new User();

if (!$user->isLoggedIn()) {
    $_SESSION['message'] = [
        'message' => 'You must be logged in to access that page!',
        'messageType' => 'danger',
    ];
    header("Location: index.php?redirectUrl=students");
    exit();
}

include './classes/Student.php';

// Initializing a count variable to store the number of search results
$count = 0;

// Checking if a search query is provided
if (isset($_GET['query'])) {
    // Checking if the search query is not empty
    if (!empty($_GET['query'])) {
        // Create an instance of the Student class
        $student = new Student();
        // Call the search method with search query parameter
        $result = $student->searchStudents($_GET['query']);
        $students = $result['data'];
        $count = $result['count']; // Get count of search results
    } else {
        // Redirecting to students.php if the search query is empty
        header('Location: students.php');
    }
} else {
    // Redirecting to students.php if no search query is specified
    $output = [
        'message' => 'No query specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: students.php');
}
?>

<?php include './includes/header.php'; ?>
<!-- HTML content for search results page -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mt-4 mb-3">
                <div>
                    <h2>Search Results</h2>
                    <!-- Displaying the number of search results and the search query -->
                    <p>We have found <span class="fw-bold"><?= $count ?></span> record(s) for search: <span class="fw-bold"><?= $_GET['query'] ?></span></p>
                </div>
                <div>
                    <!-- Link to go back to the students.php page -->
                    <a href="students.php" class="fw-bold text-decoration-none">
                        <i class="bi bi-chevron-left"></i> Go Back
                    </a>
                </div>
            </div>
            <div class="mt-2">
                <!-- Displaying search results in a table -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="table-light">
                            <th scope="col">St. Number</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Email</th>
                            <th scope="col">Enrollment Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Checking if there are students available -->
                        <?php if (!empty($students)) : ?>
                            <!-- Looping through each student and displaying their information -->
                            <?php foreach ($students as $student) : ?>
                                <tr>
                                    <!-- Displaying student details -->
                                    <th class="align-middle" scope="row"><?= $student['student_number'] ?></th>
                                    <td class="align-middle"><?= $student['first_name'] ?></td>
                                    <td class="align-middle"><?= $student['last_name'] ?></td>
                                    <td class="align-middle"><?= $student['age'] ?></td>
                                    <td class="align-middle"><?= $student['gender'] ?></td>
                                    <td class="align-middle"><?= $student['email'] ?></td>
                                    <td class="align-middle text-nowrap"><?= $student['enrollment_date'] ?></td>
                                    <!-- Links to update and delete student -->
                                    <td class="text-end align-middle text-nowrap">
                                        <a href="view-student.php?studentId=<?= $student['student_number'] ?>" title="Student Marks" class="btn btn-transparent btn-sm text-secondary">
                                            <i class="bi bi-eye fs-5"></i>
                                        </a>
                                        <a href="update-student.php?studentId=<?= $student['student_number'] ?>" title="Edit Student" class="btn btn-transparent btn-sm text-primary">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <a href="delete-student.php?studentId=<?= $student['student_number'] ?>" title="Delete Student" class="btn btn-transparent btn-sm text-danger">
                                            <i class="bi bi-trash3 fs-5"></i>
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
<?php include './includes/footer.php'; ?>