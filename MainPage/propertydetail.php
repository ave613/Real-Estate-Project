<?php
include("header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Detail</title>
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .property-detail {

            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .carousel-container {
            width: 50%;
            overflow: hidden;
        }

        .carousel img {
            width: 50%;
            height: auto;
        }

        .property-info {
            margin-top: 20px;
        }

        .property-info li {
            list-style: none;
            margin-top: 20px;
            font-size: 17px;
        }

        .features {
            margin-top: 20px;
        }

        .features ul {
            padding: 05;
        }

        .features ul li {
            font-size: 17px;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }

        .project-overview {
            margin-top: 20px;
        }

        .project-overview h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .project-overview p {
            font-size: large;
            color: #555;
            line-height: 1.6;
            padding: 20px;
            text-align: justify;

        }

        .banner {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            width: 100%;

        }

        .banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.527), rgba(0, 0, 0, 0.5)), url(Img/banner.png);
            z-index: -1;

        }

        .slider-container {
            padding-top: 50px;
        }

        .banner {
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;

        }

        .banner h1 {
            z-index: 1;
            font-size: 3rem;
            line-height: 1.2;
            padding-top: 65px;
        }

        .carousel-inner {
            overflow: hidden;
            border-radius: 10px;
        }

        .image-wrapper {
            height: 450px;
            overflow: hidden;
            border-radius: 10px;
        }

        .slider-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php
    include 'connect.php';

    if (isset($_GET['id'])) {
        $property_id = intval($_GET['id']);

        // Fetch property details
        $sql = "SELECT * FROM property_details WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $property_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $property = $result->fetch_assoc();
        } else {
            echo "<h2>Property not found</h2>";
            exit;
        }

        // Fetch property images
        $sql_images = "SELECT image FROM property_images WHERE property_id = ?";
        $stmt_images = $conn->prepare($sql_images);
        $stmt_images->bind_param("i", $property_id);
        $stmt_images->execute();
        $result_images = $stmt_images->get_result();
        $images = [];

        while ($row = $result_images->fetch_assoc()) {
            $images[] = $row['image'];
        }
    } else {
        echo "<h2>No Property ID Provided</h2>";
        exit;
    }
    ?>


    <!--Banner-->
    <div class="banner">
        <h1 class="text-white display-3 ;">PROPERTY DETAILS</h1>
        <!-- <div style="display: flex; align-items: flex-start; margin-top: 30px;">
            <a href="home.php" class="text-white display-6" style=" font-size: 2rem;  z-index:1;">Home</a>
        </div> -->

    </div>

    <!-- Image Slider -->
    <section class="slider-container d-flex justify-content-center align-items-center my-4">
        <div id="bootstrapSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000" style="max-width: 800px;">
            <div class="carousel-inner">
                <?php
                if (!empty($images)) {
                    foreach ($images as $index => $img) {
                        $active = ($index === 0) ? 'active' : '';
                        echo '<div class="carousel-item ' . $active . '">
                            <div class="image-wrapper">
                                <img src="img/' . $img . '" class="d-block w-100 slider-img" alt="">
                            </div>
                          </div>';
                    }
                } else {
                    echo "<h2>No Images Available</h2>";
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bootstrapSlider" data-bs-slide="prev">
                <span style="color: black; font-size: 50px; font-weight: bold;">&#8249;&#8249;</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bootstrapSlider" data-bs-slide="next">
                <span style="color: black; font-size: 50px; font-weight: bold;">&#8250;&#8250;</span>
            </button>
        </div>
    </section>

    <!-- Property Details -->
    <section class="property-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="property-info">
                        <h1><?php echo $property['title']; ?></h1><br>
                        <ul>
                            <li><strong>Property ID:</strong> <?php echo $property['id']; ?></li>
                            <li><strong>Offer type:</strong> <?php echo $property['type']; ?></li>
                            <li><strong>Location:</strong> <?php echo $property['location']; ?></li>
                            <?php if (!empty($property['size'])) { ?>
                                <li><strong>Size:</strong> <?php echo $property['size']; ?>sq ft</li>
                            <?php } ?>
                            <li><strong>Bedrooms:</strong> <?php echo $property['beds']; ?></li>
                            <li><strong>Bathrooms:</strong> <?php echo $property['baths']; ?></li>
                            <li><strong>Price:</strong> <?php echo $property['price']; ?> Lakhs</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="features">
                        <h1>Features</h1><br>
                        <ul>
                            <?php
                            $features = explode(",", $property['features']);
                            foreach ($features as $feature) {
                                echo "<li>$feature</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="project-overview">
                <h1>Property Description</h1>
                <p><?php echo $property['description']; ?></p>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<?php
include("footer.php");
?>

</html>