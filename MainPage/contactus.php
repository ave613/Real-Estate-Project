<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('background-image.jpg') no-repeat center center/cover;
        }

        .contact-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100vh;
            background:linear-gradient(to right, #e2e2e2,rgb(245, 214, 195));
            /* Add overlay */
            padding: 0 20px;
        }

        .contact-details {
            max-width: 400px;
        }

        .contact-details h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .contact-details p {
            margin: 0.5rem 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .contact-details p span {
            margin-right: 10px;
        }

        .map-container {
            width: 50%;
            text-align: center;
        }
        iframe {
            border: none;
            width: 100%;
            height: 500px;
        }
    </style>
</head>

<body>
<div class="contact-container">
        <div class="contact-details">
            <h2>Contact Us</h2>
            <p><span>&#128205;</span> Address: Parami Rd, Yangon</p>
            <p><span>&#128222;</span> Phone: 12346678</p>
            <p><span>&#128231;</span> Email: phoopyae.com</p>
        </div>
        <div class="map-container">
            <h2>Find Us Here</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3818.403627465909!2d96.13277827492213!3d16.855916483943485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1936f625d4ba7%3A0x9676670831769962!2sUniversity%20of%20Information%20Technology(UIT)!5e0!3m2!1sen!2smm!4v1739334568337!5m2!1sen!2smm" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</body>

</html>

<!-- <?php

$host = "localhost";
$user = "root";
$password = "";
$database = "real_estate";

$conn = new mysqli($host, $user, $password, $database);
$sql = "SELECT * FROM `contacts`;";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";
    $sql = "SELECT * FROM `contacts`";

    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
<?php
// view_messages.php
include 'connect.php';

$result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
    echo "<p><strong>" . $row['name'] . ":</strong> " . $row['message'] . " (" . $row['email'] . ")</p>";
}
$conn->close();
?> -->