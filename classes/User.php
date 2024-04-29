<?php
// Include the parent class definition
include_once 'Db.php';

/**
 * Class User
 * A class for user login.
 */
class User extends DB
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

    public function isEmail($email)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                return TRUE;
            }
            return FALSE;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    public function isAdmin($email)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['role'] == "Admin") {
                return TRUE;
            }
            return FALSE;
        } catch (PDOException $e) {
            $this->output = $e->getMessage();
            return $this->output;
        }
    }

    public function login($data)
    {
        $email = $data['email'];
        $password = $data['password'];

        if (empty($email) || empty($password)) {
            $this->output = 'Oops! Fields cannot be empty!';
            return $this->output;
        } else if ($this->isEmail($email) == FALSE) {
            $this->output = 'Incorrect email or password!';
            return $this->output;
        }

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if (
            $account && password_verify($_POST['password'], $account['password'])
        ) {
            if ($this->isAdmin($email) == FALSE) {
                $this->output = 'Access denied! You are not an admin.';
                return $this->output;
            }

            session_regenerate_id();
            $_SESSION['isLogged'] = TRUE;
            $_SESSION['username'] = $account['username'];

            $this->output = 'success';
            return $this->output;
        } else {
            $this->output = 'Incorrect email or password!';
            return $this->output;
        }
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['isLogged'])) {
            return TRUE;
        }
        return FALSE;
    }

    public function logout()
    {
        session_destroy();
        // unset($_SESSION['isLogged']);
        header("Location: index.php");
        exit();
    }
}
