<?php
require 'dbConnection.php';

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

// Check existing username
$stmt1 = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt1->bind_param("s", $name);
$stmt1->execute();
$result = $stmt1->get_result();
$user = $result->fetch_assoc();

if (empty($name) || empty($email) || empty($password)) {
    echo "<script>alert('All fields are required');</script>";
    echo "<script>window.location='https://localhost/demo/signup.php';</script>";
    die();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format');</script>";
    echo "<script>window.location='https://localhost/demo/signup.php';</script>";
    die();
}

// Password Validation
if (strlen($password) < 6) {
    // Check for minimum length
    echo "<script>alert('Password must be at least 6 characters long');</script>";
    echo "<script>window.location='https://localhost/demo/signup.php';</script>";
    die();
}


// Sanitization
$name = htmlspecialchars($name); // Convert special characters to HTML entities
$email = filter_var($email, FILTER_SANITIZE_EMAIL); // Remove illegal characters from email
$password = htmlspecialchars($password); // Convert special characters to HTML entities


if ($user) {
    echo "<script>alert('Username already exists');</script>";
    echo "<script>window.location='https://localhost/demo/signup.php';</script>";
    die();
}

// Check existing email
$stmt2 = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt2->bind_param("s", $email);
$stmt2->execute();
$result2 = $stmt2->get_result();
$emails = $result2->fetch_assoc();

if ($emails) {
    echo "<script>alert('Email already exists');</script>";
    echo "<script>window.location='https://localhost/demo/signup.php';</script>";
    die();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

$stmt->execute();


// FOR HOME PAGE
$stmt2 = "CREATE TABLE $name (topic VARCHAR(200), about TEXT(100000), code TEXT(100000))";

$conn->query($stmt2);

header("Location: https://localhost/demo/login.php");

?>
