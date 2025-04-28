<?php
include("includes/header.php");
include("includes/topbar.php");
include("includes/sidebar.php");
include("connect.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rowId = intval($_POST['row_id']);
    $status = isset($_POST['approve_button']) ? 'Approved' : (isset($_POST['reject_button']) ? 'Rejected' : null);

    if ($rowId && $status) {
        $stmt = $conn->prepare("UPDATE property_details SET moderation_status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $rowId);

        if ($stmt->execute()) {
            $successMessage = "Moderation status updated successfully!";
        } else {
            $errorMessage = "Failed to update moderation status!";
        }

        $stmt->close();
    } else {
        $errorMessage = "Invalid data provided!";
    }
}
// Fetch data for the table

$query = "
    SELECT 
        pd.id, 
        pd.title, 
        pd.size, 
        pd.beds, 
        pd.baths, 
        pd.price, 
        pd.location, 
        pd.type, 
        pd.moderation_status, 
        pd.created_at, 
        pd.phone,
        pd.user_email as email,
        (SELECT pi.image FROM property_images pi WHERE pi.property_id = pd.id LIMIT 1) AS image,
        pd.transaction_img
    FROM property_details pd
    ORDER BY pd.id ASC
";

// Add pagination logic
$records_per_page = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Modify the main query to include LIMIT and OFFSET
$query .= " LIMIT $records_per_page OFFSET $offset";

// Get total number of records for pagination
$total_records_query = "SELECT COUNT(*) as count FROM property_details";
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['count'];
$total_pages = ceil($total_records / $records_per_page);

// Execute the paginated query
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <style>
        .full-image-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            text-align: center;
            z-index: 1000;
        }

        .full-image {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.2);
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Add email column styles */
        #propertiesTable th:nth-child(11),
        #propertiesTable td:nth-child(11) {
            max-width: 150px;
            white-space: normal;
            word-wrap: break-word;
            font-size: 14px;
            line-height: 1.2;
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Transaction</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table id="propertiesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Size</th>
                                <th>Beds</th>
                                <th>Baths</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Transaction</th>
                                <th>Moderation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $imagePath = !empty($row['image']) ? "/Real%20Estate/MainPage/Img/" . $row['image'] : "";
                                    $transactionImagePath = !empty($row['transaction_img']) ? "/Real%20Estate/MainPage/" . $row['transaction_img'] : "";
                                    $currentStatus = $row['moderation_status'];
                            ?>

                            <tr id="row-<?= $row['id']; ?>">
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td>
                                    <?php if ($row['image']) { ?>
                                        <img src="<?= htmlspecialchars($imagePath); ?>" width="80" height="60" onclick="showImage(this)">
                                    <?php } else { ?>
                                        <span class="text-muted">No Image</span>
                                    <?php } ?>
                                </td>
                                <td><?= htmlspecialchars($row['title']); ?></td>
                                <td><?= htmlspecialchars($row['size']); ?></td>
                                <td><?= htmlspecialchars($row['beds']); ?></td>
                                <td><?= htmlspecialchars($row['baths']); ?></td>
                                <td><?= htmlspecialchars($row['price']); ?></td>
                                <td><?= htmlspecialchars($row['location']); ?></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($row['type']); ?></span></td>
                                <td><?= htmlspecialchars($row['phone']); ?></td>
                                <td style="max-width: 150px; word-wrap: break-word;"><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <?php if ($row['transaction_img']) { ?>
                                        <img src="<?= htmlspecialchars($transactionImagePath); ?>" width="60" height="80" onclick="showImage(this)">
                                    <?php } else { ?>
                                        <span class="text-muted">
                                            <?= ($row['id'] >= 1 && $row['id'] <= 50) ? 'Added by Admin' : 'No Image'; ?>
                                        </span>
                                    <?php } ?>
                                </td>
                                <td id="status-<?= $row['id']; ?>">
                                    <?php if ($currentStatus === "Pending") { ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="row_id" value="<?= $row['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-success" name="approve_button">Approve</button>
                                            <button type="submit" class="btn btn-sm btn-danger" name="reject_button">Reject</button>
                                        </form>
                                    <?php } else { ?>
                                        <span class="badge badge-<?= $currentStatus === 'Approved' ? 'success' : 'danger'; ?>">
                                            <?= htmlspecialchars($currentStatus); ?>
                                        </span>
                                    <?php } ?>
                                </td>
                            </tr>

                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='11' class='text-center'>No properties found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Full Image View -->
<div id="fullImageContainer" class="full-image-container" onclick="hideImage()">
    <span class="close-btn">&times;</span>
    <img id="fullImage" class="full-image">
</div>

<script>
    function showImage(imgElement) {
        const fullImageContainer = document.getElementById("fullImageContainer");
        const fullImage = document.getElementById("fullImage");

        fullImage.src = imgElement.src; // Set full image source
        fullImageContainer.style.display = "flex"; // Show full image
    }

    function hideImage() {
        document.getElementById("fullImageContainer").style.display = "none";
    }
</script>
</section>
</div>

<!-- Add pagination UI -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <div>
        <!-- Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> entries -->
    </div>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo ($page - 1); ?>">&laquo; Previous</a>
            </li>
        <?php endif; ?>

        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next &raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<!-- Add pagination styles -->
<style>
    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        padding: 0.5rem 0.75rem;
        color: #343A40;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #343A40;
        border-color: #343A40;
        color: white;
    }
</style>

<!-- Full Image View -->
<?php include("includes/footer.php"); ?>

</body>
</html>
