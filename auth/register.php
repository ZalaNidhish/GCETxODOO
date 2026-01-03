<?php
include '../config/connection.php';

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeID = $_POST['employeeID'];
    $username = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    $department = $_POST['department'];
    $position = $_POST['position'];

    // Basic validation
    if (empty($employeeID) || empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirm_password) || empty($department) || empty($position)) {
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
    $sql = "INSERT INTO users (employee_id, fullname, email, password, contact, department, position) VALUES ('$employeeID', '$username', '$email', '$hashed_password', '$contact', '$department', '$postition' )";
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
