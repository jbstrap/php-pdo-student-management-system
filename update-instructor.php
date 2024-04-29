<?php
$title = 'Update Instructor';
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

include './classes/Instructor.php';
include './classes/Course.php';
// Create an instance of the Course class
$courses = new Course();

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Checking if a instructor ID is provided in the URL
if (isset($_GET['instructorId'])) {
    // Create an instance of the Instructor class
    $instructors = new Instructor();
    // Call the getInstructor method with get parameter
    $instructor = $instructors->getInstructor($_GET);

    // Redirecting to instructors.php if the instructor doesn't exist
    if (!$instructor) {
        $output = [
            'message' => 'Instructor doesn\'t exist with ID ' . $_GET['instructorId'] . '!',
            'messageType' => 'danger'
        ];
        $_SESSION['message'] = $output;
        header('Location: instructors.php');
    }

    // Handling form submission to update instructor details
    if (isset($_POST['submit'])) {
        $updateOutput = $instructors->updateInstructor($_POST);
        if ($updateOutput == 'success') {
            $output = [
                'message' => 'Instructor updated successfully!',
                'messageType' => 'success'
            ];
            $_SESSION['message'] = $output;
            header('Location: instructors.php');
        }
        $response = [
            'message' => $updateOutput,
            'messageType' => 'danger'
        ];
    }
} else {
    // Redirecting to instructors.php if no instructor ID is specified
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: instructors.php');
}
?>

<?php include './includes/header.php'; ?>

<div class="container pb-5">
    <div class="row">
        <div class="col-12 col-lg-5">
            <!-- Form to update an instructor -->
            <h2 class="mt-4 mb-3">Update Instructor</h2>
            <!-- Displaying response message if set -->
            <?php if ($response['message']) : ?>
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form action="" method="post" novalidate>
                <!-- Form fields for instructor information -->
                <input type="hidden" name="instructor_id" value="<?= $instructor['instructor_id'] ?>">
                <div class="form-group mb-2">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" value="<?= $instructor['first_name'] ?>" class="form-control" id="first_name">
                </div>
                <div class="form-group mb-2">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" value="<?= $instructor['last_name'] ?>" class="form-control" id="last_name">
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?= $instructor['email'] ?>" class="form-control" id="email">
                </div>
                <div class="row row-cols-2 gy-2">
                    <?php foreach ($courses->getCourses() as $course) : ?>
                        <?php
                        $isSelected = false;
                        foreach ($instructors->getInstructorCourses($_GET) as $selected_course) {
                            if ($selected_course['course_number'] == $course['course_number']) {
                                $isSelected = true;
                                break;
                            }
                        }
                        ?>
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" name="selected_courses[]" class="form-check-input" id="course<?= $course['course_number'] ?>" value="<?= $course['course_number'] ?>" <?= $isSelected ? 'checked' : '' ?>>
                                <label class="form-check-label" for="course<?= $course['course_number'] ?>">
                                    <?= $course['course_number'] ?> - <?= $course['course_name'] ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Submit and cancel buttons -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary custom">Update Instructor</button>
                    <a href="instructors.php" class="btn btn-danger custom">Back to List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>