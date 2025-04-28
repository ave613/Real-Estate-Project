<?php
include 'connect.php';

if (isset($_POST['password'])) {
    $password = $_POST['password'];

    // Fetch admin's hashed password
    $sql = "SELECT password FROM registered_users WHERE email = 'nextdoor101r@gmail.com'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $admin['password'])) {
        echo "valid";
    } else {
        echo "invalid";
    }
}
?>
