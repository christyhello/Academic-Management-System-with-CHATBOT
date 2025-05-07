<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("Location: signup.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: signup.php");
        exit();
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare an SQL statement to avoid SQL injection
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);

        // Execute the statement and check if the insertion was successful
        if ($stmt->execute()) {
            $_SESSION['success'] = "User registered successfully!";
            header("Location: index.html"); // Redirect to a different page after signup
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
            header("Location: signup.php");
        }

        $stmt->close();
    }

    $conn->close();
}
?>
