<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signIn'])) {
    // Sanitize and validate input
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        // Redirect back with an error message
        echo "<script>alert('Email and Password are required!'); window.location.href='login.php';</script>";
        exit();
    }

    try {
        // Prepare the SQL query to avoid SQL injection
        $sql = "SELECT firstName, lastName, email, password FROM registered_users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                // Store user details in the session
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['firstName'] . ' ' . $row['lastName']; // Concatenate first and last name

                // Check if the logged-in user is the admin
                if ($row['email'] === 'nextdoor101r@gmail.com') {
                    header("Location: /Real%20Estate/panel/admin/"); // Redirect admin to admin panel
                } else {
                    header("Location: home.php"); // Redirect normal users to home
                }
                exit();
            } else {
                echo "<script>alert('Incorrect Password!'); window.location.href='login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('User Not Found!'); window.location.href='login.php';</script>";
            exit();
        }
    } catch (Exception $e) {
        // Log the error (optional for debugging)
        error_log("Error: " . $e->getMessage());

        // Notify the user
        echo "<script>alert('An error occurred. Please try again later.'); window.location.href='login.php';</script>";
        exit();
    }
} else {
    // Invalid request
    echo "<script>alert('Invalid request!'); window.location.href='login.php';</script>";
    exit();
}
?>
