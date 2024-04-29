<?php
$title = 'Delete Student';
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

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Check if student ID is set in the URL
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

    // Handling confirmation of deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Deleting the student from the database
            $deleteOutput = $student->deleteStudent($_GET['studentId']);
            if ($deleteOutput == 'success') {
                $output = [
                    'message' => 'Student deleted successfully!',
                    'messageType' => 'success'
                ];
                $_SESSION['message'] = $output;
                header('Location: students.php');
            }
            $response = [
                'message' => $deleteOutput,
                'messageType' => 'danger'
            ];
        } else {
            // Redirecting to students.php if deletion is cancelled
            header('Location: students.php');
        }
    }
} else {
    // Redirecting if no student ID is specified in the URL
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: students.php');
}
?>

<?php include './includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Heading for delete confirmation -->
            <h2 class="mt-4 mb-3">Delete Student #<?= $data['student_number'] ?></h2>
            <!-- Confirmation message -->
            <p>Are you sure you want to delete this?</p>
            <?php if ($response['message']) : ?>
                <!-- Displaying response message if set -->
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <hr />
            <dl class="row">
                <dt class="col-sm-2">
                    First Name
                </dt>
                <dd class="col-sm-10">
                    <?= $data['first_name'] ?>
                </dd>
                <dt class="col-sm-2">
                    Last Name
                </dt>
                <dd class="col-sm-10">
                    <?= $data['last_name'] ?>
                </dd>
                <dt class="col-sm-2">
                    Enrollment Date
                </dt>
                <dd class="col-sm-10">
                    <?= $data['enrollment_date'] ?>
                </dd>
            </dl>
            <div class="d-flex gap-2">
                <!-- Confirm and cancel buttons -->
                <a href="delete-student.php?studentId=<?= $data['student_number'] ?>&confirm=yes" class="btn btn-danger custom">Confirm</a>
                <a href="delete-student.php?studentId=<?= $data['student_number'] ?>&confirm=no" class="btn btn-primary custom">Cancel</a>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>