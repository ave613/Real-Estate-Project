<?php
include("header.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("connect.php");

// Fetch user's properties
$stmt = $conn->prepare("
    SELECT pd.*, 
           (SELECT pi.image FROM property_images pi WHERE pi.property_id = pd.id LIMIT 1) AS first_image
    FROM property_details pd 
    WHERE pd.user_email = ?
    ORDER BY pd.created_at DESC
");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Properties</title>
    <style>
        .properties-container {
            padding: 120px 20px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .property-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 15px;
            display: flex;
            gap: 20px;
        }

        .property-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .property-info {
            flex: 1;
        }

        .property-title {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #333;
        }

        .property-details {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .status-pending {
            background: #ffd700;
            color: #000;
        }

        .status-approved {
            background: #4CAF50;
            color: white;
        }

        .status-rejected {
            background: #f44336;
            color: white;
        }

        .no-properties {
            text-align: center;
            font-size: 1.6rem;
            color: #666;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="properties-container">
        <h1>My Properties</h1><br>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($property = $result->fetch_assoc()): ?>
                <div class="property-card">
                    <img src="<?php echo $property['first_image'] ? 'Img/' . htmlspecialchars($property['first_image']) : 'path/to/default-image.jpg'; ?>" 
                         alt="<?php echo htmlspecialchars($property['title']); ?>" 
                         class="property-image">
                    
                    <div class="property-info">
                        <h2 class="property-title"><?php echo htmlspecialchars($property['title']); ?></h2>
                        
                        <div class="property-details">
                            <p>Location: <?php echo htmlspecialchars($property['location']); ?></p>
                            <p>Price: <?php echo htmlspecialchars($property['price']); ?> Lakhs</p>
                            <p>Type: <?php echo htmlspecialchars($property['type']); ?></p>
                            <p>Created: <?php echo date('F j, Y', strtotime($property['created_at'])); ?></p>
                        </div>

                        <div class="status-container">
                            <div class="status status-<?php echo strtolower($property['moderation_status']); ?>">
                                Status: <?php echo htmlspecialchars($property['moderation_status']); ?>
                            </div>
                            <?php if ($property['moderation_status'] === 'Approved'): ?>
                                <a href="propertydetail.php?id=<?php echo $property['id']; ?>" class="details-btn">View Details</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-properties">
                <p>You haven't added any properties yet.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
<style>
    /* Add these styles in the existing <style> section */
    .status-container {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
    }

    .details-btn {
        display: inline-block;
        padding: 5px 15px;
        background-color: #42586e;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 1.2rem;
        transition: background-color 0.3s;
    }

    .details-btn:hover {
        background-color: #2c3e50;
    }
</style>