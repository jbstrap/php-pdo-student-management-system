<!-- 
    The PHP script sets the page title and includes the Course class to interact with course data.
    It handles the confirmation of course deletion and redirects accordingly.
    If the course ID is not specified in the URL or if the course doesn't exist, it redirects to the courses page with an appropriate message.
    The header is included.
    The main content is inside a container, with a row and column for alignment.
    It displays a heading for delete confirmation, a message asking for confirmation, and course details.
    It provides buttons to confirm or cancel the deletion.
    Finally, the footer is included.
 -->

<?php
// Setting the page title and including the Course class
$title = 'Delete Course';
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

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Check if course ID is set in the URL
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

    // Handling confirmation of deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Deleting the course from the database
            $deleteOutput = $courses->deleteCourse($_GET['courseId']);
            if ($deleteOutput == 'success') {
                $output = [
                    'message' => 'Course deleted successfully!',
                    'messageType' => 'success'
                ];
                $_SESSION['message'] = $output;
                header('Location: courses.php');
            }
            $response = [
                'message' => $deleteOutput,
                'messageType' => 'danger'
            ];
        } else {
            // Redirecting to courses.php if deletion is cancelled
            header('Location: courses.php');
        }
    }
} else {
    // Redirecting if no course ID is specified in the URL
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

<div class="container">
    <!-- Main content container -->
    <div class="row">
        <!-- Row for course content -->
        <div class="col-12">
            <!-- Column for course content -->
            <!-- Heading for delete confirmation -->
            <h2 class="mt-4 mb-3">Delete Course #<?= $course['course_number'] ?></h2>
            <!-- Confirmation message -->
            <p>Are you sure you want to delete this?</p>
            <?php if ($response['message']) : ?>
                <!-- Displaying response message if set -->
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <!-- Button to dismiss the alert -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <hr />
            <!-- Description list for course details -->
            <dl class="row">
                <dt class="col-sm-2">
                    Number
                </dt>
                <dd class="col-sm-10">
                    <?= $course['course_number'] ?>
                </dd>
                <dt class="col-sm-2">
                    Name
                </dt>
                <dd class="col-sm-10">
                    <?= $course['course_name'] ?>
                </dd>
                <dt class="col-sm-2">
                    Credits
                </dt>
                <dd class="col-sm-10">
                    <?= $course['credits'] ?>
                </dd>
                <dt class="col-sm-2">
                    Department
                </dt>
                <dd class="col-sm-10">
                    <?= $course['department_name'] ?>
                </dd>
            </dl>
            <div class="d-flex gap-2">
                <!-- Confirm and cancel buttons -->
                <a href="delete-course.php?courseId=<?= $course['course_number'] ?>&confirm=yes" class="btn btn-danger custom">Confirm</a>
                <a href="delete-course.php?courseId=<?= $course['course_number'] ?>&confirm=no" class="btn btn-primary custom">Cancel</a>
            </div>
        </div>
    </div>
</div>
<!-- Including the footer -->
<?php include './includes/footer.php'; ?>