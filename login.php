<?php
session_start();
include 'Database.php';
include 'User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];


    $userData = $user->getUser($matric);

    if ($userData && password_verify($password, $userData['password'])) {
        // Set session
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $userData['name'];
        $_SESSION['matric'] = $userData['matric'];

        header("Location: read.php");
        exit();
    } else {
        $error = "Invalid Matric or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login Page</h1>
    <form method="POST">
        <label for="matric">Matric:</label>
        <input type="text" name="matric" id="matric" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Login</button>
        <p><?php echo isset($error) ? $error : ''; ?></p>
    </form>
    <a href="registration.php">Register here</a>
</body>

</html>
