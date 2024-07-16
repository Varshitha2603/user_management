<style>
    li {
        list-style: none;
    }
</style>

<?php
include "db.php";
if (isset($_POST['search'])) {
    $Name = mysqli_real_escape_string($con, $_POST['search']);
    $query = "SELECT * FROM user_details WHERE name LIKE '%$Name%' OR email LIKE '%$Name%' OR username LIKE '%$Name%'LIMIT 4";
    $executeQuery = mysqli_query($con, $query);
    if ($executeQuery->num_rows > 0) {
        echo '<ul>';
        while ($result = mysqli_fetch_assoc($executeQuery)) {
?>
            <li onclick='fill("<?= htmlspecialchars(json_encode($result)) ?>")'>
                <!-- <a>--><? //=htmlspecialchars($result['name'])
                            ?><!--</a>-->
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
                        <tr>
                            <td><?= $result['id'] ?></td>
                            <td><?= $result['name'] ?></td>
                            <td><?= $result['email'] ?></td>
                            <td><?= $result['username'] ?></td>
                            <td>
                                <a href="edit.php?editId=<?php echo htmlspecialchars($result['id']) ?>" style="color:green">
                                    <i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp
                                <a href="index.php?deleteId=<?php echo htmlspecialchars($result['id']) ?>" style="color:red" onclick="confirm('Are you sure want to delete this record')">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </li>
<?php
        }
        echo '</ul>';
    } else {
        echo "Query execution failed: " . mysqli_error($con);
    }
}
