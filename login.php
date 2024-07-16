<?php
require_once "function.php";
session_start();
if (isset($_SESSION["id"])) {
    header("Location: index.php");
}

$login = new Login();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $usernameemail = htmlspecialchars(trim($_POST['usernameemail']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!empty($usernameemail) && !empty($password)) {
        $result = $login->login($usernameemail, $password);

        if ($result == 1) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $login->idUser();
            header("Location: index.php");
            exit();
        } elseif ($result == 10) {
            echo "<script>alert('Wrong password');</script>";
        } elseif ($result == 100) {
            echo "<script>alert('User not registered');</script>";
        } else {
            echo "<script>alert('An unknown error occurred');</script>";
        }
    } else {
        echo "<script>alert('All fields are required');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>

<body>
    <div>
        <h2>Login</h2>
        <form method="post" autocomplete="off" class="col g-4">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label class="col-form-label">Username or Email: </label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" aria-describedby="passwordHelpInline" name="usernameemail" required value="">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label class="col-form-label">Password: </label>
                </div>
                <div class="col-auto">
                    <input type="password" class="form-control" aria-describedby="passwordHelpInline" name="password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-sm">Login</button>

        </form>
        <br><br>
        <a href="registration.php">Registration</a>
    </div>
</body>

</html>