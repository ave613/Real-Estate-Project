<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);

require 'connect.php';
require 'C:/xampp/htdocs/Real Estate/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Validate email
    if (empty($email)) {
        echo "<script>alert('Email is required!'); window.location.href='forgot_password.php';</script>";
        exit();
    }

    // Check if email exists in database
    $sql = "SELECT * FROM registered_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store token in database
        $updateSql = "UPDATE registered_users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sss", $token, $expiry, $email);
        $updateStmt->execute();

        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // SMTP Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nextdoor101r@gmail.com'; // Your Gmail
            $mail->Password = 'qdut gjur yflc wqjb'; // Your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Enable debugging and log output to a file
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = function ($str, $level) {
                file_put_contents('mail_debug_log.txt', $str . PHP_EOL, FILE_APPEND);
            };

            // Recipients
            $mail->setFrom('nextdoor101r@gmail.com', 'Real Estate');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/Real%20Estate/MainPage/reset_password.php?token=" . $token;
            $mail->Body = "Click the following link to reset your password: <br><a href='$resetLink'>Reset Password</a><br>This link will expire in 1 hour.";

            $mail->send();
            echo "<script>alert('Password reset link has been sent to your email.'); window.location.href='login.php';</script>";
        } catch (Exception $e) {
            // Log the error to a file
            error_log("Mailer Error: " . $mail->ErrorInfo);

            // Show error message and prevent instant redirect
            echo "<script>
                    alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
                    console.log('Mailer Error:', '{$mail->ErrorInfo}');
                    setTimeout(function() {
                        window.location.href='forgot_password.php';
                    }, 5000); // Wait 5 seconds before redirecting
                  </script>";
        }
    } else {
        echo "<script>alert('Email not found!'); window.location.href='forgot_password.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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

        .back-to-login {
            text-align: center;
            margin-top: 1rem;
        }

        .back-to-login a {
            color: #3498DB;
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="form-title">Forgot Password</h1>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <input type="submit" class="btn" value="Reset Password">
        </form>
        <div class="back-to-login">
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</body>

</html>