<!-- 
    The PHP script sets the page title and includes necessary classes for course and department management.
    It retrieves the course details based on the course ID provided in the URL.
    If the course ID is not provided or the course doesn't exist, it redirects to the courses page with an appropriate message.
    It handles the form submission to update course details.
    The header is included.
    The main content is inside a container, with a row and column for alignment.
    It displays a form to update course details, pre-filled with existing course information.
    It provides buttons to submit the form or cancel the update.
    Finally, the footer is included.
 -->

<?php
// Setting the page title and including necessary classes
$title = 'Update Course';
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
// Create an instance of the Department class
$departments = new Department();

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Checking if a course ID is provided in the URL
if (isset($_GET['courseId'])) {
    // Create an instance of the Course class
    $courses = new Course();
    // Call the getCourse method with get parameter
    $course = $courses->getCourse($_GET);

    // Redirecting to courses.php if the course doesn't exist
    if (!$course) {
        $output = [
            'message' => 'Course doesn\'t exist with ID ' . $_GET['courseId'] . '!',
            'messageType' => 'danger'
        ];
        $_SESSION['message'] = $output;
        header('Location: courses.php');
    }

    // Handling form submission to update course details
    if (isset($_POST['submit'])) {
        $updateOutput = $courses->updateCourse($_POST);
        if ($updateOutput == 'success') {
            $output = [
                'message' => 'Course updated successfully!',
                'messageType' => 'success'
            ];
            $_SESSION['message'] = $output;
            header('Location: courses.php');
        }
        $response = [
            'message' => $updateOutput,
            'messageType' => 'danger'
        ];
    }
} else {
    // Redirecting to courses.php if no course ID is specified
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: courses.php');
}
?>

<?php include './includes/header.php'; ?>
<!-- Including the header -->

<div class="container pb-5">
    <!-- Main content container -->
    <div class="row">
        <!-- Row for course update form -->
        <div class="col-12 col-md-5">
            <!-- Column for course update form -->
            <!-- Form to update a course -->
            <h2 class="mt-4 mb-3">Update Course</h2>
            <!-- Displaying response message if set -->
            <?php if ($response['message']) : ?>
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <!-- Button to dismiss the alert -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form action="" method="post" novalidate>
                <!-- Form fields for course information -->
                <input type="hidden" name="department_id" value="<?= $department['department_id'] ?>">
                <div class="form-group mb-2">
                    <label for="course_number" class="form-label">Number</label>
                    <input type="text" name="course_number" value="<?= $course['course_number'] ?>" class="form-control-plaintext fw-bold" id="course_number">
                </div>
                <div class="form-group mb-2">
                    <label for="course_name" class="form-label">Name</label>
                    <input type="text" name="course_name" value="<?= $course['course_name'] ?>" class="form-control" id="course_name">
                </div>
                <div class="form-group mb-2">
                    <label for="credits" class="form-label">Credits</label>
                    <input type="number" name="credits" value="<?= $course['credits'] ?>" class="form-control" id="credits">
                </div>
                <div class="form-group mb-2">
                    <label for="department_id" class="form-label">Department</label>
                    <select class="form-select" name="department_id" id="department_id" aria-label="Default select example">
                        <option value="">-- Select Department --</option>
                        <!-- Looping through departments -->
                        <?php foreach ($departments->getDepartments() as $department) : ?>
                            <option value="<?= $department['department_id'] ?>" <?php if ($course['department_id'] == $department['department_id']) echo 'selected'; ?>>
                                <?= $department['department_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Submit and cancel buttons -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary custom">Update Course</button>
                    <a href="courses.php" class="btn btn-danger custom">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Including the footer -->
<?php include './includes/footer.php'; ?>