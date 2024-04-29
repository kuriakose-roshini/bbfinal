<?php
session_start(); // Start the session

$servername = "127.0.0.1";
$port = "3307"; // Port number for XAMPP MySQL
$username = "root";
$password = "";
$database = "bookbuddy";

// Create connection
$conn = new mysqli($servername . ":" . $port, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

// Perform server-side validation
$errors = array();

// Validate first name
if (empty($firstName)) {
    $errors[] = "First name is required";
}

// Validate last name
if (empty($lastName)) {
    $errors[] = "Last name is required";
}

// Validate email
if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Validate date of birth
if (empty($dob)) {
    $errors[] = "Date of birth is required";
}

// Validate password
if (empty($password)) {
    $errors[] = "Password is required";
} elseif (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters long";
}

// Validate confirm password
if (empty($confirmPassword)) {
    $errors[] = "Confirm password is required";
} elseif ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match";
}

// If there are no validation errors, proceed to store data or perform further actions
if (empty($errors)) {
    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the user table
    $sql = "INSERT INTO users (first_name, last_name, email, dob, password) 
            VALUES ('$firstName', '$lastName', '$email', '$dob', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['signup_success'] = true; // Set session variable for signup success
        header("Location: login.html"); // Redirect to login page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // If there are validation errors, display them to the user
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}

// Close connection
$conn->close();
?>
