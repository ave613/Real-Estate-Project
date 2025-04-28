<?php
include("includes/header.php");
include("includes/topbar.php");
include("includes/sidebar.php");
include("connect.php");
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex align-items-center">
                    <h1 class="m-0 text-dark mr-3">Properties</h1>
                    <div class="input-group w-50">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search ">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>                </div>
                <div class="col-sm-6">
                    <a href="/Real%20Estate/MainPage/addproperties.php" class="btn btn-info float-sm-right">+ Create Property</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Property Table -->
    <section class="content">
        <div class="container-fluid">
           
            <div class="">
                <table id="propertiesTable" class="table table-bordered table-striped">
                    <thead>
                        <tr style="background-color:white;">
                            <th onclick="sortTable(0)">ID <span id="icon0"></span></th>
                            <th>Image</th>
                            <th onclick="sortTable(2)">Title <span id="icon2"></span></th>
                            <th onclick="sortTable(3)">Category <span id="icon3"></span></th>
                            <th onclick="sortTable(4)">Size <span id="icon4"></span></th>
                            <th onclick="sortTable(5)">Beds <span id="icon5"></span></th>
                            <th onclick="sortTable(6)">Baths <span id="icon6"></span></th>
                            <th onclick="sortTable(7)">Price(Lakhs) <span id="icon7"></span></th>
                            <th onclick="sortTable(8)">Location <span id="icon8"></span></th>
                            <th onclick="sortTable(9)">Type <span id="icon9"></span></th>
                            <th onclick="sortTable(10)">Phone<span id="icon10"></span></th>
                            <th onclick="sortTable(11)">Email<span id="icon11"></span></th>
                            <th>Moderation</th>
                            <th onclick="sortTable(13)">Created At <span id="icon13"></span></th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $query = "SELECT pd.id, pd.title, pd.category, pd.size, pd.beds, pd.baths, pd.price, pd.location, 
                                pd.type, pd.moderation_status, pd.created_at, pd.phone, pd.user_email,
                                (SELECT pi.image FROM property_images pi WHERE pi.property_id = pd.id LIMIT 1) AS image
                                FROM property_details pd ORDER BY pd.id ASC";
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
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $imagePath = !empty($row['image']) ? "/Real%20Estate/MainPage/Img/" . $row['image'] : "No Image";
                                $currentStatus = $row['moderation_status'];
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
                                    <td><span class="badge badge-info"><?= $row['type']; ?></span></td>
                                    <td><?= $row['phone']; ?></td>
                                    <td style="max-width: 150px; word-wrap: break-word;"><?= htmlspecialchars($row['user_email']); ?></td>
                                    <td id="status-<?= $row['id']; ?>">
                                        <?php if ($currentStatus === "Pending") { ?>
                                            <span class="badge badge-warning">Pending</span>
                                        <?php } else { ?>
                                            <span class="badge badge-<?= $currentStatus === 'Approved' ? 'success' : 'danger'; ?>">
                                                <?= htmlspecialchars($currentStatus); ?>
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td><?= $row['created_at']; ?></td>
                                    <td>
                                        <a href="edit_property.php?id=<?= $row['id'] ?>" class="text-success mx-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_property.php?id=<?= $row['id'] ?>" class="text-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='13' class='text-center'>No properties found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#propertiesTable tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    let sortDirections = {}; // Store sorting directions per column

    function sortTable(columnIndex) {
        let table = document.getElementById("propertiesTable");
        let tbody = table.querySelector("tbody");
        let rows = Array.from(tbody.rows);
        let isAscending = !sortDirections[columnIndex]; // Toggle sorting order

        rows.sort((a, b) => {
            let aValue = a.cells[columnIndex].textContent.trim();
            let bValue = b.cells[columnIndex].textContent.trim();

            if (!isNaN(aValue) && !isNaN(bValue)) { // Compare as numbers if possible
                return isAscending ? aValue - bValue : bValue - aValue;
            }
            return isAscending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
        });

        // Remove existing rows and re-append sorted ones
        tbody.innerHTML = "";
        rows.forEach(row => tbody.appendChild(row));

        // Update sorting direction
        sortDirections[columnIndex] = isAscending;

        // Update icons
        document.querySelectorAll("thead th span").forEach(span => span.innerHTML = ""); // Clear all icons
        document.getElementById(`icon${columnIndex}`).innerHTML = isAscending ? " ▲" : " ▼";
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

<?php include("includes/footer.php"); ?>