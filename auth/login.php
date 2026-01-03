<?php
include '../config/connection.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
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
            'message' => 'Invalid email format'
        ];

        header('Location: ../index.php');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);


    // password verification and globally storing id
    if (mysqli_num_rows($result) === 1 && password_verify($password, $user['password'])) {

        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role']; 
        $_SESSION['name'] = $user['username'];


        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'login successfull'
        ];

        header('Location: ../' . $user['role'] . '/dashboard.php');
        exit();

    } else {
        $_SESSION['toast'] = [
            'type' => 'fail',
            'message' => 'invalid credentials'
        ];

        header("Location: ../index.php");
    }
} else {
    die('Invalid request method.');
}
