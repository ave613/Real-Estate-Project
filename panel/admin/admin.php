<?php
include("includes/header.php");
include("includes/topbar.php");
include("includes/sidebar.php");
include("connect.php");

// Fetch admin details
$sql = "SELECT * FROM registered_users WHERE email = 'nextdoor101r@gmail.com'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle profile update
if (isset($_POST['updateProfile'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    $updateQuery = "UPDATE registered_users SET firstname = ?, lastname = ? WHERE email = 'nextdoor101r@gmail.com'";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ss", $firstname, $lastname);

    if ($stmt->execute()) {
        // Update the $admin array with new values
        $admin['firstname'] = $firstname;
        $admin['lastname'] = $lastname;
        
        // After successful update
        echo "<script>
            document.getElementById('adminNameLink').textContent = '" . htmlspecialchars($firstname . ' ' . $lastname) . "';
            document.querySelector('input[name=\"firstname\"]').value = '" . htmlspecialchars($firstname) . "';
            document.querySelector('input[name=\"lastname\"]').value = '" . htmlspecialchars($lastname) . "';
            alert('Profile updated successfully!');
        </script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}

// Handle password change
if (isset($_POST['changePassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (password_verify($currentPassword, $admin['password'])) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE registered_users SET password = ? WHERE email = 'nextdoor101r@gmail.com'";
            $stmt = $conn->prepare($updatePasswordQuery);
            $stmt->bind_param("s", $hashedPassword);

            if ($stmt->execute()) {
                echo "<script>alert('Password changed successfully!');</script>";
            } else {
                echo "<script>alert('Error changing password!');</script>";
            }
        } else {
            echo "<script>alert('New passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
            padding-left: 50px;
        }

        /* .table { width: 100%; margin-bottom: 20px; } */
        .btn-primary,
        .btn-danger {
            width: 100%;
        }

        .text-danger {
            color: red;
            font-size: 14px;
        }

        .text-success {
            color: green;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Admin Profile</h2>

        <!-- <table class="table table-bordered">
            <tr>
                <th>First Name</th>
                <td><?= htmlspecialchars($admin['firstname']); ?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?= htmlspecialchars($admin['lastname']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($admin['email']); ?></td>
            </tr>
        </table> -->

        <!-- Update Profile Form -->
        <h4>Update Profile</h4><br>
        <form method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="firstname" value="<?= htmlspecialchars($admin['firstname']); ?>" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="lastname" value="<?= htmlspecialchars($admin['lastname']); ?>" required>
            </div>
            <button type="submit" name="updateProfile" class="btn btn-primary mt-2">Update Profile</button>
        </form>

        <!-- Change Password Form -->
        <h4 class="mt-4">Change Password</h4><br>
        <form method="post">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                <small id="passwordError" class="text-danger"></small>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="newPassword" minlength="8" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" name="confirmPassword" minlength="8" required>
            </div>
            <button type="submit" name="changePassword" class="btn btn-danger mt-2">Change Password</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#currentPassword").on("keyup", function() {
                let currentPassword = $(this).val();
                if (currentPassword.length > 0) {
                    $.ajax({
                        url: "validate_password.php",
                        method: "POST",
                        data: {
                            password: currentPassword
                        },
                        success: function(response) {
                            if (response === "valid") {
                                $("#passwordError").text("✔ Correct password").removeClass("text-danger").addClass("text-success");
                            } else {
                                $("#passwordError").text("❌ Incorrect password").removeClass("text-success").addClass("text-danger");
                            }
                        }
                    });
                } else {
                    $("#passwordError").text("");
                }
            });
        });
    </script>
</body>

</html>
<?php include("includes/footer.php"); ?>