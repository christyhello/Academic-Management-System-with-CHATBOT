<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent SQL Injection
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Query to find the user
    $sql = "SELECT password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            echo "<script>alert('Logged in successfully!'); window.location.href='index_1.html';</script>"; // Redirect to index after successful login
        } else {
            echo "<script>alert('Invalid password!'); window.location.href='login.php';</script>"; // Redirect back to login on failure
        }
    } else {
        echo "<script>alert('No user found with this email!'); window.location.href='login.php';</script>"; // Redirect back to login if no user
    }

    $conn->close();
}
?>
