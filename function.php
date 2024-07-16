<?php
session_start();

class Connection
{
    private $host = "localhost";
    private $user = "dckap";
    private $password = "Dckap2023Ecommerce";
    private $db_name = "user_management";
    protected $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}

class Register extends Connection
{
    public function registration($name, $username, $email, $password, $confirmpassword)
    {
        // Check for duplicate username or email
        $stmt = $this->conn->prepare("SELECT * FROM tb_user WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return 10; // username or email has already been taken
        } else {
            if ($password === $confirmpassword) {
                // Hash the password before storing it
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $stmt = $this->conn->prepare("INSERT INTO tb_user (name, username, email, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $username, $email, $hashedPassword);

                if ($stmt->execute()) {
                    return 1; // Registration successful
                } else {
                    return 0; // Registration failed due to a database error
                }
            } else {
                return 100; // Passwords do not match
            }
        }
    }
}


class Login extends Connection
{
    public $id;

    public function login($usernameemail, $password)
    {
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare("SELECT * FROM tb_user WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameemail, $usernameemail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Use password_verify to check the hashed password
            if (password_verify($password, $row["password"])) {
                $this->id = $row["id"];
                return 1; // Login successful
            } else {
                return 10; // Wrong password
            }
        } else {
            return 100; // User not registered
        }
    }

    public function idUser()
    {
        return $this->id;
    }
}

class Select extends Connection
{
    public function selectUserById($id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
}
