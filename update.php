<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'Database.php';
    include 'User.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    if ($user->updateUser($matric, $name, $role)) {
        header("Location: read.php");
        exit();
    } else {
        echo "Update failed!";
    }

    $db->close();
}
?>
