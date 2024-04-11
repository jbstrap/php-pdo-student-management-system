<!-- 
    This code snippet updates the details of an existing student in the database. 
    It retrieves the student's current details, allows the user to update them via a form, 
    and then updates the database with the new information.
 -->

<?php
// Including functions.php file for necessary functions
include 'functions.php';

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Checking if a student ID is provided in the URL
if (isset($_GET['studentId'])) {
    // Establishing a database connection
    $pdo = dbConn();

    // Fetching student details from the database based on the provided student ID
    $stmt = $pdo->prepare('SELECT * FROM students WHERE student_number = ?');
    $stmt->execute([$_GET['studentId']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Redirecting to students.php if the student doesn't exist
    if (!$student) {
        $output = [
            'message' => 'Student doesn\'t exist with ID ' . $_GET['studentId'] . '!',
            'messageType' => 'danger'
        ];
        $_SESSION['message'] = $output;
        header('Location: students.php');
        exit;
    }

    // Handling form submission to update student details
    if (isset($_POST['submit'])) {
        // Checking if all required fields are filled
        if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['age']) && !empty($_POST['gender']) && !empty($_POST['email']) && !empty($_POST['phone_number']) && !empty($_POST['grade']) && !empty($_POST['address'])) {
            // Validating email format
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $response = [
                    'message' => 'Please provide a valid email address!',
                    'messageType' => 'danger'
                ];
            } else {
                // Updating student details in the database
                $pdo = dbConn();
                $stmt = $pdo->prepare('UPDATE students 
                                        SET first_name = ?, last_name = ?, age = ?, gender = ?, email = ?, phone_number = ?, grade = ?, address = ?
                                        WHERE student_number = ?');
                $stmt->execute([
                    $_POST['first_name'],
                    $_POST['last_name'],
                    $_POST['age'],
                    $_POST['gender'],
                    $_POST['email'],
                    $_POST['phone_number'],
                    $_POST['grade'],
                    $_POST['address'],
                    $_GET['studentId']
                ]);

                // Setting success message and redirecting to students.php
                $output = [
                    'message' => 'Student updated successfully!',
                    'messageType' => 'success'
                ];
                $_SESSION['message'] = $output;
                header('Location: students.php');
                exit;
            }
        } else {
            // Setting error message for required fields
            $response = [
                'message' => 'Please fill all the required fields!',
                'messageType' => 'danger'
            ];
        }
    }
} else {
    // Redirecting to students.php if no student ID is specified
    $output = [
        'message' => 'No ID specified!',
        'messageType' => 'danger'
    ];
    $_SESSION['message'] = $output;
    header('Location: students.php');
    exit;
}
?>

<?= template_header('Update Student') ?>

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
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" value="<?= $student['first_name'] ?>" class="form-control" id="first_name">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" value="<?= $student['last_name'] ?>" class="form-control" id="last_name">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" name="age" value="<?= $student['age'] ?>" class="form-control" id="age">
                </div>
                <!-- Radio buttons for gender selection -->
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Male" id="gender1" <?php if ($student['gender'] == 'Male') echo 'checked'; ?>>
                        <label class="form-check-label" for="gender1">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Female" id="gender2" <?php if ($student['gender'] == 'Female') echo 'checked'; ?>>
                        <label class="form-check-label" for="gender2">
                            Female
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Other" id="gender3" <?php if ($student['gender'] == 'Other') echo 'checked'; ?>>
                        <label class="form-check-label" for="gender3">
                            Other
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?= $student['email'] ?>" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" value="<?= $student['phone_number'] ?>" class="form-control" id="phone_number">
                </div>
                <div class="mb-3">
                    <label for="grade" class="form-label">Grade</label>
                    <select class="form-select" name="grade" id="grade" aria-label="Default select example">
                        <option selected>-- Select Grade --</option>
                        <option value="Grade 8" <?php if ($student['grade'] == 'Grade 8') echo 'selected'; ?>>Grade 8</option>
                        <option value="Grade 9" <?php if ($student['grade'] == 'Grade 9') echo 'selected'; ?>>Grade 9</option>
                        <option value="Grade 10" <?php if ($student['grade'] == 'Grade 10') echo 'selected'; ?>>Grade 10</option>
                        <option value="Grade 11" <?php if ($student['grade'] == 'Grade 11') echo 'selected'; ?>>Grade 11</option>
                        <option value="Grade 12" <?php if ($student['grade'] == 'Grade 12') echo 'selected'; ?>>Grade 12</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea type="text" name="address" class="form-control" id="address" rows="3"><?php if ($student['address']) echo $student['address']; ?></textarea>
                    <div class="form-text">Separate each address line with a comma (,).</div>
                </div>
                <!-- Submit and cancel buttons -->
                <div class="mt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update Student</button>
                    <a href="students.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= template_footer() ?>