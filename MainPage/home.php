<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Initialize variables from GET parameters (if set) and convert to proper case
$selected_type = isset($_GET['type']) ? ucfirst(strtolower($_GET['type'])) : 'Sale';
$selected_township = isset($_GET['township']) ? $_GET['township'] : '';
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
$price_from = isset($_GET['price_from']) ? $_GET['price_from'] : '';
$price_to = isset($_GET['price_to']) ? $_GET['price_to'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextDoor - Home</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text-shadow: .3rem .3rem 0 rgba(0, 0, 0, .2);
            --black: #000;
            --blue: #42586e;
            --light-color: rgb(145, 156, 163);
        }


        * {
            font-family: Nunito;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-transform: capitalize;
        }

        html {
            font-size: 62.5%;
            overflow-x: hidden;
            scroll-behavior: smooth;
            scroll-padding-top: 7rem;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--black);
            line-height: 1.8;
            text-shadow: var(--text-shadow);
            margin-bottom: 20px;
            text-align: center;
        }

        h3 {
            font-size: 2em;
            margin-bottom: 10px;
            text-align: left;
        }

        p {
            text-align: center;
            font-size: 2em;
            color: #666;
        }

        section:nth-child(even) {
            background-color: #f5f5f5;
        }

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

        /* CSS for Logined User */
        .user-profile {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--light-color);
            text-decoration: none;
            font-size: 1.1rem;
        }

        .user-profile i {
            font-size: 1.4rem;
            color: var(--light-color);
        }

        .user-profile span {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--grey);
        }

        .user-profile:hover {
            color: var(--blue);
            text-decoration: underline;
        }

        .searchbar {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #2b6777;
            color: white;
            padding: 20px;
        }

        .search-container {
            background-color: white;
            color: #333;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .search-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .tabs button {
            background-color: #f4f4f4;
            color: #2b6777;
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .tabs button:hover {
            background-color: #e6e6e6;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        select,
        input[type="number"],
        button {
            padding: 10px;
            font-size: 1.3rem;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button[type="submit"],
        button[type="reset"] {
            background-color: #2b6777;
            color: white;
            cursor: pointer;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover,
        button[type="reset"]:hover {
            background-color: #1b4f5a;
        }

        .advanced {
            text-align: center;
            margin-top: 10px;
        }

        .advanced a {
            color: #2b6777;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .advanced a:hover {
            text-decoration: underline;
        }

        .advanced-content {
            display: none;
            gap: 15px;
        }

        .advanced-content label {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .advanced-content select,
        .advanced-content input {
            width: 100%;
        }

        .tabs button.active {
            background-color: rgba(199, 125, 56, 0.87);
            color: white;
        }

        /* Optional: style the advanced-content flex layout */
        .advanced-content {
            display: none;
            flex-direction: column;
            gap: 15px;
        }

        /* Wishlist Button */
        .heart {
            font-size: 30px;
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
    <script>
        // Toggle the advanced search options
        function toggleAdvanced() {
            const advancedContent = document.querySelector('.advanced-content');
            advancedContent.classList.toggle('active');
        }

        function setType(type) {
            var properType = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
            document.getElementById('type').value = properType;
        }

        // function toggleHeart() {
        //     document.querySelector('.heart').classList.toggle('filled');
        // }

        function toggleWishlist(propertyId, heartElement) {
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
                    } else if (data === 'removed') {
                        heartElement.classList.remove('filled');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</head>

<body>
    <?php
    include("header.php");
    ?>

    <!-- search section starts -->
    <section class="searchbar">
        <div class="search-container" style="margin-top:150px;">
            <h1>Find Your Favorite Homes at NextDoor</h1>
            <div class="tabs">
                <button type="button" id="saleBtn" onclick="setType('Sale')">Sale</button>
                <button type="button" id="rentBtn" onclick="setType('Rent')">Rent</button>
            </div>
            <form method="GET" action="search.php" id="searchForm">
                <!-- The hidden "type" field will be set by the buttons; if not set, search.php will show both -->
                <input type="hidden" name="type" id="type" value="<?php echo htmlspecialchars($selected_type); ?>">

                <select name="township" id="township">
                    <option value="">-- Select a Township --</option>
                    <option value="Hlaing" <?php if ($selected_township == 'Hlaing') echo 'selected'; ?>>Hlaing</option>
                    <option value="Lanmadaw" <?php if ($selected_township == 'Lanmadaw') echo 'selected'; ?>>Lanmadaw</option>
                    <option value="Sanchaung" <?php if ($selected_township == 'Sanchaung') echo 'selected'; ?>>Sanchaung</option>
                    <option value="Kamaryut" <?php if ($selected_township == 'Kamaryut') echo 'selected'; ?>>Kamaryut</option>
                    <option value="Dagon" <?php if ($selected_township == 'Dagon') echo 'selected'; ?>>Dagon</option>
                    <option value="Mayangone" <?php if ($selected_township == 'Mayangone') echo 'selected'; ?>>Mayangone</option>
                    <option value="South Dagon" <?php if ($selected_township == 'South Dagon') echo 'selected'; ?>>South Dagon</option>
                    <option value="North Dagon" <?php if ($selected_township == 'North Dagon') echo 'selected'; ?>>North Dagon</option>
                    <option value="North Okkalapa" <?php if ($selected_township == 'North Okkalapa') echo 'selected'; ?>>North Okkalapa</option>
                    <option value="South Okkalapa" <?php if ($selected_township == 'South Okkalapa') echo 'selected'; ?>>South Okkalapa</option>
                    <option value="Kyi Myin Tine" <?php if ($selected_township == 'Kyi Myin Tine') echo 'selected'; ?>>Kyi Myin Tine</option>
                    <option value="Pazundaung" <?php if ($selected_township == 'Pazundaung') echo 'selected'; ?>>Pazundaung</option>
                    <option value="Bahan" <?php if ($selected_township == 'Bahan') echo 'selected'; ?>>Bahan</option>
                    <option value="Hlaing Tharyar" <?php if ($selected_township == 'Hlaing Tharyar') echo 'selected'; ?>>Hlaing Tharyar</option>
                </select>

                <div class="advanced">
                    <a href="javascript:void(0);" onclick="toggleAdvanced()">Advanced &#9662;</a>
                </div>
                <div class="advanced-content">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">-- Select --</option>
                        <option value="Apartment" <?php if ($selected_category == 'Apartment') echo 'selected'; ?>>Apartment</option>
                        <option value="House" <?php if ($selected_category == 'House') echo 'selected'; ?>>House</option>
                        <option value="Condo" <?php if ($selected_category == 'Condo') echo 'selected'; ?>>Condo</option>
                    </select>
                    <label for="price-from">Price from (Lakhs)</label>
                    <input type="number" id="price-from" name="price_from" placeholder="From" value="<?php echo htmlspecialchars($price_from); ?>">
                    <label for="price-to">Price to (Lakhs)</label>
                    <input type="number" id="price-to" name="price_to" placeholder="To" value="<?php echo htmlspecialchars($price_to); ?>">
                </div>

                <button type="submit">Search</button>
                <!-- Reset button clears the form and active type -->
                <button type="reset" onclick="resetFilters()">Reset</button>
            </form>
        </div>
    </section>

    <!-- JavaScript to handle type selection and reset -->
    <script>
        // Set the type and update active button color
        function setType(type) {
            var properType = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
            document.getElementById('type').value = properType;
            // Remove active class from both buttons
            document.getElementById('saleBtn').classList.remove('active');
            document.getElementById('rentBtn').classList.remove('active');
            // Add active class to the clicked button
            if (properType === "Sale") {
                document.getElementById('saleBtn').classList.add('active');
            } else if (properType === "Rent") {
                document.getElementById('rentBtn').classList.add('active');
            }
        }

        // Reset filters and clear active classes
        function resetFilters() {
            // Clear the hidden type field
            document.getElementById('type').value = "";
            // Reset the form fields to their default values
            document.getElementById('searchForm').reset();
            // Remove active classes from both buttons
            document.getElementById('saleBtn').classList.remove('active');
            document.getElementById('rentBtn').classList.remove('active');
        }

        // If the page loads with a selected type, set the active button accordingly.
        window.onload = function() {
            var currentType = document.getElementById('type').value;
            if (currentType.toLowerCase() === "sale") {
                document.getElementById('saleBtn').classList.add('active');
            } else if (currentType.toLowerCase() === "rent") {
                document.getElementById('rentBtn').classList.add('active');
            }
        }

        // (Optional) Toggle the display of advanced search options
        function toggleAdvanced() {
            var advancedContent = document.querySelector('.advanced-content');
            advancedContent.style.display = advancedContent.style.display === 'flex' ? 'none' : 'flex';
        }
    </script>
    <!-- search section ends -->

    <!-- property section starts-->
    <section class="property">
        <h1 style="color: black; padding-top:100px;">Properties</h1>
        <p>Explore our latest listings of properties available for sale and rent.</p>
        <div class="properties-container">
            <?php
            include 'connect.php';
            // $sql = "SELECT * FROM properties WHERE id BETWEEN 1 AND 6";
            $sql = "SELECT p.*, pi.image 
                FROM property_details p 
                LEFT JOIN property_images pi ON p.id = pi.property_id 
                WHERE pi.id IN (1, 5, 9, 13, 17, 21) 
                GROUP BY p.id";
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

                echo '<div class="property-card">
                    <div class="image">
                        <span class="tag ' . ((strtolower($row["type"]) === 'rent') ? 'rent' : '') . '">' . $row["type"] . '</span>
                        <img src="Img/' . $row["image"] . '" alt="' . $row["title"] . '">
                    </div>
                    <div class="details">
                        <h3>' . htmlspecialchars($row["title"]) . ' 
                            <div class="heart ' . ($isWishlisted ? 'filled' : '') . '" onclick="toggleWishlist(' . $row["id"] . ', this)"></div>
                        </h3>
                        <p class="price">' . $row["price"] . ' Lakhs</p>
                        <p class="location"><i class="fas fa-map-marker-alt"></i> ' . $row["location"] . '</p>
                        <div class="features">
                            <span><i class="fas fa-bed"></i> ' . $row["beds"] . ' Bedrooms</span>
                            <span><i class="fas fa-bath"></i> ' . $row["baths"] . ' Baths</span>
                            <span><i class="fas fa-ruler-combined"></i> ' . $row["size"] . ' Square Feet</span>
                        </div>
                        <div class="btn-container">
                            <a href="propertydetail.php?id=' . $row["id"] . '" class="btn details-btn">Details</a>
                            <a href="' . $interestPage . '?property_id=' . $row["id"] . '" class="btn interest-btn">Interest</a>
                        </div>
                    </div>
                </div>';
            }

            ?>
        </div>
    </section>
    <?php include("footer.php");
    ?>

</body>

</html>