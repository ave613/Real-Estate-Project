<?php
include("includes/header.php");
include("includes/topbar.php");
include("includes/sidebar.php");
include("connect.php");

$sql_approved = "SELECT COUNT(id) AS total_approved FROM property_details WHERE moderation_status = 'Approved'";
$result_approved = $conn->query($sql_approved);

$sql_pending = "SELECT COUNT(id) AS total_pending FROM property_details WHERE moderation_status = 'Pending'";
$result_pending = $conn->query($sql_pending);

$sql_rejected = "SELECT COUNT(id) AS total_rejected FROM property_details WHERE moderation_status = 'Rejected'";
$result_rejected = $conn->query($sql_rejected);

$sql_user = "SELECT COUNT(id) AS total_user FROM registered_users";
$result_user = $conn->query($sql_user);

$total_approved = 0;
$total_pending = 0;
$total_rejected = 0;
$total_user = 0;

if ($result_approved->num_rows > 0) {
    $row = $result_approved->fetch_assoc();
    $total_approved = $row['total_approved'];
}

if ($result_pending->num_rows > 0) {
    $row = $result_pending->fetch_assoc();
    $total_pending = $row['total_pending'];
}

if ($result_rejected->num_rows > 0) {
    $row = $result_rejected->fetch_assoc();
    $total_rejected = $row['total_rejected'];
}

if ($result_user->num_rows > 0) {
    $row = $result_user->fetch_assoc();
    $total_user = $row['total_user'];
}

$sql_categories = "
    SELECT category, moderation_status, COUNT(id) AS total 
    FROM property_details 
    WHERE category IN ('Condo', 'House', 'Apartment')
    GROUP BY category, moderation_status";
$result_categories = $conn->query($sql_categories);

$category_counts = [
    "Condo" => ["Approved" => 0, "Pending" => 0, "Rejected" => 0],
    "House" => ["Approved" => 0, "Pending" => 0, "Rejected" => 0],
    "Apartment" => ["Approved" => 0, "Pending" => 0, "Rejected" => 0],
];

if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $category = $row['category'];
        $status = $row['moderation_status'];
        $total = $row['total'];

        if (isset($category_counts[$category][$status])) {
            $category_counts[$category][$status] = $total;
        }
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"></ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!-- Approved Properties -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $total_approved; ?></h3>
                            <h4>Active Properties</h4>
                            <div id="approved-details" style="display: none; padding: 10px; margin-top: 10px;">
                                <p><?php echo "Apartment: ". $category_counts['Apartment']['Approved']; ?></p>
                                <p><?php echo "Condo: ". $category_counts['Condo']['Approved']; ?></p>
                                <p><?php echo "House: ". $category_counts['House']['Approved']; ?></p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer" onclick="toggleDetails('approved-details')">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Pending Properties -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $total_pending; ?></h3>
                            <h4>Pending Properties</h4>
                            <div id="pending-details" style="display: none; padding: 10px; margin-top: 10px;">
                                <p><strong>Apartment: </strong><?php echo $category_counts['Apartment']['Pending']; ?></p>
                                <p><strong>Condo: </strong><?php echo $category_counts['Condo']['Pending']; ?></p>
                                <p><strong>House: </strong><?php echo $category_counts['House']['Pending']; ?></p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer" onclick="toggleDetails('pending-details')">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Rejected Properties -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $total_rejected; ?></h3>
                            <h4>Rejected Properties</h4>
                            <div id="rejected-details" style="display: none; padding: 10px; margin-top: 10px;">
                                <p><?php echo "Apartment: ". $category_counts['Apartment']['Rejected']; ?></p>
                                <p><?php echo "Condo: ". $category_counts['Condo']['Rejected']; ?></p>
                                <p><?php echo "House: ". $category_counts['House']['Rejected']; ?></p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer" onclick="toggleDetails('rejected-details')">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- User Registrations -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $total_user; ?></h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="account.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Property Table -->
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Recently Added</h3>
                </div>
               
            </div>
            <section class="content">
                <div class="container-fluid">
                    <table id="propertiesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr style="background-color:white;">
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Beds</th>
                                <th>Baths</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Moderation</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT pd.id, pd.title, pd.category, pd.size, pd.beds, pd.baths, pd.price, pd.location, 
                                      pd.type, pd.moderation_status, pd.created_at, pd.phone, pd.user_email,
                                      (SELECT pi.image FROM property_images pi WHERE pi.property_id = pd.id LIMIT 1) AS image
                                      FROM property_details pd 
                                      ORDER BY pd.created_at DESC
                                      LIMIT 5";
                            $result = $conn->query($query);
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $imagePath = !empty($row['image']) ? "/Real%20Estate/MainPage/Img/" . $row['image'] : "No Image";
                            ?>
                                    <tr id="row-<?= $row['id']; ?>">
                                        <td><?= $row['id']; ?></td>
                                        <td>
                                            <?php if (!empty($row['image'])) { ?>
                                                <img src="<?= $imagePath; ?>" width="60" height="40" alt="Property Image">
                                            <?php } else { ?>
                                                <span class="text-muted">No Image</span>
                                            <?php } ?>
                                        </td>
                                        <td><?= $row['title']; ?></td>
                                        <td><span class='badge badge-warning'><?= $row['category']; ?></span></td>
                                        <td><?= $row['size']; ?></td>
                                        <td><?= $row['beds']; ?></td>
                                        <td><?= $row['baths']; ?></td>
                                        <td><?= $row['price']; ?></td>
                                        <td><?= $row['location']; ?></td>
                                        <td><?= $row['type']; ?></td>
                                        <td><?= $row['phone']; ?></td>
                                        <td style="max-width: 150px; word-wrap: break-word;"><?= htmlspecialchars($row['user_email']); ?></td>
                                        <td>
                                            <?php
                                            if ($row['moderation_status'] == 'Approved') {
                                                echo "<span class='badge badge-success'>Approved</span>";
                                            } elseif ($row['moderation_status'] == 'Pending') {
                                                echo "<span class='badge badge-warning'>Pending</span>";
                                            } else {
                                                echo "<span class='badge badge-danger'>Rejected</span>";
                                            }
                                            ?>
                                        </td>
                                        <td><?= $row['created_at']; ?></td>
                                       
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </section>
</div>

<script>
    function toggleDetails(id) {
        var detailsDiv = document.getElementById(id);
        if (detailsDiv.style.display === "none") {
            detailsDiv.style.display = "block"; // Show the details
        } else {
            detailsDiv.style.display = "none"; // Hide the details
        }
    }

</script>

<style>
    #propertiesTable th:nth-child(12),
    #propertiesTable td:nth-child(12) {
        max-width: 150px;
        white-space: normal;
        word-wrap: break-word;
        font-size: 14px;
        line-height: 1.2;
    }
</style>

<?php include("includes/footer.php"); ?>
