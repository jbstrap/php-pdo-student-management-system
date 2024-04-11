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

    // Querying the database to fetch the student marks with the specified ID
    $stmt2 = $pdo->prepare('SELECT * FROM marks WHERE student_number = ?');
    $stmt2->execute([$_GET['studentId']]);
    $marks = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Checking if the form is submitted
    if (isset($_POST['submit'])) {
        // Checking if all required fields are filled
        if (!empty($_POST['subject']) && !empty($_POST['mark'])) {
            // Preparing and executing the insert query
            $stmt = $pdo->prepare('INSERT INTO marks (student_number, subject, mark) VALUES (?, ?, ?)');
            $stmt->execute([
                $_GET['studentId'],
                $_POST['subject'],
                $_POST['mark']
            ]);

            // Setting success message and redirecting
            $response = [
                'message' => 'Student mark added!',
                'messageType' => 'success'
            ];
            header('Location: view.php?studentId=' . $_GET['studentId'] . '');
        } else {
            // Setting error message for required fields and validation
            $response = [
                'message' => 'Please fill all the required fields!',
                'messageType' => 'danger'
            ];
        }
    }

    // Handling post of deletion
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        // Deleting the mark from the database
        $stmt = $pdo->prepare('DELETE FROM marks WHERE id = ? AND student_number = ?');
        $stmt->execute([$_GET['markId'], $_GET['studentId']]);
        $response = [
            'message' => 'Mark deleted successfully!',
            'messageType' => 'success'
        ];
        header('Location: view.php?studentId=' . $_GET['studentId'] . '');
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

<?= template_header('Marks') ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6">
            <h2 class="mt-4 mb-3">Marks for Student #<?= $student['student_number'] ?></h2>
            <!-- Confirmation message -->
            <p>Add subject and marks for <span class="fw-bold"><?= $student['first_name'] ?></span></p>
            <?php if ($response['message']) : ?>
                <!-- Displaying response message if set -->
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div>
                <a href="students.php" class="btn btn-danger mb-3">
                    <i class="bi bi-chevron-left"></i> Cancel
                </a>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <?php if ($marks) : ?>
                        <ul class="list-group list-group-numbered">
                            <?php foreach ($marks as $mark) : ?>
                                <?php
                                $className = '';
                                if ($mark['mark'] <= 39) {
                                    $className = 'danger';
                                } elseif ($mark['mark'] > 39 && $mark['mark'] < 50) {
                                    $className = 'warning';
                                } else {
                                    $className = 'success';
                                } ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <?= $mark['subject'] ?>
                                    </div>
                                    <div class="badge text-bg-<?= $className ?> rounded-pill">
                                        <?= $mark['mark'] ?>%
                                    </div>
                                    <a href="?studentId=<?= $student['student_number'] ?>&markId=<?= $mark['id'] ?>&action=delete" title="Delete Student" class="btn btn-transparent p-0 ms-2">
                                        <i class="bi bi-trash3 text-danger"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <span>Student has no marks.</span>
                    <?php endif; ?>
                </div>
                <div class="col-12">
                    <form action="" method="post" novalidate class="row g-3 mt-2">
                        <div class="col-sm-6">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" aria-label="Subject">
                        </div>
                        <div class="col-sm">
                            <input type="number" name="mark" class="form-control" placeholder="Mark" aria-label="Mark">
                        </div>
                        <div class="col-sm">
                            <button type="submit" name="submit" class="btn btn-primary text-nowrap mb-3">
                                <i class="bi bi-plus-lg"></i> Add Mark
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= template_footer() ?>