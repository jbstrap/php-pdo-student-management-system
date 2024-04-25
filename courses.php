<!-- 
    The PHP script sets the page title and includes the Course class to fetch course data.
    The header is included.
    The main content is inside a container, with a row and column for alignment.
    It displays a heading, description, and a button to add a new course.
    If there's a session message set, it's displayed as an alert.
    The table displays course data, including course number, name, credits, department, and action buttons for viewing, editing, and deleting courses.
    If no courses are available, a message is displayed in the table. Finally, the footer is included.
 -->

<?php
// Setting the page title and including the Course class
$title = 'Courses';
include_once './classes/Course.php';
$courses = new Course();
?>

<?php include './includes/header.php'; ?>
<!-- Including the header -->

<div class="container">
    <!-- Main content container -->
    <div class="row">
        <!-- Row for course content -->
        <div class="col-12">
            <!-- Column for course content -->
            <div class="d-flex align-items-center justify-content-between mt-4 mb-3">
                <!-- Flexbox container for heading and button -->
                <div>
                    <!-- Heading for the page -->
                    <h3>Courses</h3>
                    <!-- Description of the page -->
                    <p>
                        List of all the courses.
                    </p>
                </div>
                <div>
                    <!-- Button to add a new course -->
                    <a href="add-course.php" class="btn btn-primary custom">
                        <i class="bi bi-plus-lg"></i> Add New
                    </a>
                </div>
            </div>
            <!-- Displaying session message if set -->
            <?php if (isset($_SESSION['message'])) : ?>
                <!-- Alert for session message -->
                <div class="alert alert-<?php echo $_SESSION['message']['messageType'] ?> alert-dismissible fade show" role="alert">
                    <!-- Icon for the message type -->
                    <i class="bi bi-check-circle me-2"></i>
                    <!-- Displaying the message -->
                    <?= $_SESSION['message']['message'] ?>
                    <!-- Button to dismiss the alert -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- Unsetting session message after displaying it -->
            <?php unset($_SESSION['message']); ?>
            <div>
                <!-- Table to display courses -->
                <table class="table table-hover">
                    <thead>
                        <!-- Table header -->
                        <tr class="table-light">
                            <th scope="col">Number</th>
                            <th scope="col">Name</th>
                            <th scope="col">Credits</th>
                            <th scope="col">Department</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <!-- Table body with course data -->
                        <?php if (!empty($courses->getCourses())) : ?>
                            <!-- Loop through courses to display each one -->
                            <?php foreach ($courses->getCourses() as $course) : ?>
                                <tr>
                                    <!-- Course number -->
                                    <td class="align-middle"><?= $course['course_number'] ?></td>
                                    <!-- Course name -->
                                    <td class="align-middle"><?= $course['course_name'] ?></td>
                                    <!-- Course credits -->
                                    <td class="align-middle"><?= $course['credits'] ?></td>
                                    <!-- Course department -->
                                    <td class="align-middle"><?= $course['department_name'] ?></td>
                                    <!-- Action buttons -->
                                    <td class="text-end align-middle text-nowrap">
                                        <!-- View course details -->
                                        <a href="view-course.php?courseId=<?= $course['course_number'] ?>" title="Course Details" class="btn btn-transparent btn-sm text-secondary">
                                            <i class="bi bi-eye fs-5"></i>
                                        </a>
                                        <!-- Edit course -->
                                        <a href="update-course.php?courseId=<?= $course['course_number'] ?>" title="Edit Course" class="btn btn-transparent btn-sm text-primary">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <!-- Delete course -->
                                        <a href="delete-course.php?courseId=<?= $course['course_number'] ?>" title="Delete Course" class="btn btn-transparent btn-sm text-danger">
                                            <i class="bi bi-trash3 fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <!-- Displayed when no courses are available -->
                            <tr>
                                <td colspan="9" class="text-center">There are no courses in the database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Including the footer -->
<?php include './includes/footer.php'; ?>