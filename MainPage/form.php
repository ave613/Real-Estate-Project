<?php
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $property_id = $_POST['property_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Fetch title and first image from the related tables
    $stmt = $conn->prepare("
        SELECT 
            pd.title, 
            COALESCE(pi.image, 'no-image.jpg') AS property_image
        FROM property_details pd
        LEFT JOIN (
            SELECT property_id, MIN(id) AS first_image_id
            FROM property_images
            GROUP BY property_id
        ) first_images ON pd.id = first_images.property_id
        LEFT JOIN property_images pi ON pi.id = first_images.first_image_id
        WHERE pd.id = ?
    ");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $stmt->bind_result($title, $image);
    $stmt->fetch();
    $stmt->close();

    // Insert the data into insert_info table
    $sql = "INSERT INTO insert_info (p_id, title, image, firstname, lastname, email, phone, message) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $property_id, $title, $image, $firstname, $lastname, $email, $phone, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Record inserted successfully!'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
