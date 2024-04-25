<?php
// Include the parent class definition
include_once 'Db.php';

/**
 * Class Department
 * A class for managing departments in a student management system, extending the DB class for database operations.
 */
class Department extends DB
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
     * Get all departments from the database.
     *
     * @return array|string Returns an array of department details or an error message as a string.
     */
    public function getDepartments()
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT d.department_id, d.department_name, d.salary, d.start_date,
                        i.first_name, i.last_name
                FROM departments d
                JOIN instructors i
                ON d.instructor_id = i.instructor_id
                ORDER BY department_id DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Get details of a specific department by its department ID.
     *
     * @param array $data An array containing the department ID.
     * @return array|string Returns an array of department details or an error message as a string.
     */
    public function getDepartment($data)
    {
        try {
            $id = $data['departmentId'];

            $stmt = $this->conn->prepare(
                "SELECT d.department_id, d.department_name, d.salary, d.start_date, d.instructor_id,
                        i.first_name, i.last_name
                FROM departments d
                JOIN instructors i
                ON d.instructor_id = i.instructor_id
                WHERE d.department_id = ?"
            );
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Add a new department to the database.
     *
     * @param array $data An array containing department details.
     * @return string Returns a success message or an error message as a string.
     */
    public function addDepartment($data)
    {
        try {
            // Clean input data
            $department_name = $this->clean_input($data['department_name']);
            $salary = $this->clean_input($data['salary']);
            $start_date = $this->clean_input($data['start_date']);
            $instructor_id = $this->clean_input($data['instructor_id']);

            // Check for empty fields
            if (empty($department_name) || empty($salary) || empty($start_date) || empty($instructor_id)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Check if department already exists
            if ($this->isExist('departments', 'department_name', $department_name)) {
                $this->output = 'The department <b>' . $department_name . '</b> already exists!';
                return $this->output;
            }

            // Insert new department into the database
            $stmt = $this->conn->prepare(
                "INSERT INTO departments (department_name, salary, start_date, instructor_id) 
                VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$department_name, $salary, $start_date, $instructor_id]);
            $this->output = 'success';
            return $this->output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Update details of an existing department in the database.
     *
     * @param array $data An array containing department details.
     * @return string Returns a success message or an error message as a string.
     */
    public function updateDepartment($data)
    {
        try {
            // Clean input data
            $department_id = $this->clean_input($data['departmentId']);
            $department_name = $this->clean_input($data['department_name']);
            $salary = $this->clean_input($data['salary']);
            $start_date = $this->clean_input($data['start_date']);
            $instructor_id = $this->clean_input($data['instructor_id']);

            // Check for empty fields
            if (empty($department_name) || empty($salary) || empty($start_date) || empty($instructor_id)) {
                $this->output = 'Oops! Fields cannot be empty!';
                return $this->output;
            }

            // Check if department name already exists
            $existingDepartment = $this->getDepartment($data);
            if (($existingDepartment['department_name'] != $department_name)
                && $this->isExist('departments', 'department_name', $department_name)
            ) {
                $this->output = 'The department <b>' . $department_name . '</b> already exists!';
                return $this->output;
            }

            // Update department details in the database
            $stmt = $this->conn->prepare(
                "UPDATE departments 
                SET department_name = ?, salary = ?, start_date = ?, instructor_id = ? 
                WHERE department_id = ?"
            );
            $stmt->execute([$department_name, $salary, $start_date, $instructor_id, $department_id]);
            $this->output = 'success';
            return $this->output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    /**
     * Delete a department from the database.
     *
     * @param mixed $id The department ID to delete.
     * @return string Returns a success message or an error message as a string.
     */
    public function deleteDepartment($id)
    {
        try {
            // Delete department from the database
            $stmt = $this->conn->prepare("DELETE FROM departments WHERE department_id = ?");
            $stmt->execute([$id]);
            $output = 'success';
            return $output;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }
}
