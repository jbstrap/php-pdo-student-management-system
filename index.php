<?php
$title = 'Login';
include './classes/User.php';
$user = new User();

if ($user->isLoggedIn()) {
    $_SESSION['message'] = [
        'message' => 'You\'re already logged in!',
        'messageType' => 'success'
    ];
    header("Location: students.php");
}

// Initializing an empty response array to store messages
$response = [
    'message' => '',
    'messageType' => ''
];

// Checking if the form is submitted
if (isset($_POST['submit'])) {
    $redirectUrl = isset($_GET['redirectUrl']) ? $_GET['redirectUrl'] . '.php' : 'students.php';
    $output = $user->login($_POST);
    if ($output == 'success') {
        $output = [
            'message' => 'Logged in successfully!',
            'messageType' => 'success'
        ];
        $_SESSION['message'] = $output;
        header('Location: ' . $redirectUrl);
    }
    $response = [
        'message' => $output,
        'messageType' => 'danger'
    ];
}
?>

<?php include './includes/header.php'; ?>
<main class="form-signin w-100 m-auto">
    <div class="text-center">
        <img class="my-3 border rounded-circle p-3" src="./assets/images/student-50.png" alt="" width="100" height="100">
        <h1 class="h3 mb-4 fw-normal">Please sign in</h1>
    </div>
    <?php if ($response['message']) : ?>
        <div class="alert alert-<?php echo $response['messageType'] ?> alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-x-circle me-2"></i>
            <?= $response['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Displaying session message if set -->
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['message']['messageType'] ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-<?= $_SESSION['message']['messageType'] == 'success' ? 'circle' : 'x' ?>-circle me-2"></i>
            <?= $_SESSION['message']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php unset($_SESSION['message']); ?>

    <form action="" method="post" novalidate>
        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit" name="submit">Sign in</button>
        <p class="mt-5 mb-3 text-body-secondary text-center">© 2024</p>
    </form>
</main>
<?php include './includes/footer.php'; ?>