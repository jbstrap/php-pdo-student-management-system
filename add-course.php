<!-- 
    The PHP script at the top sets the page title, includes necessary classes (Course.php and Department.php), and handles form submission.
    Inside the container, there's a row with a col-md-5 column, which contains the form to add a new course.
    The form includes input fields for course number, name, credits, and a dropdown menu to select the department.
    If there's a response message set, it's displayed using an alert component from Bootstrap.
    The form action is set to an empty string, indicating that the form will be submitted to the same page.
    Finally, the header and footer are included.
 -->

<?php
$title = 'Add Course';
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

include './classes/Course.php';
include './classes/Department.php';
$departments = new Department();

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Checking if the form is submitted
if (isset($_POST['submit'])) {
    // Create an instance of the Course class
    $course = new Course();
    // Call the addCourse method with form data
    $output = $course->addCourse($_POST);
    if ($output == 'success') {
        $output = [
            'message' => 'Course created successfully!',
            'messageType' => 'success'
        ];
        $_SESSION['message'] = $output;
        header('Location: courses.php');
    }
    $response = [
        'message' => $output,
        'messageType' => 'danger'
    ];
}
?>

<!-- Including the header -->
<?php include './includes/header.php'; ?>

<!-- Main content area -->
<div class="container pb-5">
    <div class="row">
        <div class="col-12 col-md-5">
            <!-- Form to add a new course -->
            <h2 class="mt-4 mb-3">Add Course</h2>
            <!-- Displaying response message if set -->
            <?php if ($response['message']) : ?>
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- Course addition form -->
            <form action="" method="post" novalidate>
                <!-- Form fields for course information -->
                <div class="form-group mb-2">
                    <label for="course_number" class="form-label">Number</label>
                    <input type="number" name="course_number" value="<?php if (isset($_POST['course_number'])) echo $_POST['course_number'] ?>" class="form-control" id="course_number">
                </div>
                <div class="form-group mb-2">
                    <label for="course_name" class="form-label">Name</label>
                    <input type="text" name="course_name" value="<?php if (isset($_POST['course_name'])) echo $_POST['course_name'] ?>" class="form-control" id="course_name">
                </div>
                <div class="form-group mb-2">
                    <label for="credits" class="form-label">Credits</label>
                    <input type="number" name="credits" value="<?php if (isset($_POST['credits'])) echo $_POST['credits'] ?>" class="form-control" id="credits">
                </div>
                <div class="form-group mb-2">
                    <label for="department_id" class="form-label">Department</label>
                    <select class="form-select" name="department_id" id="department_id" aria-label="Default select example">
                        <option value="">-- Select Department --</option>
                        <!-- Loop through departments to populate dropdown options -->
                        <?php foreach ($departments->getDepartments() as $department) : ?>
                            <option value="<?= $department['department_id'] ?>" <?php if (isset($_POST['department_id']) && $_POST['department_id'] == $department['department_id']) echo 'selected'; ?>>
                                <?= $department['department_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Submit and cancel buttons -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary custom">Add Course</button>
                    <a href="courses.php" class="btn btn-danger custom">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Including the footer -->
<?php include './includes/footer.php'; ?>