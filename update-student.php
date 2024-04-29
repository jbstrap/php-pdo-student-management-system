<?php
$title = 'Update Student';
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

// Checking if a student ID is provided in the URL
if (isset($_GET['studentId'])) {
    // Create an instance of the Student class
    $student = new Student();
    // Call the getStudent method with get parameter
    $data = $student->getStudent($_GET);

    // Redirecting to students.php if the student doesn't exist
    if (!$data) {
        $output = [
            'message' => 'Student doesn\'t exist with ID ' . $_GET['studentId'] . '!',
            'messageType' => 'danger'
        ];
        $_SESSION['message'] = $output;
        header('Location: students.php');
    }

    // Handling form submission to update student details
    if (isset($_POST['submit'])) {
        $updateOutput = $student->updateStudent($_POST);
        if ($updateOutput == 'success') {
            $output = [
                'message' => 'Student updated successfully!',
                'messageType' => 'success'
            ];
            $_SESSION['message'] = $output;
            header('Location: students.php');
        }
        $response = [
            'message' => $updateOutput,
            'messageType' => 'danger'
        ];
    }
} else {
    // Redirecting to students.php if no student ID is specified
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: students.php');
}
?>

<?php include './includes/header.php'; ?>

<div class="container pb-5">
    <div class="row">
        <div class="col-5">
            <!-- Form to update student details -->
            <h2 class="mt-4 mb-3">Update Student</h2>
            <!-- Displaying response message if set -->
            <?php if ($response['message']) : ?>
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form action="" method="post" novalidate>
                <!-- Form fields pre-populated with student details -->
                <input type="hidden" name="student_number" value="<?= $data['student_number'] ?>">
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" value="<?= $data['first_name'] ?>" class="form-control" id="first_name">
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="<?= $data['last_name'] ?>" class="form-control" id="last_name">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" name="age" value="<?= $data['age'] ?>" class="form-control" id="age">
                    </div>
                    <!-- Radio buttons for gender selection -->
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Male" id="gender1" <?php if ($data['gender'] == 'Male') echo 'checked'; ?>>
                            <label class="form-check-label" for="gender1">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Female" id="gender2" <?php if ($data['gender'] == 'Female') echo 'checked'; ?>>
                            <label class="form-check-label" for="gender2">
                                Female
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Other" id="gender3" <?php if ($data['gender'] == 'Other') echo 'checked'; ?>>
                            <label class="form-check-label" for="gender3">
                                Other
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control" id="email">
                    </div>
                    <div class="form-group mb-2">
                        <label for="enrollment_date" class="form-label">Enrollment Date</label>
                        <input type="date" name="enrollment_date" value="<?= $data['enrollment_date'] ?>" class="form-control" id="enrollment_date">
                    </div>
                    <div class="row row-cols-2 gy-2">
                        <?php foreach ($courses->getCourses() as $course) : ?>
                            <?php
                            $isSelected = false;
                            foreach ($data['courses'] as $selected_course) {
                                if ($selected_course['course_id'] == $course['course_id']) {
                                    $isSelected = true;
                                    break;
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
                        <button type="submit" name="submit" class="btn btn-primary custom">Update Student</button>
                        <a href="students.php" class="btn btn-danger custom">Back to List</a>
                    </div>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>