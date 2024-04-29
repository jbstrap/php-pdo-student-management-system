<?php
$title = 'View Student';
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
} else {
    // Redirecting if no student ID is specified in the URL
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: students.php');
    exit;
}
?>

<?php include './includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6">
            <h2 class="mt-4 mb-3">Details for Student #<?= $data['student_number'] ?></h2>
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
                <dt class="col-sm-4">
                    First Name
                </dt>
                <dd class="col-sm-8">
                    <?= $data['first_name'] ?>
                </dd>
                <dt class="col-sm-4">
                    Last Name
                </dt>
                <dd class="col-sm-8">
                    <?= $data['last_name'] ?>
                </dd>
                <dt class="col-sm-4">
                    Enrollment Date
                </dt>
                <dd class="col-sm-8">
                    <?= $data['enrollment_date'] ?>
                </dd>
            </dl>
            <div class="row my-3">
                <div class="col-12">
                    <?php if (!empty($data['courses'])) : ?>
                        <ul class="list-group list-group-numbered">
                            <?php foreach ($data['courses'] as $course) : ?>
                                <?php
                                $className = '';
                                if ($course['credits'] <= 39) {
                                    $className = 'danger';
                                } elseif ($course['credits'] > 39 && $course['credits'] < 50) {
                                    $className = 'warning';
                                } else {
                                    $className = 'success';
                                } ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <?= $course['course_name'] ?>
                                    </div>
                                    <div class="badge text-bg-<?= $className ?> rounded-pill">
                                        <?= $course['credits'] ?>%
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <span>Student is not enrolled in any courses.</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="update-student.php?studentId=<?= $data['student_number'] ?>" class="btn btn-primary custom">Edit</a>
                <a href="students.php" class="btn btn-danger custom">Back to List</a>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>