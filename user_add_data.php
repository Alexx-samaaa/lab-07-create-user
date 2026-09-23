<?php
include 'initialize.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: user_add.php");
    exit();
}

$firstname = trim($_POST['firstname'] ?? '');
$lastname = trim($_POST['lastname'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if (
    $firstname === '' ||
    $lastname === '' ||
    $username === '' ||
    $password === '' ||
    $confirmPassword === ''
) {
    $_SESSION['alert_type'] = "error";
    $_SESSION['alert_message'] = "Please complete all fields.";

    header("Location: user_add.php");
    exit();
}

if ($password !== $confirmPassword) {
    $_SESSION['alert_type'] = "error";
    $_SESSION['alert_message'] = "Passwords do not match.";

    header("Location: user_add.php");
    exit();
}

$checkQuery = "SELECT id FROM users WHERE username = $1";
$checkResult = pg_query_params($connection, $checkQuery, [$username]);

if (pg_num_rows($checkResult) > 0) {
    $_SESSION['alert_type'] = "error";
    $_SESSION['alert_message'] = "Username already exists.";

    header("Location: user_add.php");
    exit();
}

$query = "INSERT INTO users (firstname, lastname, username, password)
          VALUES ($1, $2, $3, $4)";

$result = pg_query_params(
    $connection,
    $query,
    [$firstname, $lastname, $username, $password]
);

if ($result) {
    $_SESSION['alert_type'] = "success";
    $_SESSION['alert_message'] = "User has been successfully created.";

    header("Location: dashboard.php");
    exit();
}

$_SESSION['alert_type'] = "error";
$_SESSION['alert_message'] = "Failed to create user.";

header("Location: user_add.php");
exit();
?>
