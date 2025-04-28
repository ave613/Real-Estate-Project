<?php
include 'connect.php'; 
if (isset($_GET['id'])) {
    $propertyId = intval($_GET['id']);

    // Fetch all images related to the property
    $imageQuery = "SELECT image FROM property_images WHERE property_id = ?";
    $imgStmt = $conn->prepare($imageQuery);
    $imgStmt->bind_param("i", $propertyId);
    $imgStmt->execute();
    $result = $imgStmt->get_result();

    //  Delete images from the folder
    while ($row = $result->fetch_assoc()) {
        $imagePath = "Img/" . $row['image']; // Adjust based on folder location
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }
    $imgStmt->close();

    // Delete images from `property_images` table
    $deleteImagesQuery = "DELETE FROM property_images WHERE property_id = ?";
    $delImgStmt = $conn->prepare($deleteImagesQuery);
    $delImgStmt->bind_param("i", $propertyId);
    $delImgStmt->execute();
    $delImgStmt->close();

    // Delete the property from `property_details` table
    $deletePropertyQuery = "DELETE FROM property_details WHERE id = ?";
    $delPropStmt = $conn->prepare($deletePropertyQuery);
    $delPropStmt->bind_param("i", $propertyId);
    if ($delPropStmt->execute()) {
        echo "<script>alert('Property and images deleted successfully.'); window.location.href='properties.php';</script>";
    } else {
        echo "<script>alert('Error deleting property.'); window.location.href='properties.php';</script>";
    }
    $delPropStmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='properties.php';</script>";
}
?>
