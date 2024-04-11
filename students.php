<!-- 
    This code fetches and displays a list of students from the database. 
    It includes buttons to add new students, displays session messages, 
    and provides links to update or delete individual student records. 
 -->

<?php
// Including functions.php file for necessary functions
include 'functions.php';

// Establishing a database connection
$conn = dbConn();

// Querying the database to retrieve all students, ordered by student number in descending order
$stmt = $conn->query('SELECT * FROM students ORDER BY student_number DESC');

// Fetching all rows from the result set as an associative array
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Students') ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mt-4 mb-3">All Students</h2>
            <p>Welcome to my student management system</p>
            <!-- Button to add a new student -->
            <a href="add.php" class="btn btn-primary mb-3">
                <i class="bi bi-plus-lg"></i> Add New
            </a>
            <!-- Displaying session message if set -->
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-<?php echo $_SESSION['message']['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= $_SESSION['message']['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['message']); ?>
            <div>
                <!-- Table to display student information -->
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
                            <th scope="col">Grade</th>
                            <th scope="col">Address</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Checking if there are students available -->
                        <?php if ($students) : ?>
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
                                    <td class="align-middle"><?= $student['phone_number'] ?></td>
                                    <td class="align-middle"><?= $student['grade'] ?></td>
                                    <!-- Truncating address if it exceeds maximum length -->
                                    <td class="align-middle" title="<?= $student['address'] ?>">
                                        <?php
                                        $address = $student['address'];
                                        $max_length = 20; // Maximum length before truncating
                                        if (strlen($address) > $max_length) {
                                            echo substr($address, 0, $max_length) . '...';
                                        } else {
                                            echo $address;
                                        }
                                        ?>
                                    </td>
                                    <!-- Links to update and delete student -->
                                    <td class="text-end align-middle text-nowrap">
                                        <a href="view.php?studentId=<?= $student['student_number'] ?>" title="Student Marks" class="btn btn-secondary py-1 px-2">
                                            <i class="bi bi-percent"></i>
                                        </a>
                                        <a href="update.php?studentId=<?= $student['student_number'] ?>" title="Edit Student" class="btn btn-primary py-1 px-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="delete.php?studentId=<?= $student['student_number'] ?>" title="Delete Student" class="btn btn-danger py-1 px-2">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Displaying a message if there are no students in the database -->
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center">There are no students in the database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= template_footer() ?>