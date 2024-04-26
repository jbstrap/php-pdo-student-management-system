<?php
// Include the parent class definition
include_once 'Db.php';

/**
 * Class Course
 * A class for managing courses in a student management system, extending the DB class for database operations.
 */
class Course extends DB
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
     * Get all courses from the database.
     *
     * @return array|string Returns an array of course details or an error message as a string.
     */
    public function getCourses()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT c.course_id, c.course_number, c.course_name, c.credits,
                        d.department_name
                FROM courses c
                LEFT JOIN departments d
                ON c.department_id = d.department_id
                ORDER BY c.course_id DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Get details of a specific course by its course number.
     *
     * @param array $data An array containing the course ID.
     * @return array|string Returns an array of course details or an error message as a string.
     */
    public function getCourse($data)
    {
        try {
            $id = $data['courseId'];

            $stmt = $this->conn->prepare(
                "SELECT c.course_number, c.course_name, c.credits,
                        d.department_id, d.department_name
                FROM courses c
                LEFT JOIN departments d
                ON c.department_id = d.department_id
                WHERE course_number = ?"
            );
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Add a new course to the database.
     *
     * @param array $data An array containing course details.
     * @return string Returns a success message or an error message as a string.
     */
    public function addCourse($data)
    {
        try {
            // Clean input data
            $course_number = $this->clean_input($data['course_number']);
            $course_name = $this->clean_input($data['course_name']);
            $credits = $this->clean_input($data['credits']);
            $department_id = $this->clean_input($data['department_id']);

            // Check for empty fields
            if (empty($course_number) || empty($course_name) || empty($credits) || empty($department_id)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Check if course already exists
            if ($this->isExist('courses', 'course_number', $course_number)) {
                $this->output = 'The course with number <b>' . $course_number . '</b> already exists!';
                return $this->output;
            }

            // Insert new course into the database
            $stmt = $this->conn->prepare(
                "INSERT INTO courses (course_number, course_name, credits, department_id) 
                VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$course_number, $course_name, $credits, $department_id]);
            $this->output = 'success';
            return $this->output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Update details of an existing course in the database.
     *
     * @param array $data An array containing course details.
     * @return string Returns a success message or an error message as a string.
     */
    public function updateCourse($data)
    {
        try {
            // Clean input data
            $course_number = $this->clean_input($data['course_number']);
            $course_name = $this->clean_input($data['course_name']);
            $credits = $this->clean_input($data['credits']);
            $department_id = $this->clean_input($data['department_id']);

            // Check for empty fields
            if (empty($course_number) || empty($course_name) || empty($credits) || empty($department_id)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Update course details in the database
            $stmt = $this->conn->prepare(
                "UPDATE courses 
                SET course_name = ?, credits = ?, department_id = ?
                WHERE course_number = ?"
            );
            $stmt->execute([$course_name, $credits, $department_id, $course_number]);
            $this->output = 'success';
            return $this->output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Delete a course from the database.
     *
     * @param mixed $id The course number to delete.
     * @return string Returns a success message or an error message as a string.
     */
    public function deleteCourse($id)
    {
        try {
            // Delete course from the database
            $stmt = $this->conn->prepare("DELETE FROM courses WHERE course_number = ?");
            $stmt->execute([$id]);
            $output = 'success';
            return $output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }
}
