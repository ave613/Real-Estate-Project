<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Listings</title>
    <style>
        body {
            background-color: #f5f5f5;
        }

        section:nth-child(even) {
            background-color: #f5f5f5;
        }

        * Section Styling */ section.property {
            padding: 20px;
        }

        /* Responsive Grid for Property Cards */
        .container {

            margin: 50px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Centers items */
            gap: 30px;
            padding: 20px;
        }

        /* Property Card */
        .card {
            flex: 1 1 calc(33.33% - 20px);
            max-width: calc(33.33% - 20px);
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .card {
                flex: 1 1 calc(50% - 20px);
                /* 2 cards per row */
                max-width: calc(50% - 20px);
            }
        }

        @media (max-width: 600px) {
            .card {
                flex: 1 1 100%;
                /* 1 card per row */
                max-width: 100%;
            }
        }

        .card-content h3 {
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Price, Size, and Features */
        .price {
            font-size: 17px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 5px;
        }

        .size {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .info {
            font-size: 12px;
            color: #888;
            display: flex;
            justify-content: space-between;
        }

        .info span {
            display: flex;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: black;
            font-size: 70px;
        }

        .properties-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 50px;
        }


        .location {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 14px;
            color: #555;
        }

        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 16px;
        }

        .image {
            position: relative;
            /* Make it a positioning reference */
        }

        .tag {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #19d420;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 1.2em;
            font-weight: bold;
            text-transform: uppercase;
        }

        .tag.rent {
            background: #e67e22;
        }


        /* property-card */
        .btn {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            color: white;
            font-weight: bold;
            transition: background 0.3s;
        }

        .details-btn {
            background-color: #3498db;
        }

        .details-btn:hover {
            background-color: #2980b9;
        }

        .interest-btn {
            background-color: #e67e22;
        }

        .interest-btn:hover {
            background-color: #d35400;
        }

        /* Wishlist Button */
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

        /* Newly Added */
        .property-detail {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .property-container {
            display: flex;
            gap: 20px;
        }

        .image-carousel {
            width: 60%;
            position: relative;
        }

        .carousel {
            position: relative;
            width: 100%;
        }

        .carousel-images img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: none;
            border-radius: 8px;
        }

        .carousel-images img.active {
            display: block;
        }

        .carousel button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);

            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }


        .carousel .prev {
            left: 10px;
        }

        .carousel .next {
            right: 10px;
        }

        .property-info h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .property-info .location {
            font-size: 16px;
            color: #777;
            margin-bottom: 10px;
        }

        .property-info .price {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .features {
            margin: 20px 0;
            font-size: 16px;
        }

        .features span {
            display: block;
            margin-bottom: 5px;
        }

        .interest-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #ff6600;
            color: white;
            font-size: 18px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .interest-btn:hover {
            background-color: #e65c00;
        }

        .banner {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            height: 50vh;
            /* Reduced height */
            width: 100%;
        }

        .banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('img/pBanner2.jpg') center/cover no-repeat;
            opacity: 0.5;

        }

        .banner p {
            top: 20px;
            color: #004563;
            z-index: 1;
            font-size: 4rem;
            font-weight: bold;
            padding-top: 2.5em;
            text-shadow: .3rem .3rem 0 rgba(0, 0, 0, .2);

        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: #004563;
            padding: 8px 12px;
            transition: 0.3s;
            z-index: 1;
        }

        .back-button:hover {
            color: black
        }

        .back-button i {
            margin-right: 8px;
        }

        #topBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 15px;
            font-size: 16px;
            background-color: #004563;
            color: white;
            border: none;
            border-radius: 100px;
            cursor: pointer;
            display: none;
        }

        #topBtn:hover {
            background-color: rgb(1, 34, 48);
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px 0;
            gap: 10px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 16px;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
            color: #004563;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #004563;
            color: white;
        }

        .pagination .active {
            background-color: #004563;
            color: white;
            border-color: #004563;
        }

        .pagination .disabled {
            color: #999;
            cursor: not-allowed;
        }
    </style>

