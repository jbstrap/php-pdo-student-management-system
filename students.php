<?php
$title = 'Students';
include_once './classes/Student.php';
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
$students = new Student();
?>

<?php include './includes/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mt-4 mb-3">
                <div>
                    <h2>Students</h2>
                    <p>
                        List of all the students.
                    </p>
                </div>
                <div>
                    <!-- Button to add a new student -->
                    <a href="add-student.php" class="btn btn-primary custom">
                        <i class="bi bi-plus-lg"></i> Add New
                    </a>
                </div>
            </div>
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
                <table class="table table-hover">
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
                    <tbody class="table-group-divider">
                        <!-- Checking if there are students available -->
                        <?php if (!empty($students->getStudents())) : ?>
                            <!-- Looping through each student and displaying their information -->
                            <?php foreach ($students->getStudents() as $student) : ?>
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
<?php include './includes/footer.php'; ?>