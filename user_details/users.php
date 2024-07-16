<?php
class Users
{
    private $servername = "localhost";
    private $username   = "dckap";
    private $password   = "Dckap2023Ecommerce";
    private $database   = "user_management";
    public  $con;
    // Database Connection
    public function __construct()
    {
        $this->con = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if (mysqli_connect_error()) {
            trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
        } else {
            return $this->con;
        }
    }

    // Insert the data
    public function insertData($post)
    {
        $name = $this->con->real_escape_string($_POST['name']);
        $email = $this->con->real_escape_string($_POST['email']);
        $username = $this->con->real_escape_string($_POST['username']);
        $password = $this->con->real_escape_string(md5($_POST['password']));
        $query = "INSERT INTO user_details (name,email,username,password) VALUES('$name','$email','$username','$password')";
        $sql = $this->con->query($query);
        if ($sql == true) {
            header("Location:index.php?msg1=insert");
        } else {
            echo "Registration failed try again!";
        }
    }
    // display the data
    //        public function displayData()
    //        {
    //            $query = "SELECT * FROM user_details";
    //            $result = $this->con->query($query);
    //            if ($result->num_rows > 0) {
    //                $data = array();
    //                while ($row = $result->fetch_assoc()) {
    //                    $data[] = $row;
    //                }
    //                return $data;
    //            }else{
    //                echo "No found records";
    //            }
    //        }



    // display the data with pagination
    public function displayData($limit = 100, $offset = 0)
    {
        $query = "SELECT * FROM user_details LIMIT ?, ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return array(); // return an empty array if no records found
        }
    }


    // display the single data
    public function displyaRecordById($id)
    {
        $query = "SELECT * FROM user_details WHERE id = '$id'";
        $result = $this->con->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            echo "Record not found";
        }
    }
    // update the data
    public function updateRecord($postData)
    {
        $name = $this->con->real_escape_string($_POST['uname']);
        $email = $this->con->real_escape_string($_POST['uemail']);
        $username = $this->con->real_escape_string($_POST['upname']);
        $id = $this->con->real_escape_string($_POST['id']);
        if (!empty($id) && !empty($postData)) {
            $query = "UPDATE user_details SET name = '$name', email = '$email', username = '$username' WHERE id = '$id'";
            $sql = $this->con->query($query);
            if ($sql == true) {
                header("Location:index.php?msg2=update");
            } else {
                echo "Registration updated failed try again!";
            }
        }
    }
    // Delete the data
    public function deleteRecord($id)
    {
        $query = "DELETE FROM user_details WHERE id = '$id'";
        $sql = $this->con->query($query);
        if ($sql == true) {
            header("Location:index.php?msg3=delete");
        } else {
            echo "Record does not delete try again";
        }
    }
}
