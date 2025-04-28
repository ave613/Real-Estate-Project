<?php 
include 'connect.php';

session_start(); // Start session

// Sign Up Logic
if (isset($_POST['signUp'])) {
    $firstName = trim($_POST['fName']);
    $lastName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);

    // Input validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = "SELECT * FROM registered_users WHERE email=?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Insert user into database
        $insertQuery = "INSERT INTO registered_users (firstName, lastName, email, phone,password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Sign In Logic
if (isset($_POST['signIn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Input validation
    if (empty($email) || empty($password)) {
        echo "Email and Password are required!";
        exit();
    }
    //Phone validation
    if (!preg_match('/^09\d{7,9}$/', $phone)) {
        echo "Invalid phone number format!";
        exit();
    }
    
    // Check user credentials
    $sql = "SELECT * FROM registered_users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Valid credentials, set session
            $_SESSION['email'] = $row['email'];
            $_SESSION['firstName'] = $row['firstName'];
            header("Location: home.php");
            exit();
        } else {
            echo "Incorrect Password!";
        }
    } else {
        echo "User Not Found!";
    }
}
?>
