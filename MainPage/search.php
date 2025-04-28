<?php
include 'connect.php';
include 'header.php';
// Build the base query and use MIN(pi.image) to pick one image per property
$sql = "SELECT p.*, MIN(pi.image) AS image 
        FROM property_details p 
        LEFT JOIN property_images pi ON p.id = pi.property_id 
        WHERE p.moderation_status = 'approved'";

// Initialize parameters for filters
$params = [];
$paramTypes = "";

// Filter by township if set
if (isset($_GET['township']) && $_GET['township'] !== '') {
    $sql .= " AND p.township = ?";
    $params[] = $_GET['township'];
    $paramTypes .= "s";
}

// Filter by type if set – convert to proper case
if (isset($_GET['type']) && $_GET['type'] !== '') {
    $type = ucfirst(strtolower($_GET['type']));
    $sql .= " AND p.type = ?";
    $params[] = $type;
    $paramTypes .= "s";
}

// Filter by category if set – convert to proper case
if (isset($_GET['category']) && $_GET['category'] !== '') {
    $category = ucfirst(strtolower($_GET['category']));
    $sql .= " AND p.category = ?";
    $params[] = $category;
    $paramTypes .= "s";
}

// Filter by price range if set
if (isset($_GET['price_from']) && $_GET['price_from'] !== '') {
    $sql .= " AND p.price >= ?";
    $params[] = $_GET['price_from'];
    $paramTypes .= "d";
}
if (isset($_GET['price_to']) && $_GET['price_to'] !== '') {
    $sql .= " AND p.price <= ?";
    $params[] = $_GET['price_to'];
    $paramTypes .= "d";
}

// Group by property id to avoid duplicate cards
$sql .= " GROUP BY p.id";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($paramTypes, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Results - NextDoor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .price {
            font-size: 17px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 5px;
        }

        /* Flex container for property cards */

        .properties-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 50px;
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
            /* Hollow heart */
        }

        .heart.filled::before {
            content: '\2665';
            /* Filled heart */
            color: darkorange;
        }
    </style>
</head>

<body>
    <h1 style="text-align:center; margin-top: 120px;">Search Results</h1>
    <!-- Flex container for property cards -->
    <div class="properties-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()) {
                // Check if user is logged in, then set the Interest button link accordingly
                $interestPage = isset($_SESSION['email']) ? 'user_info.php' : 'login.php';

                // Check if property is in user's wishlist
                $isWishlisted = false;
                if (isset($_SESSION['email'])) {
                    $checkWishlistQuery = "SELECT * FROM wishlist WHERE user_email = ? AND property_id = ?";
                    $stmt = $conn->prepare($checkWishlistQuery);
                    $stmt->bind_param("si", $_SESSION['email'], $row["id"]);
                    $stmt->execute();
                    $wishlistResult = $stmt->get_result();
                    $isWishlisted = $wishlistResult->num_rows > 0;
                }

                echo '<div class="property-card">
                    <div class="image">
                        <span class="tag ' . ((strtolower($row["type"]) === 'rent') ? 'rent' : '') . '">' . htmlspecialchars($row["type"]) . '</span>
                        <img src="Img/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '">
                    </div>
                    <div class="details">
                        <h3>' . htmlspecialchars($row["title"]) . ' 
                            <div class="heart ' . ($isWishlisted ? 'filled' : '') . '" onclick="toggleWishlist(' . $row["id"] . ', this)"></div>
                        </h3>
                        <p class="price">' . number_format($row["price"]) . ' Lakhs</p>
                        <p class="location"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($row["location"]) . '</p>
                        <div class="features">
                            <span><i class="fas fa-bed"></i> ' . htmlspecialchars($row["beds"]) . ' Bedrooms</span>
                            <span><i class="fas fa-bath"></i> ' . htmlspecialchars($row["baths"]) . ' Baths</span>
                            <span><i class="fas fa-ruler-combined"></i> ' . htmlspecialchars($row["size"]) . ' Sq Ft</span>
                        </div>
                        <div class="btn-container">
                            <a href="propertydetail.php?id=' . htmlspecialchars($row["id"]) . '" class="btn details-btn">Details</a>
                            <a href="' . $interestPage . '?property_id=' . htmlspecialchars($row["id"]) . '" class="btn interest-btn">Interest</a>
                        </div>
                    </div>
                </div>';
            } ?>
        <?php endif; ?>
    </div>

    <script>
        window.toggleWishlist = function(propertyId, heartElement) {
            // Check if user is logged in
            <?php if (!isset($_SESSION['email'])): ?>
                window.location.href = 'login.php';
                return;
            <?php endif; ?>
        
            fetch('wishlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'property_id=' + propertyId
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'added') {
                        heartElement.classList.add('filled');
                        heartElement.classList.remove('unfilled');
                    } else if (data === 'removed') {
                        heartElement.classList.remove('filled');
                        heartElement.classList.add('unfilled');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update wishlist. Please try again.');
                });
        };
    </script>

</body>

</html>