<body>
    <section class="property">
        <!-- <a href="home.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Back
        </a> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
        <div class="banner">
            <p>Property Listings</p>
        </div>
        <div class="container">
            <?php
            include 'connect.php';

            // Number of properties per page
            $properties_per_page = 15;

            // Get current page
            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($current_page - 1) * $properties_per_page;

            // Get total number of properties
            $total_query = "SELECT COUNT(DISTINCT p.id) as total FROM property_details p WHERE p.moderation_status = 'approved'";
            $total_result = $conn->query($total_query);
            $total_row = $total_result->fetch_assoc();
            $total_properties = $total_row['total'];
            $total_pages = ceil($total_properties / $properties_per_page);

            // Modified query with LIMIT and OFFSET
            $sql = "SELECT p.*, pi.image 
                   FROM property_details p 
                   LEFT JOIN property_images pi ON p.id = pi.property_id 
                   WHERE p.moderation_status = 'approved' 
                   GROUP BY p.id
                   LIMIT $properties_per_page OFFSET $offset";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
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

                echo '<div class="card">
                    <div class="image">
                        <span class="tag ' . ((strtolower($row["type"]) === 'rent') ? 'rent' : '') . '">' . $row["type"] . '</span>
                        <img src="Img/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '">
                    </div>
                    <div class="card-content">
                        <h3>' . htmlspecialchars($row["title"]) . ' 
                            <div class="heart ' . ($isWishlisted ? 'filled' : '') . '" onclick="toggleWishlist(' . $row["id"] . ', this)"></div>
                        </h3>
                        <p class="price">' . htmlspecialchars($row["price"]) . ' Lakhs</p>
                        <p class="location"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($row["location"]) . '</p>
                        <div class="features">
                            <span><i class="fa fa-bed"></i> ' . htmlspecialchars($row["beds"]) . ' Bedrooms</span>
                            <span><i class="fas fa-bath"></i> ' . htmlspecialchars($row["baths"]) . ' Baths</span>
                            <span><i class="fas fa-ruler-combined"></i> ' . htmlspecialchars($row["size"]) . ' Square Feet</span>
                        </div>
                        <div class="btn-container">
                            <a href="propertydetail.php?id=' . htmlspecialchars($row["id"]) . '" class="btn details-btn">Details</a>
                            <a href="' . $interestPage . '?property_id=' . htmlspecialchars($row["id"]) . '" class="btn interest-btn">Interest</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
        <!-- Add pagination -->
        <div class="pagination">
            <?php
            // Previous button
            if ($current_page > 1) {
                echo '<a href="?page=' . ($current_page - 1) . '">&laquo; Previous</a>';
            } else {
                echo '<span class="disabled">&laquo; Previous</span>';
            }

            // Page numbers
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                    echo '<span class="active">' . $i . '</span>';
                } else {
                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
                }
            }

            // Next button
            if ($current_page < $total_pages) {
                echo '<a href="?page=' . ($current_page + 1) . '">Next &raquo;</a>';
            } else {
                echo '<span class="disabled">Next &raquo;</span>';
            }
            ?>
        </div>
        <button id="topBtn"><i class="fas fa-arrow-up"></i></button>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let topBtn = document.getElementById("topBtn");

                // Wishlist toggle function
                window.toggleWishlist = function(propertyId, heartElement) {
                    // Check if user is logged in
                    <?php if (!isset($_SESSION['email'])): ?>
                        window.location.href = 'login.php';
                        return;
                    <?php endif; ?>

                    // Toggle heart state immediately
                    if (heartElement.classList.contains('filled')) {
                        heartElement.classList.remove('filled');
                    } else {
                        heartElement.classList.add('filled');
                    }

                    // Send request to server without page refresh
                    fetch('wishlist.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'property_id=' + propertyId
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log('Server response:', data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Revert heart state if there's an error
                            if (heartElement.classList.contains('filled')) {
                                heartElement.classList.remove('filled');
                            } else {
                                heartElement.classList.add('filled');
                            }
                        });

                    // Prevent default action and stop event propagation
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                };

                window.onscroll = function() {
                    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                        topBtn.style.display = "block";
                    } else {
                        topBtn.style.display = "none";
                    }
                };

                topBtn.addEventListener("click", function() {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                });
            });
        </script>
    </section>
</body>