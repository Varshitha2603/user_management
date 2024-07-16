<?php
require_once "function.php";
if (isset($_SESSION["id"])) {
    header("Location: index.php");
}

$register = new Register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = htmlspecialchars(trim($_POST["name"]));
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $confirmpassword = htmlspecialchars(trim($_POST["confirmpassword"]));

    if (!empty($name) && !empty($username) && !empty($email) && !empty($password) && !empty($confirmpassword)) {
        $result = $register->registration($name, $username, $email, $password, $confirmpassword);

        if ($result == 1) {
            echo "<script>alert('Registration successfully');</script>";
            header("Location: login.php");
        } elseif ($result == 10) {
            echo "<script>alert('Email has already been taken');</script>";
        } elseif ($result == 100) {
            echo "<script>alert('Passwords do not match');</script>";
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
    <h1>Registration Form</h1>
    <form method="post" action="" autocomplete="off" class="col g-4">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label" for="name">Name:</label>
            </div>
            <div class="col-auto">
                <input class="form-control" aria-describedby="passwordHelpInline" type="text" id="name" name="name" required><br>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label" for="username">Username:</label>
            </div>
            <div class="col-auto">
                <input class="form-control" aria-describedby="passwordHelpInline" type="text" id="username" name="username" required><br>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label" for="email">Email:</label>
            </div>
            <div class="col-auto">
                <input class="form-control" aria-describedby="passwordHelpInline" type="email" id="email" name="email" required><br>
            </div>
        </div>


        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label" for="password">Password:</label>
            </div>
            <div class="col-auto">
                <input class="form-control" aria-describedby="passwordHelpInline" type="password" id="password" name="password" required><br>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label" for="confirmpassword">Confirm Password:</label>
            </div>
            <div class="col-auto">
                <input class="form-control" aria-describedby="passwordHelpInline" type="password" id="confirmpassword" name="confirmpassword" required><br>
            </div>
        </div>

        <input type="submit" name="submit" value="Register">
    </form>
    <br><br>
    <a href="login.php">Login</a>
</body>

</html>