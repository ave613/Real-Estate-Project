<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get the property ID from the URL
$property_id = isset($_GET['property_id']) ? intval($_GET['property_id']) : 0;

// Redirect if property_id is invalid
if ($property_id <= 0) {
    $_SESSION['error_message'] = "Invalid property selected.";
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Inquiry Form</title>
     <style>
        body {
            font-family: Arial, sans-serif;
            background:linear-gradient(to right, #e2e2e2,rgb(245, 214, 195));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 25px;
            
        }
        .form-container {
            margin-top:40px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            height: 100%;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0 30px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-container input:valid {
            border-color: green;
        }
        .form-container input:invalid {
            border-color: red;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color:rgb(241, 152, 8);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color:rgb(255, 157, 0);
        }
        .form-container .message {
            text-align: center;
            font-size: 0.9em;
            margin-top: 10px;
        }
        .form-container .message.error {
            color: red;
        }
        .form-container .message.success {
            color: green;
        }
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0 35px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical; /* Allows user to resize vertically */
            min-height: 100px;
            font-family: Arial, sans-serif;
        }

    </style>
</head>
<body>
<?php
$prev_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
?>
<a href="<?php echo $prev_page; ?>" class="close-button">
    <i class="fas fa-times"></i>
</a>

<style>
    .close-button {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .close-button:hover {
        color: red;
    }
</style>


    <div class="form-container">
        <h2>User Submission Form</h2>
        <form action="form.php?property_id=<?= htmlspecialchars($property_id); ?>" method="POST">
            <input type="hidden" name="property_id" value="<?= htmlspecialchars($property_id); ?>"> <!-- Hidden input -->
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email (must end with @gmail.com)" pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" required>
            <input type="tel" name="phone" placeholder="Phone Number (09 or +959 followed by 9 digits)" pattern="^(09|\+959)[0-9]{7,9}$" required>
            <textarea name="message" placeholder="Your Message" rows="4"></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

   
