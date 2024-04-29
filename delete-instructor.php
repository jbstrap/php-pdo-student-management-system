<?php
$title = 'Delete Instructor';
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

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Check if instructor ID is set in the URL
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

    // Handling confirmation of deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Deleting the instructor from the database
            $deleteOutput = $instructors->deleteInstructor($_GET['instructorId']);
            if ($deleteOutput == 'success') {
                $output = [
                    'message' => 'Instructor deleted successfully!',
                    'messageType' => 'success'
                ];
                $_SESSION['message'] = $output;
                header('Location: instructors.php');
            }
            $response = [
                'message' => $deleteOutput,
                'messageType' => 'danger'
            ];
        } else {
            // Redirecting to instructors.php if deletion is cancelled
            header('Location: instructors.php');
        }
    }
} else {
    // Redirecting if no instructor ID is specified in the URL
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: instructors.php');
}
?>

<?php include './includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Heading for delete confirmation -->
            <h2 class="mt-4 mb-3">Delete Instructor <?= $instructor['first_name'] ?></h2>
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
                    <?= $instructor['first_name'] ?>
                </dd>
                <dt class="col-sm-2">
                    Last Name
                </dt>
                <dd class="col-sm-10">
                    <?= $instructor['last_name'] ?>
                </dd>
                <dt class="col-sm-2">
                    Email
                </dt>
                <dd class="col-sm-10">
                    <?= $instructor['email'] ?>
                </dd>
            </dl>
            <div class="d-flex gap-2">
                <!-- Confirm and cancel buttons -->
                <a href="delete-instructor.php?instructorId=<?= $instructor['instructor_id'] ?>&confirm=yes" class="btn btn-danger custom">Confirm</a>
                <a href="delete-instructor.php?instructorId=<?= $instructor['instructor_id'] ?>&confirm=no" class="btn btn-primary custom">Cancel</a>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>