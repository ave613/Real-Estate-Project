<?php
session_start();
require_once 'connect.php'; // Make sure your database connection file is included

// Check if ID is set
if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // First, delete related images from the property_images table
    $stmt_images = $conn->prepare("DELETE FROM property_images WHERE property_id = ?");
    $stmt_images->bind_param("i", $property_id);
    $stmt_images->execute();
    $stmt_images->close();

    // Now, delete the property from the property_details table
    $stmt = $conn->prepare("DELETE FROM property_details WHERE id = ?");
    $stmt->bind_param("i", $property_id);

    if ($stmt->execute()) {
        echo "<script>alert('Property deleted successfully!'); window.location.href='properties.php';</script>";
    } else {
        echo "<script>alert('Error deleting property!'); window.location.href='properties.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid Request!'); window.location.href='properties.php';</script>";
}
?>
