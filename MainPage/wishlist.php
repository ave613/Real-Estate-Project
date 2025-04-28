<?php
session_start();

// If it's an AJAX request, don't include header
if (isset($_POST['property_id'])) {
    include("connect.php");
    
    // Check if user is logged in
    if (!isset($_SESSION['email'])) {
        echo 'login_required';
        exit();
    }

    $userEmail = $_SESSION['email'];
    $propertyId = $_POST['property_id'];

    // Check if property is already in wishlist
    $checkQuery = "SELECT * FROM wishlist WHERE user_email = ? AND property_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("si", $userEmail, $propertyId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Remove from wishlist
        $deleteQuery = "DELETE FROM wishlist WHERE user_email = ? AND property_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("si", $userEmail, $propertyId);
        if ($stmt->execute()) {
            echo 'removed';
        } else {
            echo 'error';
        }
    } else {
        // Add to wishlist
        $insertQuery = "INSERT INTO wishlist (user_email, property_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("si", $userEmail, $propertyId);
        if ($stmt->execute()) {
            echo 'added';
        } else {
            echo 'error';
        }
    }
    exit();
}

// For normal page load, include header and continue with the rest
include("header.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("connect.php");

// Get user's email from session
$userEmail = $_SESSION['email'];

// Fetch wishlisted properties with their images
$query = "SELECT p.*, pi.image 
          FROM property_details p 
          INNER JOIN wishlist w ON p.id = w.property_id 
          LEFT JOIN property_images pi ON p.id = pi.property_id 
          WHERE w.user_email = ? 
          GROUP BY p.id";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - NextDoor</title>
    <style>
        .properties-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 50px;
            padding: 20px;
        }

        .property-card {
            width: 325px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .property-card .image {
            position: relative;
        }

        .property-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .property-card .tag {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #19d420;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8em;
            text-transform: uppercase;
        }

        .property-card .tag.rent {
            background: #e67e22;
        }

        .property-card .details {
            padding: 16px;
        }

        .property-card .details h3 {
            font-size: 1.5em;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .property-card .details p {
            color: #666;
            font-size: 1.2em;
            line-height: 1.5;
        }

        .property-card .details .price {
            font-size: 1.2em;
            color: #e74c3c;
            margin: 5px 0;
        }

        .property-card .details .location {
            font-size: 1.2em;
            color: #888;
            margin-bottom: 10px;
        }

        .property-card .details .features {
            display: flex;
            justify-content: space-between;
            font-size: 1.2em;
            margin-top: 10px;
        }

        .property-card .details .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 16px;
        }

        .property-card .details .btn {
            flex: 1;
            display: inline-block;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            font-size: 18px;
        }

        .property-card .details .btn:hover {
            background-color: #2980b9;
        }

        .property-card .details .interest-btn {
            background-color: #e67e22;
        }

        .property-card .details .interest-btn:hover {
            background-color: #d35400;
        }

        .heart {
            font-size: 24px;
            color: orange;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

        .heart::before {
            content: '\2661';
        }

        .heart.filled::before {
            content: '\2665';
            color: darkorange;
        }

        .wishlist-header {
            text-align: center;
            padding: 40px 0 20px;
            color: #333;
            font-size: 2.5em;
            margin-top: 60px;
        }

        .no-properties {
            text-align: center;
            padding: 40px;
            font-size: 1.5em;
            color: #666;
        }
    </style>
</head>

<body>
    <h1 class="wishlist-header">My Wishlist</h1>

    <div class="properties-container">
        <?php if ($result->num_rows > 0) : ?>
            <?php while ($property = $result->fetch_assoc()) : ?>
                <div class="property-card">
                    <div class="image">
                        <span class="tag <?php echo (strtolower($property['type']) === 'rent') ? 'rent' : ''; ?>"><?php echo htmlspecialchars($property['type']); ?></span>
                        <img src="Img/<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
                    </div>
                    <div class="details">
                        <h3>
                            <?php echo htmlspecialchars($property['title']); ?>
                            <div class="heart filled" onclick="toggleWishlist(<?php echo $property['id']; ?>, this)"></div>
                        </h3>
                        <p class="price"><?php echo number_format($property['price']); ?> Lakhs</p>
                        <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($property['location']); ?></p>
                        <div class="features">
                            <span><i class="fas fa-bed"></i> <?php echo htmlspecialchars($property['beds']); ?> Bedrooms</span>
                            <span><i class="fas fa-bath"></i> <?php echo htmlspecialchars($property['baths']); ?> Baths</span>
                            <span><i class="fas fa-ruler-combined"></i> <?php echo htmlspecialchars($property['size']); ?> Square Feet</span>
                        </div>
                        <div class="btn-container">
                            <a href="propertydetail.php?id=<?php echo $property['id']; ?>" class="btn details-btn">Details</a>
                            <a href="user_info.php?property_id=<?php echo $property['id']; ?>" class="btn interest-btn">Interest</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="no-properties">
               <h3>No properties in your wishlist yet.</h3>
               <a href="properties.php" class="add-properties" style="text-decoration: none;font-size: large;">Explore Properties</a>
           </div>
        <?php endif; ?>
    </div>

    <script>
        function toggleWishlist(propertyId, heartElement) {
            fetch('wishlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'property_id=' + propertyId
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'removed') {
                        heartElement.closest('.property-card').remove();
                        if (document.querySelectorAll('.property-card').length === 0) {
                            document.querySelector('.properties-container').innerHTML = '<div class="no-properties"><p>No properties in your wishlist yet.</p></div>';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
</body>
</html>