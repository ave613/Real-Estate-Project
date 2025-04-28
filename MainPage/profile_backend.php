<?php
session_start();
include("connect.php"); // Ensure this file has a valid database connection

if (!isset($_SESSION['email'])) {
    header("Location: MainPage/login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM registered_users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Update profile details
if (isset($_POST['update_profile'])) {
    $first_name = trim($_POST['firstname']);
    $last_name = trim($_POST['lastname']);
    $new_email = trim($_POST['email']);
    
    $stmt = $conn->prepare("UPDATE registered_users SET firstname=?, lastname=?, email=? WHERE email=?");
    $stmt->bind_param("ssss", $first_name, $last_name, $new_email, $email);

    if ($stmt->execute()) {
        $_SESSION['email'] = $new_email;
        $_SESSION['username'] = $first_name . ' ' . $last_name;
        $response = ['status' => 'success', 'message' => 'Profile updated successfully!'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error updating profile.'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    $stmt->close();
    exit();
}
//logout section
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Cancel Profile Update
if (isset($_POST['cancle'])) {
    echo "<script>alert('Nothing will change'); window.location.href='userprofile.php';</script>";
    exit();
}
if (isset($_POST['pw_cancle'])) {
    echo "<script>alert('Nothing will change'); window.location.href='userprofile.php';</script>";
    exit();
}

// Update password
if (isset($_POST['update_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass=$_POST["confirm_password"];

    // Verify old password
    $stmt = $conn->prepare("SELECT password FROM registered_users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if (empty($current_pass) || empty($new_pass) || empty($confirm_pass)) {
        echo "<script>alert('All fields are required!'); window.location.href='userprofile.php';</script>";
        exit();
    }
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_pass);
        $stmt->fetch();

        // Check if current password is correct
        if (password_verify($current_pass, $db_pass)) {
            // Check if new password matches confirmation
            if ($new_pass == $confirm_pass) {
                $hashed_new_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                $stmt->close();

                // Update the password
                $stmt = $conn->prepare("UPDATE registered_users SET password=? WHERE email=?");
                $stmt->bind_param("ss", $hashed_new_pass, $email);
                if ($stmt->execute()) {
                    echo "<script>alert('Password updated successfully!'); window.location.href='userprofile.php';</script>";
                } else {
                    echo "<script>alert('Error updating password.'); window.location.href='userprofile.php';</script>";
                }
            } else {
                echo "<script>alert('New passwords do not match!'); window.location.href='userprofile.php';</script>";
            }
        } else {
            echo "<script>alert('Current password is incorrect.'); window.location.href='userprofile.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='userprofile.php';</script>";
    }

    $stmt->close();
    exit();
}

//image upload
// if (isset($_POST['upload_image'])) {
//     if (!empty($_FILES['profile_image']['name'])) {
//         $file_name = time() . "_" . basename($_FILES['profile_image']['name']);
//         $target_file = "User_Img/" . $file_name;

//         if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
//             $stmt = $conn->prepare("UPDATE registered_users SET profile_image=? WHERE email=?");
//             $stmt->bind_param("ss", $file_name, $email);
//             $stmt->execute();
//             $_SESSION['success_msg'] = "Profile image updated!";
//             $stmt->close();
//         } else {
//             $_SESSION['error_msg'] = "Error uploading image.";
//         }
//     } else {
//         $_SESSION['error_msg'] = "No file selected.";
//     }
//     header("Location: profile.php");
//     exit();
// }
?>