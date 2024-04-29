<?php
$title = 'Add Department';
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
include './classes/Instructor.php';
$instructors = new Instructor();

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Checking if the form is submitted
if (isset($_POST['submit'])) {
    // Create an instance of the Department class
    $department = new Department();
    // Call the addDepartment method with form data
    $output = $department->addDepartment($_POST);
    if ($output == 'success') {
        $output = [
            'message' => 'Department created successfully!',
            'messageType' => 'success'
        ];
        $_SESSION['message'] = $output;
        header('Location: departments.php');
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
            <!-- Form to add a new department -->
            <h2 class="mt-4 mb-3">Add Department</h2>
            <!-- Displaying response message if set -->
            <?php if ($response['message']) : ?>
                <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?= $response['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form action="" method="post" novalidate>
                <!-- Form fields for department information -->
                <div class="form-group mb-2">
                    <label for="department_name" class="form-label">Name</label>
                    <input type="text" name="department_name" value="<?php if (isset($_POST['department_name'])) echo $_POST['department_name'] ?>" class="form-control" id="department_name">
                </div>
                <div class="form-group mb-2">
                    <label for="salary" class="form-label">Salary</label>
                    <input type="number" name="salary" value="<?php if (isset($_POST['salary'])) echo $_POST['salary'] ?>" class="form-control" id="salary">
                </div>
                <div class="form-group mb-2">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" value="<?php if (isset($_POST['start_date'])) echo $_POST['start_date'] ?>" class="form-control" id="start_date">
                </div>
                <div class="form-group mb-2">
                    <label for="instructor_id" class="form-label">Instructor</label>
                    <select class="form-select" name="instructor_id" id="instructor_id" aria-label="Default select example">
                        <option value="">-- Select Instructor --</option>
                        <?php foreach ($instructors->getInstructors() as $instructor) : ?>
                            <option value="<?= $instructor['instructor_id'] ?>" <?php if (isset($_POST['instructor_id']) && $_POST['instructor_id'] == $instructor['instructor_id']) echo 'selected'; ?>>
                                <?= $instructor['first_name'] ?> <?= $instructor['last_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Submit and cancel buttons -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary custom">Add Department</button>
                    <a href="departments.php" class="btn btn-danger custom">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>