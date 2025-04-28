<?php
require 'connect.php';
session_start();

if (!isset($_GET['token'])) {
    header('Location: login.php');
    exit();
}

$token = $_GET['token'];
$currentTime = date('Y-m-d H:i:s');

// Verify token and check if it's not expired
$sql = "SELECT * FROM registered_users WHERE reset_token = ? AND reset_token_expiry > ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $token, $currentTime);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Invalid or expired reset link.'); window.location.href='login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password and clear reset token
        $updateSql = "UPDATE registered_users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $hashedPassword, $token);
        
        if ($updateStmt->execute()) {
            echo "<script>alert('Password has been reset successfully!'); window.location.href='login.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error resetting password. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #ffece0);
        }

        .container {
            background: #fff;
            width: 450px;
            padding: 1.5rem;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 1, 0.5);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 1.3rem;
            margin-bottom: 0.4rem;
        }

        form {
            margin: 0 2rem;
        }

        .input-group {
            padding: 1% 0;
            position: relative;
        }

        .input-group i {
            position: absolute;
            color: black;
        }

        input {
            color: inherit;
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #757575;
            padding-left: 1.5rem;
            font-size: 15px;
        }

        input:focus {
            background-color: transparent;
            outline: transparent;
            border-bottom: 2px solid hsl(327, 90%, 28%);
        }

        input::placeholder {
            color: transparent;
        }

        label {
            color: #757575;
            position: relative;
            left: 1.2em;
            top: -1.3em;
            cursor: auto;
            transition: 0.3s ease all;
        }

        input:focus~label,
        input:not(:placeholder-shown)~label {
            top: -3em;
            color: hsl(327, 90%, 28%);
            font-size: 15px;
        }

        .btn {
            font-size: 1.1rem;
            padding: 8px 0;
            border-radius: 5px;
            outline: none;
            border: none;
            width: 100%;
            background: #e67e22;
            color: white;
            cursor: pointer;
            transition: 0.9s;
            margin-top: 1rem;
        }

        .btn:hover {
            background: orange;
        }

        #passwordError {
            color: red;
            font-size: 0.9rem;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="form-title">Reset Password</h1>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="New Password" required>
                <label for="password">New Password</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <label for="confirm_password">Confirm Password</label>
            </div>
            <p id="passwordError">Passwords don't match</p>
            <input type="submit" class="btn" value="Reset Password">
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            const errorText = document.getElementById('passwordError');

            function validatePassword() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    errorText.style.display = 'block';
                } else {
                    errorText.style.display = 'none';
                }
            }

            confirmPasswordInput.addEventListener('input', validatePassword);
            confirmPasswordInput.addEventListener('blur', validatePassword);
            confirmPasswordInput.addEventListener('focus', function() {
                errorText.style.display = 'none';
            });
        });
    </script>
</body>
</html>