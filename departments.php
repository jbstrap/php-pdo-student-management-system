<?php
$title = 'Departments';
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

include_once './classes/Department.php';
$departments = new Department();
?>

<?php include './includes/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mt-4 mb-3">
                <div>
                    <h3>Departments</h3>
                    <p>
                        List of all the departments.
                    </p>
                </div>
                <div>
                    <!-- Button to add a new department -->
                    <a href="add-department.php" class="btn btn-primary custom">
                        <i class="bi bi-plus-lg"></i> Add New
                    </a>
                </div>
            </div>
            <!-- Displaying session message if set -->
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-<?php echo $_SESSION['message']['messageType'] ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= $_SESSION['message']['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['message']); ?>
            <div>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-light">
                            <th scope="col">Name</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Instructor</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php if (!empty($departments->getDepartments())) : ?>
                            <?php foreach ($departments->getDepartments() as $department) : ?>
                                <tr>
                                    <td class="align-middle"><?= $department['department_name'] ?></td>
                                    <td class="align-middle">R <?= $department['salary'] ?></td>
                                    <td class="align-middle"><?= $department['start_date'] ?></td>
                                    <td class="align-middle"><?= $department['first_name'] ?> <?= $department['last_name'] ?></td>
                                    <td class="text-end align-middle text-nowrap">
                                        <a href="view-department.php?departmentId=<?= $department['department_id'] ?>" title="Department Details" class="btn btn-transparent btn-sm text-secondary">
                                            <i class="bi bi-eye fs-5"></i>
                                        </a>
                                        <a href="update-department.php?departmentId=<?= $department['department_id'] ?>" title="Edit Department" class="btn btn-transparent btn-sm text-primary">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <a href="delete-department.php?departmentId=<?= $department['department_id'] ?>" title="Delete Department" class="btn btn-transparent btn-sm text-danger">
                                            <i class="bi bi-trash3 fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center">There are no departments in the database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include './includes/footer.php'; ?>