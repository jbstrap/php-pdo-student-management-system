<!-- 
    This code handles the addition of a new student to the database. 
    It validates the form fields for required data and email format. 
    It then inserts the student information into the database and 
    redirects to the students page upon successful addition.
 -->

<?php
// Including functions.php file for necessary functions
include 'functions.php';

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Checking if the form is submitted
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
            // Establishing a database connection
            $pdo = dbConn();

            // Preparing and executing the insert query
            $stmt = $pdo->prepare('INSERT INTO 
                                students (first_name, last_name, age, gender, email, phone_number, address) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['age'],
                $_POST['gender'],
                $_POST['email'],
                $_POST['phone_number'],
                $_POST['grade'],
                $_POST['address']
            ]);

            // Setting success message and redirecting
            $output = [
                'message' => 'Student created successfully!',
                'messageType' => 'success'
            ];
            $_SESSION['message'] = $output;
            header('Location: students.php');
            exit;
        }
    } else {
        // Setting error message for required fields and validation
        $response = [
            'message' => 'Please fill all the required fields!',
            'messageType' => 'danger'
        ];
    }
}
?>

<?= template_header('Add Student') ?>

<div class="container pb-5">
    <div class="row">
        <div class="col-5">
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
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name'] ?>" class="form-control" id="first_name">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name'] ?>" class="form-control" id="last_name">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" name="age" value="<?php if (isset($_POST['age'])) echo $_POST['age'] ?>" class="form-control" id="age">
                </div>
                <!-- Radio buttons for gender selection -->
                <div class="d-flex align-items-center gap-3 mb-3">
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
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" value="<?php if (isset($_POST['phone_number'])) echo $_POST['phone_number'] ?>" class="form-control" id="phone_number">
                </div>
                <div class="mb-3">
                    <label for="grade" class="form-label">Grade</label>
                    <select class="form-select" name="grade" id="grade" aria-label="Default select example">
                        <option selected>-- Select Grade --</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea type="text" name="address" class="form-control" id="address" rows="3"><?php if (isset($_POST['address'])) echo $_POST['address'] ?></textarea>
                    <div class="form-text">Separate each address line with a comma (,).</div>
                </div>
                <!-- Submit and cancel buttons -->
                <div class="mt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Add Student</button>
                    <a href="students.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= template_footer() ?>