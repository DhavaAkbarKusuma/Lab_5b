<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include 'Database.php';
    include 'User.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $matric = $_GET['matric'];

    if ($user->deleteUser($matric)) {
        header("Location: read.php");
        exit();
    } else {
        echo "Delete failed!";
    }

    $db->close();
}
?>
