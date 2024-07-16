<?php

// Include database file
include 'users.php';
$usersObj = new Users();
// Delete record from table
if (isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];
    $usersObj->deleteRecord($deleteId);
}

//// Pagination configuration
//$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
//$records_per_page = 10; // Number of records per page
//$offset = ($page - 1) * $records_per_page; // Calculate offset
//
//// Fetch data for current page
//$users = $usersObj->displayData($records_per_page, $offset);



// Pagination configuration
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

$users = $usersObj->displayData($records_per_page, $offset, $search);




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
    </div><br><br>
    <div class="container">
        <?php
        if (isset($_GET['msg1']) == "insert") {
            echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Your User added successfully
            </div>";
        }
        if (isset($_GET['msg2']) == "update") {
            echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Your User updated successfully
            </div>";
        }
        if (isset($_GET['msg3']) == "delete") {
            echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              User deleted successfully
            </div>";
        }
        ?>
        <h2>View Records
            <a href="add.php" class="btn btn-primary" style="float:right;">Add New Record</a>
        </h2>

        <!--search-->

        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." id="search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="btnSearch">Search</button>
                </div>
            </div>
            <div id="display"></div> <!-- This div will display search results -->
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = $usersObj->displayData();
                foreach ($users as $user) {
                ?>
                    <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo $user['name'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['username'] ?></td>
                        <td>
                            <a href="edit.php?editId=<?php echo $user['id'] ?>" style="color:green">
                                <i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp
                            <a href="index.php?deleteId=<?php echo $user['id'] ?>" style="color:red" onclick="confirm('Are you sure want to delete this record')">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        // Pagination links
        $total_rows = count($usersObj->displayData()); // Count total records
        $total_pages = ceil($total_rows / $records_per_page); // Calculate total pages

        // Display pagination links
        ?>
        <ul class="pagination">
            <?php
            // Previous page link
            if ($page > 0) {
                echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page - 1) . "'>Previous</a></li>";
            }

            // Numbered pages
            for ($i = 0; $i <= $total_pages; $i++) {
                echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
            }

            // Next page link
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page + 1) . "'>Next</a></li>";
            }
            ?>
        </ul>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#search").keyup(function() {
                var name = $(this).val().trim(); // Get the value of the search input

                if (name !== '') {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php", // The PHP script that handles the AJAX request
                        data: {
                            search: name // Send the search term to the server
                        },
                        success: function(response) {
                            $("#display").html(response); // Display the results in the display div
                        }
                    });
                } else {
                    $("#display").html(""); // Clear the display if the search input is empty
                }
            });

            $("#btnSearch").click(function(e) {
                e.preventDefault(); // Prevent form submission
                var name = $("#search").val().trim(); // Get the search input value

                if (name !== '') {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            search: name
                        },
                        success: function(response) {
                            $("#display").html(response); // Display results in the display div
                        }
                    });
                } else {
                    $("#display").html(""); // Clear the display if the search input is empty
                }
            });
        });
    </script>
</body>

</html>