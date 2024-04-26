<?php
// Include the parent class definition
include_once 'Db.php';

/**
 * Class Student
 * A class for managing students in a student management system, extending the DB class for database operations.
 */
class Student extends DB
{
    // Attribute
    private $output = '';

    /**
     * Constructor method.
     * Calls the parent constructor to establish a database connection.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all students from the database.
     *
     * @return array|string Returns an array of student details or an error message as a string.
     */
    public function getStudents()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT s.student_number, s.first_name, s.last_name, s.age, s.gender, s.email, s.enrollment_date
                FROM Students s
                LEFT JOIN enrollments e
                ON s.student_number = e.student_number
                GROUP BY s.student_number
                ORDER BY s.student_number DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Get details of a specific student by their ID.
     *
     * @param array $data An array containing the student ID.
     * @return array|string Returns an array of student details or an error message as a string.
     */
    public function getStudent($data)
    {
        try {
            $id = $data['studentId'];

            $stmt = $this->conn->prepare(
                "SELECT student_number, first_name, last_name, age, gender, email, enrollment_date
            FROM students
            WHERE student_number = ?"
            );
            $stmt->execute([$id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            // Fetch the courses for the student
            $coursesStmt = $this->conn->prepare(
                "SELECT c.course_name, c.credits,
                c.course_id
            FROM enrollments e
            JOIN courses c ON c.course_id = e.course_id
            WHERE e.student_number = ?"
            );
            $coursesStmt->execute([$id]);
            $courses = $coursesStmt->fetchAll(PDO::FETCH_ASSOC);

            // Add courses to the student array
            $student['courses'] = $courses;

            return $student; // Return the student with courses
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Add a new student to the database.
     *
     * @param array $data An array containing student details.
     * @return string Returns a success message or an error message as a string.
     */
    public function addStudent($data)
    {
        try {
            // Clean input data
            $first_name = $this->clean_input($data['first_name']);
            $last_name = $this->clean_input($data['last_name']);
            $age = $this->clean_input($data['age']);
            $gender = $this->clean_input($data['gender']);
            $email = $this->clean_input($data['email']);
            $enrollment_date = $this->clean_input($data['enrollment_date']);

            // Check for empty fields
            if (empty($first_name) || empty($last_name) || empty($age) || empty($gender) || empty($email) || empty($enrollment_date)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Validate email address
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->output = 'Please provide a valid email address!';
                return $this->output;
            }

            // Insert new student into the database
            $stmt = $this->conn->prepare(
                "INSERT INTO students (first_name, last_name, age, gender, email, enrollment_date) 
                VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$first_name, $last_name, $age, $gender, $email, $enrollment_date]);
            $student_number = $this->conn->lastInsertId();
            // Insert courses student enrolled in
            if (!empty($data['selected_courses'])) {
                foreach ($data['selected_courses'] as $course) {
                    $stmtCourse = $this->conn->prepare(
                        "INSERT INTO enrollments (student_number , course_id)
                    VALUES (?, ?)"
                    );
                    $stmtCourse->execute([$student_number, $course]);
                }
            }
            $this->output = 'success';
            return $this->output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Update details of an existing student in the database.
     *
     * @param array $data An array containing student details.
     * @return string Returns a success message or an error message as a string.
     */
    public function updateStudent($data)
    {
        try {
            // Clean input data
            $student_number = $this->clean_input($data['student_number']);
            $first_name = $this->clean_input($data['first_name']);
            $last_name = $this->clean_input($data['last_name']);
            $age = $this->clean_input($data['age']);
            $gender = $this->clean_input($data['gender']);
            $email = $this->clean_input($data['email']);
            $enrollment_date = $this->clean_input($data['enrollment_date']);

            // Check for empty fields
            if (empty($first_name) || empty($last_name) || empty($age) || empty($gender) || empty($email) || empty($enrollment_date)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Validate email address
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->output = 'Please provide a valid email address!';
                return $this->output;
            }

            // Update student details in the database
            $stmt = $this->conn->prepare(
                "UPDATE students 
                SET first_name = ?, last_name = ?, age = ?, gender = ?, email = ?, enrollment_date = ? 
                WHERE student_number = ?"
            );
            $stmt->execute([$first_name, $last_name, $age, $gender, $email, $enrollment_date, $student_number]);
            // Insert courses student enrolled in
            if (!empty($data['selected_courses'])) {
                $delStmt = $this->conn->prepare("DELETE FROM enrollments WHERE student_number = ?");
                $delStmt->execute([$student_number]);
                foreach ($data['selected_courses'] as $course) {
                    $stmtCourse = $this->conn->prepare(
                        "INSERT INTO enrollments (student_number , course_id)
                    VALUES (?, ?)"
                    );
                    $stmtCourse->execute([$student_number, $course]);
                }
            }
            $this->output = 'success';
            return $this->output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Delete a student from the database.
     *
     * @param mixed $id The student number to delete.
     * @return string Returns a success message or an error message as a string.
     */
    public function deleteStudent($id)
    {
        try {
            // Delete the student
            $stmt = $this->conn->prepare("DELETE FROM students WHERE student_number = ?");
            $stmt->execute([$id]);
            $output = 'success';
            return $output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Search for students based on a search query.
     *
     * @param string $search_query The search query.
     * @return array|string Returns an array of search results and count or an error message as a string.
     */
    public function searchStudents($search_query)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT * FROM students
                WHERE first_name LIKE '%$search_query%'
                OR last_name LIKE '%$search_query%'
                OR student_number LIKE '%$search_query%'
                OR email LIKE '%$search_query%'
                ORDER BY student_number DESC"
            );
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
            return array('data' => $data, 'count' => $count);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }
}
