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
    header("Location: user_add.php?error=fields");
    exit();
}

if (strlen($password) < 8) {
    header("Location: user_add.php?error=failed");
    exit();
}

if ($password !== $confirmPassword) {
    header("Location: user_add.php?error=mismatch");
    exit();
}

$checkQuery = "SELECT id FROM users WHERE username = $1";
$checkResult = pg_query_params($connection, $checkQuery, [$username]);

if (pg_num_rows($checkResult) > 0) {
    header("Location: user_add.php?error=exists");
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
    header("Location: dashboard.php");
    exit();
}

header("Location: user_add.php?error=failed");
exit();