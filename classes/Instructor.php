<?php
// Include the parent class definition
include_once 'Db.php';

/**
 * Class Instructor
 * A class for managing instructors in a student management system, extending the DB class for database operations.
 */
class Instructor extends DB
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
     * Get all instructors from the database along with the courses they teach.
     *
     * @return array|string Returns an array of instructor details or an error message as a string.
     */
    public function getInstructors()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT i.instructor_id, i.first_name, i.last_name, i.email,
                    GROUP_CONCAT(c.course_name SEPARATOR ', ') AS courses_taught
                FROM instructors i
                LEFT JOIN courses c ON i.instructor_id = c.instructor_id
                GROUP BY i.instructor_id, i.first_name, i.last_name, i.email
                ORDER BY i.instructor_id DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Get all instructors from the database.
     *
     * @return array|string Returns an array of instructor details or an error message as a string.
     */
    public function getAllInstructors()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT instructor_id, first_name, last_name
                FROM instructors
                ORDER BY instructor_id DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Get details of a specific instructor by their ID.
     *
     * @param array $data An array containing the instructor ID.
     * @return array|string Returns an array of instructor details or an error message as a string.
     */
    public function getInstructor($data)
    {
        try {
            $id = $data['instructorId'];

            $stmt = $this->conn->prepare(
                "SELECT i.instructor_id, i.first_name, i.last_name, i.email,
                        c.course_name
                FROM instructors i
                LEFT JOIN courses c
                ON i.instructor_id = c.instructor_id
                WHERE i.instructor_id = ?"
            );
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Get courses taught by a specific instructor.
     *
     * @param array $data An array containing the instructor ID.
     * @return array|string Returns an array of courses taught by the instructor or an error message as a string.
     */
    public function getInstructorCourses($data)
    {
        try {
            $id = $data['instructorId'];

            $stmt = $this->conn->prepare(
                "SELECT c.course_id, c.course_number, c.course_name,
                        d.department_name
                FROM courses c
                LEFT JOIN departments d 
                ON c.department_id = d.department_id
                WHERE c.instructor_id = ?"
            );
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Get students enrolled in a specific course taught by an instructor.
     *
     * @param array $data An array containing the course ID.
     * @return array|string Returns an array of students enrolled in the course or an error message as a string.
     */
    public function getCourseStudents($data)
    {
        try {
            $id = $data['courseId'];

            $stmt = $this->conn->prepare(
                "SELECT s.student_number, s.first_name,
                        e.enrollment_id,
                        g.grade
                FROM students s
                LEFT JOIN enrollments e
                ON s.student_number = e.student_number
                LEFT JOIN grades g
                ON e.enrollment_id = g.enrollment_id
                WHERE e.course_id = ?"
            );
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Add a new instructor to the database.
     *
     * @param array $data An array containing instructor details.
     * @return string Returns a success message or an error message as a string.
     */
    public function addInstructor($data)
    {
        try {
            // Clean input data
            $first_name = $this->clean_input($data['first_name']);
            $last_name = $this->clean_input($data['last_name']);
            $email = $this->clean_input($data['email']);

            // Check for empty fields
            if (empty($first_name) || empty($last_name) || empty($email)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Validate email address
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->output = 'Please provide a valid email address!';
                return $this->output;
            }

            // Insert new instructor into the database
            $stmt = $this->conn->prepare(
                "INSERT INTO instructors (first_name, last_name, email) 
                VALUES (?, ?, ?)"
            );
            $stmt->execute([$first_name, $last_name, $email]);
            $instructor_id = $this->conn->lastInsertId();

            if (!empty($data['selected_courses'])) {
                // Update courses taught by the instructor
                foreach ($data['selected_courses'] as $course) {
                    $stmtCourse = $this->conn->prepare("UPDATE courses SET instructor_id = ? WHERE course_number = ?");
                    $stmtCourse->execute([$instructor_id, $course]);
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
     * Update details of an existing instructor in the database.
     *
     * @param array $data An array containing instructor details.
     * @return string Returns a success message or an error message as a string.
     */
    public function updateInstructor($data)
    {
        try {
            // Clean input data
            $first_name = $this->clean_input($data['first_name']);
            $last_name = $this->clean_input($data['last_name']);
            $email = $this->clean_input($data['email']);
            $instructor_id = $data['instructor_id'];

            // Check for empty fields
            if (empty($first_name) || empty($last_name) || empty($email)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Validate email address
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->output = 'Please provide a valid email address!';
                return $this->output;
            }

            // Update instructor details in the database
            $stmt = $this->conn->prepare(
                "UPDATE instructors 
                SET first_name = ?, last_name = ?, email = ?
                WHERE instructor_id = ?"
            );
            $stmt->execute([$first_name, $last_name, $email, $instructor_id]);

            // Update courses taught by the instructor
            if (!empty($data['selected_courses'])) {
                $delStmt = $this->conn->prepare("UPDATE courses SET instructor_id = NULL WHERE instructor_id = ?");
                $delStmt->execute([$instructor_id]);
                foreach ($data['selected_courses'] as $course) {
                    $stmtCourse = $this->conn->prepare("UPDATE courses SET instructor_id = ? WHERE course_number = ?");
                    $stmtCourse->execute([$instructor_id, $course]);
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
     * Delete an instructor from the database.
     *
     * @param mixed $id The instructor ID to delete.
     * @return string Returns a success message or an error message as a string.
     */
    public function deleteInstructor($id)
    {
        try {
            // Check if any courses reference the instructor
            $checkStmt = $this->conn->prepare("SELECT COUNT(*) FROM courses WHERE instructor_id = ?");
            $checkStmt->execute([$id]);
            $rowCount = $checkStmt->fetchColumn();

            // If there are related courses, remove the references
            if ($rowCount > 0) {
                $removeStmt = $this->conn->prepare("UPDATE courses SET instructor_id = NULL WHERE instructor_id = ?");
                $removeStmt->execute([$id]);
            }

            // Now delete the instructor
            $deleteStmt = $this->conn->prepare("DELETE FROM instructors WHERE instructor_id = ?");
            $deleteStmt->execute([$id]);

            $this->output = 'success';
            return $this->output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }
}
