<?php
$title = 'View Department';
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

include './classes/Department.php';

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Check if department ID is set in the URL
if (isset($_GET['departmentId'])) {
    // Create an instance of the Department class
    $departments = new Department();
    // Call the getDepartment method with get parameter
    $department = $departments->getDepartment($_GET);

    // Redirecting to departments.php if the department doesn't exist
    if (!$department) {
        $output = [
            'message' => 'Department doesn\'t exist with ID ' . $_GET['departmentId'] . '!',
            'messageType' => 'danger'
        ];
        $_SESSION['message'] = $output;
        header('Location: departments.php');
    }
} else {
    // Redirecting if no department ID is specified in the URL
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: departments.php');
    exit;
}
?>

<?php include './includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6">
            <h2 class="mt-4 mb-3">Details for Department <?= $department['department_name'] ?></h2>
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
                    Name
                </dt>
                <dd class="col-sm-8">
                    <?= $department['department_name'] ?>
                </dd>
                <dt class="col-sm-4">
                    Salary
                </dt>
                <dd class="col-sm-8">
                    R <?= $department['salary'] ?>
                </dd>
                <dt class="col-sm-4">
                    Start Date
                </dt>
                <dd class="col-sm-8">
                    <?= $department['start_date'] ?>
                </dd>
                <dt class="col-sm-4">
                    Instructor
                </dt>
                <dd class="col-sm-8">
                    <?= $department['first_name'] ?>
                    <?= $department['last_name'] ?>
                </dd>
            </dl>
            <div class="d-flex gap-2">
                <a href="update-department.php?departmentId=<?= $department['department_id'] ?>" class="btn btn-primary custom">Edit</a>
                <a href="departments.php" class="btn btn-danger custom">Back to List</a>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>