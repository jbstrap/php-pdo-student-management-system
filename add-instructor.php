<?php
$title = 'Add Instructor';
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

// Checking if the form is submitted
if (isset($_POST['submit'])) {
    // Create an instance of the Instructor class
    $instructor = new Instructor();
    // Call the addInstructor method with form data
    $output = $instructor->addInstructor($_POST);
    if ($output == 'success') {
        $output = [
            'message' => 'Instructor created successfully!',
            'messageType' => 'success'
        ];
        $_SESSION['message'] = $output;
        header('Location: instructors.php');
    }
    $response = [
        'message' => $output,
        'messageType' => 'danger'
    ];
}
?>

<?php include './includes/header.php'; ?>

<div class="container pb-5">
    <div class="row">
        <div class="col-12 col-lg-5">
            <!-- Form to add a new instructor -->
            <h2 class="mt-4 mb-3">Add Instructor</h2>
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
                <div class="form-group mb-2">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name'] ?>" class="form-control" id="first_name">
                </div>
                <div class="form-group mb-2">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name'] ?>" class="form-control" id="last_name">
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>" class="form-control" id="email">
                </div>
                <div class="row row-cols-2 gy-2">
                    <?php foreach ($courses->getCourses() as $course) : ?>
                        <?php
                        $isSelected = false;
                        if (isset($_POST['selected_courses'])) {
                            foreach ($_POST['selected_courses'] as $selected_course) {
                                if ($selected_course == $course['course_number']) {
                                    $isSelected = true;
                                    break;
                                }
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
                    <button type="submit" name="submit" class="btn btn-primary custom">Add Instructor</button>
                    <a href="instructors.php" class="btn btn-danger custom">Back to List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>