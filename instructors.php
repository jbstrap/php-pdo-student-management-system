<?php
$title = 'Instructors';
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

include_once './classes/Instructor.php';
$instructors = new Instructor();
?>

<?php include './includes/header.php'; ?>
<div class="container pb-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mt-4 mb-3">
                <div>
                    <h2>Instructors</h2>
                    <p>
                        List of all the instructors.
                        Select a row to view details below.
                    </p>
                </div>
                <div>
                    <!-- Button to add a new instructor -->
                    <a href="add-instructor.php" class="btn btn-primary custom">
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
            <!-- Table to display instructor information -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-light">
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Courses</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <!-- Checking if there are instructors available -->
                        <?php if (!empty($instructors->getInstructors())) : ?>
                            <!-- Looping through each instructor and displaying their information -->
                            <?php foreach ($instructors->getInstructors() as $instructor) : ?>
                                <?php
                                $selectedRow = "";
                                if (isset($_GET['instructorId']) && $instructor['instructor_id'] == $_GET['instructorId']) {
                                    $selectedRow = "table-warning";
                                }
                                ?>
                                <tr class="<?= $selectedRow ?>">
                                    <!-- Displaying instructor details -->
                                    <td class="align-middle"><?= $instructor['first_name'] ?></td>
                                    <td class="align-middle"><?= $instructor['last_name'] ?></td>
                                    <td class="align-middle"><?= $instructor['email'] ?></td>
                                    <td class="align-middle">
                                        <?= !empty($instructor['courses_taught']) ? $instructor['courses_taught'] : '-' ?>
                                    </td>
                                    <!-- Links to update and delete instructor -->
                                    <td class="text-end align-middle text-nowrap">
                                        <a href="?instructorId=<?= $instructor['instructor_id'] ?>" title="View Instructor Details" class="text-decoration-none">
                                            <?= isset($_GET['instructorId']) && $_GET['instructorId'] == $instructor['instructor_id'] ? 'Selected' : 'Select'; ?>
                                        </a>
                                        <a href="update-instructor.php?instructorId=<?= $instructor['instructor_id'] ?>" title="Edit Instructor" class="btn btn-transparent btn-sm text-secondary">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <a href="delete-instructor.php?instructorId=<?= $instructor['instructor_id'] ?>" title="Delete Instructor" class="btn btn-transparent btn-sm text-danger">
                                            <i class="bi bi-trash3 fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Displaying a message if there are no instructors in the database -->
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center">There are no instructors in the database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (isset($_GET['instructorId']) && !empty($instructors->getInstructors())) : ?>
                <div class="row row-cols-1 row-cols-md-2 mt-4">
                    <div class="col">
                        <h3>Courses Taught by Selected Instructor</h3>
                        <!-- Table to display instructor information -->
                        <div class="table-responsive mt-4">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-light">
                                        <th scope="col"></th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Department</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <!-- Checking if there are instructors available -->
                                    <?php if (!empty(isset($_GET['instructorId']) && $instructors->getInstructorCourses($_GET))) : ?>
                                        <!-- Looping through each course and displaying their information -->
                                        <?php foreach ($instructors->getInstructorCourses($_GET) as $course) : ?>
                                            <?php
                                            $courseSelectedRow = "";
                                            if (isset($_GET['courseId']) && $course['course_id'] == $_GET['courseId']) {
                                                $courseSelectedRow = "table-warning";
                                                $selector = "#course" . $course["course_id"]; // Adjust the selector to match your HTML structure
                                                echo "<script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        var selectedRow = document.querySelector('$selector');
                                                        if(selectedRow) {
                                                            selectedRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                                        }
                                                    });
                                                </script>";
                                            }
                                            ?>
                                            <tr class="<?= $courseSelectedRow ?>" id="course<?= $course['course_id'] ?>">
                                                <!-- Displaying course details -->
                                                <!-- Links to update and delete course -->
                                                <td class="align-middle text-nowrap">
                                                    <a href="?instructorId=<?= $_GET['instructorId'] ?>&courseId=<?= $course['course_id'] ?>" title="View Course Details" class="text-decoration-none">
                                                        <?= isset($_GET['courseId']) && $_GET['courseId'] == $course['course_id'] ? 'Selected' : 'Select'; ?>
                                                    </a>
                                                </td>
                                                <td class="align-middle"><?= $course['course_number'] ?></td>
                                                <td class="align-middle"><?= $course['course_name'] ?></td>
                                                <td class="align-middle"><?= $course['department_name'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <!-- Displaying a message if there are no courses in the database -->
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="9" class="text-center">There are no courses for selected instructor.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if (!empty(isset($_GET['courseId']) && $instructors->getInstructorCourses($_GET))) : ?>
                        <div class="col">
                            <h3>Students Enrolled in Selected Course</h3>
                            <div class="table-responsive mt-4">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="table-light">
                                            <th scope="col">St. Number</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php if (!empty(isset($_GET['courseId']) && $instructors->getCourseStudents($_GET))) : ?>
                                            <?php foreach ($instructors->getCourseStudents($_GET) as $student) : ?>
                                                <?php
                                                $gradeClass = '';
                                                if ($student['grade'] <= 39) {
                                                    $gradeClass = 'danger';
                                                } elseif ($student['grade'] > 39 && $student['grade'] < 50) {
                                                    $gradeClass = 'warning';
                                                } else {
                                                    $gradeClass = 'success';
                                                } ?>
                                                <tr>
                                                    <td class="align-middle"><?= $student['student_number'] ?></td>
                                                    <td class="align-middle"><?= $student['first_name'] ?></td>
                                                    <td class="align-middle text-<?= $gradeClass ?> fw-bold">
                                                        <?= !empty($student['grade']) ? $student['grade'] : 0 ?>%
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="9" class="text-center">There are no students enrolled for selected course.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include './includes/footer.php'; ?>