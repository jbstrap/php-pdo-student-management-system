<?php
$title = 'Add Student';
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

include './classes/Student.php';
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
    // Create an instance of the Student class
    $student = new Student();
    // Call the addStudent method with form data
    $output = $student->addStudent($_POST);
    if ($output == 'success') {
        $output = [
            'message' => 'Student created successfully!',
            'messageType' => 'success'
        ];
        $_SESSION['message'] = $output;
        header('Location: students.php');
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
        <div class="col-12 col-md-5">
            <!-- Form to add a new student -->
            <h2 class="mt-4 mb-3">Add Student</h2>
            <!-- Displaying response message if set -->
            <?php if ($response['message']) : ?>
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form action="" method="post" novalidate>
                <!-- Form fields for student information -->
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name'] ?>" class="form-control" id="first_name">
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name'] ?>" class="form-control" id="last_name">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" name="age" value="<?php if (isset($_POST['age'])) echo $_POST['age'] ?>" class="form-control" id="age">
                </div>
                <!-- Radio buttons for gender selection -->
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Male" id="gender1" checked>
                        <label class="form-check-label" for="gender1">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Female" id="gender2">
                        <label class="form-check-label" for="gender2">
                            Female
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Other" id="gender3">
                        <label class="form-check-label" for="gender3">
                            Other
                        </label>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>" class="form-control" id="email">
                </div>
                <div class="form-group mb-3">
                    <label for="enrollment_date" class="form-label">Enrollment Date</label>
                    <input type="date" name="enrollment_date" value="<?php if (isset($_POST['enrollment_date'])) echo $_POST['enrollment_date'] ?>" class="form-control" id="enrollment_date">
                </div>
                <div class="row row-cols-2 gy-2">
                    <?php foreach ($courses->getCourses() as $course) : ?>
                        <?php
                        $isSelected = false;
                        if (isset($_POST['selected_courses'])) {
                            foreach ($_POST['selected_courses'] as $selected_course) {
                                if ($selected_course == $course['course_id']) {
                                    $isSelected = true;
                                    break;
                                }
                            }
                        }
                        ?>
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" name="selected_courses[]" class="form-check-input" id="course<?= $course['course_id'] ?>" value="<?= $course['course_id'] ?>" <?= $isSelected ? 'checked' : '' ?>>
                                <label class="form-check-label" for="course<?= $course['course_id'] ?>">
                                    <?= $course['course_number'] ?> - <?= $course['course_name'] ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Submit and cancel buttons -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary custom">Add Student</button>
                    <a href="students.php" class="btn btn-danger custom">Back to List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>