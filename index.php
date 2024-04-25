<!-- 
    This code represents the homepage of a Student Management System. 
    I've added comments to describe each section, including the system's title, description, and functionalities.
 -->

<?php
$title = 'Home';
?>

<?php include './includes/header.php'; ?>
<div class="container py-3 py-md-5">
    <div class="row flex-lg-row-reverse g-3 pb-5">
        <div class="col-12 col-lg-5">
            <!-- Image of a student -->
            <img src="assets/images/student.jpg" class="d-block mx-lg-auto img-fluid rounded-3" alt="Student Image" loading="lazy">
        </div>
        <div class="col-12 col-lg-7">
            <!-- Title of the system -->
            <h2 class="text-body-emphasis">Student Management System</h2>
            <hr>
            <div class="mt-4 lead">
                <p>
                    <!-- Description of the Student CRUD system -->
                    A Student CRUD (Create, Read, Update, Delete) PHP system is a basic web application designed to
                    manage student records. Here's a simple description of how it works:
                </p>

                <ul>
                    <li><span class="fw-bold">Create:</span> Users can input information about a new student such as their name, age, gender, and other relevant details into a form. Upon submission, this information is stored in a database.</li>
                    <li><span class="fw-bold">Read:</span> Users can view a list of all students currently in the system. This typically involves displaying a table with each student's information retrieved from the database.</li>
                    <li><span class="fw-bold">Update:</span> Users can modify the details of an existing student. This functionality allows for editing information like the student's name, age, or any other relevant data.</li>
                    <li><span class="fw-bold">Delete:</span> Users can remove a student from the system entirely. This action deletes the student's record from the database.</li>
                </ul>

                <p>
                    <!-- Explanation of system components -->
                    The system typically consists of several PHP scripts and a database. The PHP scripts handle user requests, interact with the database to perform CRUD operations,
                    and generate HTML content to be displayed in the user's web browser.
                    The database stores student records in a structured format, allowing for efficient storage and retrieval of information.
                </p>

                <p>
                    <!-- Conclusion of the system's functionality -->
                    Overall, a Student CRUD PHP system provides a straightforward way to manage student records, enabling users to create,
                    view, update, and delete student information through a web interface.
                </p>
            </div>
        </div>
    </div>
</div>
<?php include './includes/footer.php'; ?>