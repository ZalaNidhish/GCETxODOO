<?php
include '../config/connection.php';

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
          $_SESSION['toast'] = [
            'type' => 'fail',
            'message' => 'Invalid data'
        ];

        header('Location: ../index.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

          $_SESSION['toast'] = [
            'type' => 'fail',
            'message' => 'Enter valid email'
        ];

        header('Location: ../index.php');
        exit();
    }

    if ($password !== $confirm_password) {
          $_SESSION['toast'] = [
            'type' => 'fail',
            'message' => 'password mismatch'
        ];

        header('Location: ../index.php');
        exit();
    }

    // Check if email already exists
    $sql = "SELECT id FROM users WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $_SESSION['toast'] = [
            'type' => 'fail',
            'message' => 'user already exists!'
        ];

        header('Location: ../index.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    if (mysqli_query($conn, $sql)) {

        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Registration successful!'
        ];

        header('Location: ../index.php');
        exit();
    } else {
        die('Error: ' . mysqli_error($conn));
    }
} else {
    die('Invalid request method.');
}
