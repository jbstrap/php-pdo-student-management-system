<!-- 
    This code handles the deletion of a student from the database. 
    It checks for the presence of the student ID in the URL, confirms the deletion, 
    and displays a confirmation message before executing the deletion.
 -->

<?php
// Including functions.php file for necessary functions
include 'functions.php';

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Check if student ID is set in the URL
if (isset($_GET['studentId'])) {
    // Establishing a database connection
    $pdo = dbConn();

    // Querying the database to fetch the student with the specified ID
    $stmt = $pdo->prepare('SELECT * FROM students WHERE student_number = ?');
    $stmt->execute([$_GET['studentId']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Redirecting if student doesn't exist
    if (!$student) {
        $output = [
            'message' => 'Student doesn\'t exist with ID ' . $_GET['studentId'] . '!',
            'messageType' => 'danger'
        ];
        $_SESSION['message'] = $output;
        header('Location: students.php');
        exit;
    }

    // Handling confirmation of deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Deleting the student from the database
            $stmt = $pdo->prepare('DELETE FROM students WHERE student_number = ?');
            $stmt->execute([$_GET['studentId']]);
            $output = [
                'message' => 'Student deleted successfully!',
                'messageType' => 'success'
            ];
            $_SESSION['message'] = $output;
            header('Location: students.php');
            exit;
        } else {
            // Redirecting to students.php if deletion is cancelled
            header('Location: students.php');
            exit;
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
    exit;
}
?>

<?= template_header('Delete') ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Heading for delete confirmation -->
            <h2 class="mt-4 mb-3">Delete Student #<?= $student['student_number'] ?></h2>
            <!-- Confirmation message -->
            <p>Are you sure you want to delete <span class="fw-bold"><?= $student['first_name'] ?></span>?</p>
            <?php if ($response['message']) : ?>
                <!-- Displaying response message if set -->
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div>
                <!-- Confirm and cancel buttons -->
                <a href="delete.php?studentId=<?= $student['student_number'] ?>&confirm=yes" class="btn btn-danger mb-3">Confirm</a>
                <a href="delete.php?studentId=<?= $student['student_number'] ?>&confirm=no" class="btn btn-primary mb-3">Cancel</a>
            </div>
        </div>
    </div>
</div>

<?= template_footer() ?>