<!-- 
    The PHP script sets the page title and includes the necessary class for managing courses.
    It initializes an empty response array to store messages.
    It checks if a course ID is provided in the URL and retrieves the course details.
    If the course ID is not provided or the course doesn't exist, it redirects to the courses page with an appropriate message.
    The header is included.
    The main content is inside a container, with a row and column for alignment.
    It displays the details of the course in a list format.
    It provides buttons to edit the course and navigate back to the course list.
    Finally, the footer is included.
 -->

<?php
// Setting the page title and including necessary classes
$title = 'View Course';
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
} else {
    // Redirecting if no course ID is specified in the URL
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: courses.php');
    exit; // Exiting the script after redirection
}
?>

<?php include './includes/header.php'; ?>
<!-- Including the header -->

<div class="container">
    <!-- Main content container -->
    <div class="row">
        <!-- Row for course details -->
        <div class="col-12 col-lg-6">
            <!-- Column for course details -->
            <h2 class="mt-4 mb-3">Details for Course #<?= $course['course_number'] ?></h2>
            <!-- Displaying response message if set -->
            <?php if ($response['message']) : ?>
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <!-- Button to dismiss the alert -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <hr />
            <!-- Course details list -->
            <dl class="row">
                <dt class="col-sm-4">
                    Number
                </dt>
                <dd class="col-sm-8">
                    <?= $course['course_number'] ?>
                </dd>
                <dt class="col-sm-4">
                    Name
                </dt>
                <dd class="col-sm-8">
                    <?= $course['course_name'] ?>
                </dd>
                <dt class="col-sm-4">
                    Credits
                </dt>
                <dd class="col-sm-8">
                    <?= $course['credits'] ?>
                </dd>
                <dt class="col-sm-4">
                    Department
                </dt>
                <dd class="col-sm-8">
                    <?= $course['department_name'] ?>
                </dd>
            </dl>
            <!-- Buttons for editing and navigating back -->
            <div class="d-flex gap-2">
                <a href="update-course.php?courseId=<?= $course['course_number'] ?>" class="btn btn-primary custom">Edit</a>
                <a href="courses.php" class="btn btn-danger custom">Back to List</a>
            </div>
        </div>
    </div>
</div>
<!-- Including the footer -->
<?php include './includes/footer.php'; ?>