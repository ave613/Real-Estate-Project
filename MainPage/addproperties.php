<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $category = $_POST['category'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $township = $_POST['township'];
    $size = $_POST['size'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $price = $_POST['price'];
    $features = $_POST['features'];
    $description = $_POST['description'];
    $propertyType = $_POST['type'];
    $phones=$_POST['phone'];

      // Validate phone number (only digits, length 7-15)
      if (!preg_match('/^\d{7,15}$/', $phones)) {
        die("<script>alert('Invalid phone number. Please enter a number between 9 and 11 digits.'); window.history.back();</script>");
    }

    // Handle the payment image
    //$paymentFilePath = null;
    $upload = "payments/";
    
    if (!empty($_FILES['transaction_img']['tmp_name'])) {
        $paymentFilename = time() . "_" . basename($_FILES['transaction_img']['name']);
        $paymentFilePath =$paymentFilename;
    
        // Move uploaded payment proof
        if (!move_uploaded_file($_FILES['transaction_img']['tmp_name'], $paymentFilePath)) {
            echo "<script>alert('Failed to upload payment proof.');</script>";
            $paymentFilePath = null;
        }
    }
     
    $stmt = $conn->prepare("INSERT INTO property_details (category, title, location, township, size, beds, baths, price, features, description, type, transaction_img, phone, user_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiidssssis", $category, $title, $location, $township, $size, $beds, $baths, $price, $features, $description, $propertyType, $paymentFilePath, $phones, $_SESSION['email']);
    if ($stmt->execute()) { 
        // Get the inserted property ID
        $propertyId = $stmt->insert_id;
    
        // Handle the four images
        $imageFields = ['image1', 'image2', 'image3', 'image4'];
        $uploadDir = "Img/"; // Change this to match your project structure
    
        foreach ($imageFields as $imageField) {
            if (!empty($_FILES[$imageField]['tmp_name'])) {
                $originalName = basename($_FILES[$imageField]['name']);
                $filename = $propertyId . "_" . time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "", $originalName); // Sanitize filename
                $targetFilePath = $uploadDir . $filename;
    
                // Move the uploaded file to the project Img folder
                if (move_uploaded_file($_FILES[$imageField]['tmp_name'], $targetFilePath)) {
                    // Insert image record into `property_images` table
                    $imgStmt = $conn->prepare("INSERT INTO property_images (property_id, image) VALUES (?, ?)");
                    $imgStmt->bind_param("is", $propertyId, $filename);
    
                    if (!$imgStmt->execute()) {
                        echo "<script>alert('Error saving image to database: " . $imgStmt->error . "');</script>";
                    }
    
                    $imgStmt->close();
                } else {
                    echo "<script>alert('Failed to upload image: " . htmlspecialchars($originalName) . "');</script>";
                }
            }
        }
    
        echo "<script>alert('Property and images uploaded successfully. We will check your request within 24 hours.'); window.location.href='properties.php';</script>";
    } else {
        echo "<script>alert('Error saving property: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Submission Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            grid-column: span 2;
            padding: 10px;
            background-color: rgb(94, 211, 244);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(123, 211, 245);
        }

        .qr-code {
            grid-column: span 2;
            text-align: center;
            margin-top: 20px;
        }

        .qr-code img {
            max-width: 150px;
        }

        @media (max-width: 768px) {
            form {
                grid-template-columns: 1fr;
            }

            button {
                grid-column: span 1;
            }

            .qr-code {
                grid-column: span 1;
            }
        }
    </style>

     <script>//for fee
        function calculateFee() {
            let price = document.getElementById("price").value;
            let rentSale = document.querySelector('input[name="type"]:checked').value;
            let fee = 0;

            if (rentSale === "rent") {
                fee = price * 0.02;
            } else if (rentSale === "sale") {
                fee = price * 0.03;
            }

            document.getElementById("feeDisplay").innerText = "Fee: " + fee.toFixed(2)+" MMK" ;
        }
    </script>

<script>
    function validatePhone(input) {
        // Only allow numbers and limit to 11 digits (09 + 9 digits)
        input.value = input.value.replace(/\D/g, '').substr(0, 11);
        
        // Ensure it starts with 09
        if (input.value.length >= 2 && input.value.substr(0, 2) !== '09') {
            input.value = '09';
        }
    }
    </script>
</head>
<section>
    <div class="form-container">
        <h1>Property Form</h1>
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categoty">Type:</label>
                <select id="category" name="category" required>
                    <option value="apartment">Apartment</option>
                    <option value="condo">Condo</option>
                    <option value="house">House</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Enter location" required>
            </div>
            <div class="form-group">
                <label for="township">Township:</label>
                <select id="township" name="township" required>
                    <option value="Hlaing">Hlaing</option>
                    <option value="Lanmadaw">Lanmadaw</option>
                    <option value="Sanchaung">Sanchaung</option>
                    <option value="Kamaryut">Kamaryut</option>
                    <option value="Mayangone">Mayangone</option>
                    <option value="South Dagon">South Dagon</option>
                    <option value="North Dagon">North Dagon</option>
                    <option value="North Okkalapa">North Okkalapa</option>
                    <option value="South Okkalapa">South Okkalapa</option>
                    <option value="Kyi Myin Tine">Kyi Myin Tine</option>
                    <option value="Pazundaung">Pazundaung</option>
                    <option value="Bahan">Bahan</option>
                    <option value="Hlaing Tharyar">Hlaing Tharyar</option>

                </select>
            </div>
            <div class="form-group">
                <label for="size">Size:(sq ft)</label>
                <input type="number" id="size" name="size" placeholder="Enter size" min="0" max="1000000" required>
            </div>
            <div class="form-group">
                <label for="beds">Bedrooms:</label>
                <input type="number" id="beds" name="beds" min="0" max="50" required>
            </div>
            <div class="form-group">
                <label for="baths">Bathrooms:</label>
                <input type="number" id="baths" name="baths" min="0" max="50" required>
            </div>
           <div class="form-group">
                    <label for="price">Price:MMK(Lakh)</label>
                    <input type="number" id="price" name="price" placeholder="Enter price" required oninput="calculateFee()">
                </div>

            <div class="form-group">
    <label for="features">Features:</label>
    <textarea id="features" name="features" rows="4" placeholder="Enter property details" style="resize: vertical;" required></textarea>
</div>

<div class="form-group">
    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" placeholder="Enter description" style="resize: vertical;" required></textarea>
</div>
<div class="form-group">
                    <label for="type">Type:</label>
                    <label><input id="type" type="radio" name="type" value="rent" required onchange="calculateFee()"> For Rent</label>
                    <label><input id="type" type="radio" name="type" value="sale" onchange="calculateFee()"> For Sale</label>
                </div>
<div class="form-group">
           
<label for="phone">Phone No</label>
            <input type="text" id="phone" name="phone" pattern="09\d{7,9}" required oninput="validatePhone(this)" placeholder="09xxxxxxxxx">
 </div>

           
            <div class="form-group">
    <label for="image">Upload Images:</label>
    <input type="file" id="image1" name="image1" accept="image/*" required>
    <input type="file" id="image2" name="image2" accept="image/*" required>
    <input type="file" id="image3" name="image3" accept="image/*" required>
    <input type="file" id="image4" name="image4" accept="image/*" required>
</div>
<div class="qr-code">
                    <p>Scan QR Code for Payment : For rentals, we take a 2% service fee, and for sales, 3%.</p>
                    <img src="QR.jpg" alt="QR Code">
                    <p id="feeDisplay">Fee: 0</p>
                </div>


            <div class="form-group">
                <label for="transaction_img">Upload Payment Proof:</label>
                <input type="file" id="transaction_img" name="transaction_img" accept="image/*" required>
            </div>
            <button type="submit">Submit</button>
            </div>

        </form>
    </div>
</section>

</body>
</html>