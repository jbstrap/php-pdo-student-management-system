<?php
// Start a PHP session
session_start();

/**
 * Class DB
 * A class to handle database connection and common database operations.
 */
class DB
{
    // Database connection parameters
    private $hostName = 'localhost'; // Hostname of the database server
    private $dbUser = 'root'; // Database username
    private $dbPass = ''; // Database password
    private $dbName = 'student_management_system'; // Name of the database
    private $options = []; // Additional options for PDO connection
    protected $conn; // PDO connection object

    /**
     * Constructor method.
     * Establishes a database connection using PDO.
     */
    public function __construct()
    {
        // Check if connection is not already established
        if (!isset($this->conn)) {
            try {
                // Attempt to establish a PDO connection
                $this->conn = new PDO("mysql:host=" . $this->hostName . "; dbname=" . $this->dbName, $this->dbUser, $this->dbPass, $this->options);
            } catch (PDOException $e) {
                // If connection fails, terminate script and display error message
                die($e->getMessage());
            }
        }
        // Return the PDO connection object
        return $this->conn;
    }

    /**
     * Check if a record exists in a table based on a given parameter.
     *
     * @param string $table The name of the table to search in.
     * @param string $param The column name to search for.
     * @param mixed $placeholder The value to search for.
     * @return bool Returns TRUE if a record exists, FALSE otherwise.
     */
    protected function isExist($table, $param, $placeholder)
    {
        // Prepare SQL query to select records from the table where the specified parameter matches the placeholder
        $query = "SELECT * FROM `" . $table . "` WHERE `" . $param . "` = ?";
        try {
            // Prepare and execute the query with the placeholder value
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$placeholder]);
            // If there are rows returned, the record exists, so return TRUE
            if ($stmt->rowCount() > 0) {
                return TRUE;
            }
            // If no rows are returned, the record doesn't exist, so return FALSE
            return FALSE;
        } catch (PDOException $e) {
            // If an error occurs during query execution, terminate script and display error message
            die($e->getMessage());
        }
    }

    /**
     * Sanitize input data to prevent SQL injection and XSS attacks.
     *
     * @param string $data The input data to be sanitized.
     * @return string The sanitized input data.
     */
    protected function clean_input($data)
    {
        // Strip HTML and PHP tags from the input data
        $data = strip_tags($data);
        // Convert special characters to HTML entities to prevent XSS attacks
        $data = htmlspecialchars($data);
        // Remove backslashes from the input data to prevent SQL injection
        $data = stripslashes($data);
        // Remove leading and trailing whitespace from the input data
        $data = trim($data);
        // Return the sanitized input data
        return $data;
    }
}
