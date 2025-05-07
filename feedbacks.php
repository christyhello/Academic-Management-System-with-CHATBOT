<?php
session_start();
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert feedback into the feedbacks table
    $sql = "INSERT INTO feedbacks (name, surname, email, message) 
            VALUES ('$name', '$surname', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Feedback added successfully!";
        header("Location: index_1.html");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
        header("Location: index_1.html");
        exit();
    }
}

// Close connection
$conn->close();
?>

