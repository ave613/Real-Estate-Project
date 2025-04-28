<?php
include("includes/header.php");
include("includes/topbar.php");
include("includes/sidebar.php");
include("connect.php");

// Define these paths at the beginning of your file, after the includes
$serverPath = $_SERVER['DOCUMENT_ROOT'] . "/Real%20Estate/MainPage/Img/";  // Physical server path
$webPath = "/Real%20Estate/MainPage/Img/";  // Web-accessible path for displaying images

// Use this to check if directory exists and create it if it doesn't
if (!file_exists($serverPath)) {
    mkdir($serverPath, 0777, true);
    error_log("Created directory: " . $serverPath);
}

// For file operations, let's try using a relative path
$uploadPath = "../../MainPage/Img/";  // This goes up two levels from panel/admin to reach MainPage

// Fetch property details
if (isset($_GET['id'])) {
    $propertyId = $_GET['id'];
    $query = "SELECT * FROM property_details WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $propertyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();
    if (!$property) {
        echo "<script>alert('Property not found!'); window.location.href='properties.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No property ID provided!'); window.location.href='properties.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add this at the beginning of the POST handler
    error_log("POST request received");
    error_log("Files received: " . print_r($_FILES, true));

    $title = $_POST['title'];
    $category = $_POST['category'];
    $size = $_POST['size'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $moderation_status = $_POST['moderation_status'];
    $features = $_POST['features'];
    $description = $_POST['description'];

    // Update the property details
    $updateQuery = "UPDATE property_details SET 
        title = ?, 
        category = ?, 
        size = ?, 
        beds = ?, 
        baths = ?, 
        price = ?, 
        location = ?, 
        type = ?, 
        moderation_status = ?,
        features = ?,
        description = ? 
        WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssiissssssi", $title, $category, $size, $beds, $baths, $price, $location, $type, $moderation_status, $features, $description, $propertyId);
    
    if($stmt->execute()) {
        // Get existing images
        $imageQuery = "SELECT id, image FROM property_images WHERE property_id = ? ORDER BY id ASC";
        $stmt = $conn->prepare($imageQuery);
        $stmt->bind_param("i", $propertyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentImages = $result->fetch_all(MYSQLI_ASSOC);

        // Process each image slot individually
        for ($i = 1; $i <= 4; $i++) {
            $fileKey = "image$i";
            
            if (!empty($_FILES[$fileKey]['name'])) {
                // Sanitize filename
                $imageName = preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES[$fileKey]['name']);
                $imageName = time() . "_" . $i . "_" . $imageName;
                $targetPath = $uploadPath . $imageName;
                
                if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $targetPath)) {
                    $index = $i - 1; // Array index is 0-based
                    
                    // If there's an existing image at this position
                    if(isset($currentImages[$index])) {
                        // Delete old file
                        $oldImagePath = $uploadPath . $currentImages[$index]['image'];
                        if(file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                        
                        // Update database record
                        $updateImageQuery = "UPDATE property_images SET image = ? WHERE id = ?";
                        $stmt = $conn->prepare($updateImageQuery);
                        $stmt->bind_param("si", $imageName, $currentImages[$index]['id']);
                        $stmt->execute();
                    } else {
                        // Insert new image record
                        $insertImageQuery = "INSERT INTO property_images (property_id, image) VALUES (?, ?)";
                        $stmt = $conn->prepare($insertImageQuery);
                        $stmt->bind_param("is", $propertyId, $imageName);
                        $stmt->execute();
                    }
                } else {
                    error_log("Failed to upload image: " . error_get_last()['message']);
                }
            }
        }
        
        echo "<script>alert('Property updated successfully!'); window.location.href='properties.php';</script>";
    } else {
        echo "<script>alert('Error updating property details!');</script>";
    }
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Property</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Fetch Existing Images -->
    <?php
    $property_id = $_GET['id'];
    $query = "SELECT * FROM property_details WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();

    // Fetch images from property_images table
    $imagesQuery = "SELECT image FROM property_images WHERE property_id = ? ORDER BY id ASC LIMIT 4";
    $stmt = $conn->prepare($imagesQuery);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $imagesResult = $stmt->get_result();

    $images = [];
    while ($imgRow = $imagesResult->fetch_assoc()) {
        $images[] = $imgRow['image'];
    }
    $stmt->close();
    ?>

    <!-- Edit Form -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="<?php echo htmlspecialchars($property['title']); ?>"
                                required maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="Apartment" <?php echo ($property['category'] === 'Apartment') ? 'selected' : ''; ?>>Apartment</option>
                                <option value="Condo" <?php echo ($property['category'] === 'Condo') ? 'selected' : ''; ?>>Condo</option>
                                <option value="House" <?php echo ($property['category'] === 'House') ? 'selected' : ''; ?>>House</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="size">Size (sq ft)</label>
                            <input type="text" class="form-control" id="size" name="size"
                                value="<?php echo htmlspecialchars($property['size']); ?>"
                                required maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="beds">Bedrooms</label>
                            <input type="number" class="form-control" id="beds" name="beds"
                                value="<?php echo htmlspecialchars($property['beds']); ?>"
                                required min="0" max="50">
                        </div>

                        <div class="form-group">
                            <label for="baths">Bathrooms</label>
                            <input type="number" class="form-control" id="baths" name="baths"
                                value="<?php echo htmlspecialchars($property['baths']); ?>"
                                required min="0" max="50">
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price"
                                value="<?php echo htmlspecialchars($property['price']); ?>"
                                required maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location"
                                value="<?php echo htmlspecialchars($property['location']); ?>"
                                required maxlength="200">
                        </div>

                        <div class="form-group">
                            <label for="features">Features (Comma separated)</label>
                            <input type="text" class="form-control" id="features" name="features"
                                value="<?php echo htmlspecialchars($property['features']); ?>"
                                required maxlength="500">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                required maxlength="1000"><?php echo htmlspecialchars($property['description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="Sale" <?php echo ($property['type'] === 'Sale') ? 'selected' : ''; ?>>Sale</option>
                                <option value="Rent" <?php echo ($property['type'] === 'Rent') ? 'selected' : ''; ?>>Rent</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="moderation_status">Moderation Status</label>
                            <select class="form-control" id="moderation_status" name="moderation_status" required>
                                <option value="Approved" <?php echo ($property['moderation_status'] === 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                <option value="Rejected" <?php echo ($property['moderation_status'] === 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                <option value="Pending" <?php echo ($property['moderation_status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Existing Images</label>
                            <div class="row">
                                <?php for ($i = 0; $i < 4; $i++) {
                                    $imagePath = !empty($images[$i]) ? $webPath . $images[$i] : "Img/no-image.png";
                                    echo "<div class='col-md-3 text-center'>
                                        <img src='$imagePath' class='img-thumbnail' width='100' height='80'>
                                      </div>";
                                } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Upload New Images (Optional)</label>
                            <input type="file" class="form-control-file" name="image1" accept="image/*">
                            <input type="file" class="form-control-file" name="image2" accept="image/*">
                            <input type="file" class="form-control-file" name="image3" accept="image/*">
                            <input type="file" class="form-control-file" name="image4" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="properties.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

<?php include("includes/footer.php"); ?>