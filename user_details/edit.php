<?php

// Include database file
include 'users.php';
$usersObj = new Users();
// edit data
if (isset($_GET['editId']) && !empty($_GET['editId'])) {
    $editId = $_GET['editId'];
    $user = $usersObj->displyaRecordById($editId);
}
// Update data
if (isset($_POST['update'])) {
    $usersObj->updateRecord($_POST);
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
    <div class="card text-center" style="padding:15px;">
        <h4>User Management</h4>
    </div><br>
    <div class="container">
        <form action="edit.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="uname" value="<?php echo $user['name']; ?>" required="">
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="uemail" value="<?php echo $user['email']; ?>" required="">
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="upname" value="<?php echo $user['username']; ?>" required="">
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Update">
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>