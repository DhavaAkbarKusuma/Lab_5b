<?php
include 'Database.php';
include 'User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$matric = '';
$name = '';
$role = '';
$isUpdate = false;

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $isUpdate = true;

    $userDetails = $user->getUser($matric);
    if ($userDetails) {
        $name = $userDetails['name'];
        $role = $userDetails['role'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    if ($isUpdate) {

        if ($user->updateUser($matric, $name, $role)) {
            header("Location: read.php");
            exit();
        } else {
            $error = "Failed to update user!";
        }
    } else {

        $password = $_POST['password'];
        if ($user->createUser($matric, $name, $password, $role)) {
            header("Location: read.php");
            exit();
        } else {
            $error = "Failed to register user!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isUpdate ? 'Update User' : 'Register User'; ?></title>
</head>

<body>
    <h1><?php echo $isUpdate ? 'Update User' : 'Register User'; ?></h1>
    <form action="register_form.php<?php echo $isUpdate ? '?matric=' . $matric : ''; ?>" method="post">
        <input type="hidden" name="matric" value="<?php echo $matric; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="">Please select</option>
            <option value="lecturer" <?php if ($role == 'lecturer') echo "selected"; ?>>Lecturer</option>
            <option value="student" <?php if ($role == 'student') echo "selected"; ?>>Student</option>
        </select><br>

        <?php if (!$isUpdate) { ?>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
        <?php } ?>

        <button type="submit"><?php echo $isUpdate ? 'Update' : 'Register'; ?></button>
    </form>
    <p><?php echo isset($error) ? $error : ''; ?></p>
</body>

</html>
