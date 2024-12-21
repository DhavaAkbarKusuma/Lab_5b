<?php
include 'Database.php';
include 'User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$result = $user->getUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Users</title>
</head>

<body>
    <h1>Users List</h1>
    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["matric"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["role"]; ?></td>
                    <td>
                    <a href="register_form.php?matric=<?php echo $row["matric"]; ?>">Update</a>
                        <a href="delete.php?matric=<?php echo $row["matric"]; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        $db->close();
        ?>
    </table>
</body>

</html>
