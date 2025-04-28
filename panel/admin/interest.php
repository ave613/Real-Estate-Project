<?php
include("includes/header.php");
include("includes/topbar.php");
include("includes/sidebar.php");
include("connect.php");

$query = "
    SELECT 
        ii.id AS interest_id,
        ii.p_id AS property_id,  
        pd.title,
        pd.type,
        pd.category,
        COALESCE(pi.image, 'no-image.jpg') AS property_image,
        ii.firstname,
        ii.lastname,
        ii.email,
        ii.phone,
        ii.message,
        ii.created_at
    FROM insert_info ii
    JOIN property_details pd ON ii.p_id = pd.id 
    LEFT JOIN (
        SELECT property_id, MIN(id) AS first_image_id
        FROM property_images
        GROUP BY property_id
    ) first_images ON pd.id = first_images.property_id
    LEFT JOIN property_images pi ON pi.id = first_images.first_image_id  
";


$result = $conn->query($query);

// Debugging: Check if query executed
if (!$result) {
    die("Query Failed: " . $conn->error);
}

// Debugging: Check if there are rows
if ($result->num_rows === 0) {
    echo "<p style='color:red;'>No interests found. Check database.</p>";
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Users' Inquries</h1>
        </div>
    </div>

    <!-- Table -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table id="propertiesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Inquiry ID <span id="icon0"></span></th>
                                <th onclick="sortTable(1)">Title <span id="icon1"></span></th>
                                <th>Image</th>
                                <th onclick="sortTable(3)">Property ID <span id="icon3"></span></th>
                                <th onclick="sortTable(4)">Type <span id="icon4"></span></th>
                                <th onclick="sortTable(5)">Category <span id="icon5"></span></th>                       
                                <th onclick="sortTable(6)">First Name <span id="icon6"></span></th>
                                <th onclick="sortTable(7)">Last Name <span id="icon7"></span></th>
                                <th onclick="sortTable(8)">Email <span id="icon8"></span></th>
                                <th onclick="sortTable(9)">Phone <span id="icon9"></span></th>
                                <th onclick="sortTable(10)">Message <span id="icon10"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Ensure image path is correct
                                    $imagePath = !empty($row['property_image']) ? "/Real%20Estate/MainPage/Img/" . $row['property_image'] : "Img/no-image.jpg";
                            ?>
                                    <tr>

                                        <td><?= htmlspecialchars($row['interest_id']); ?></td>
                                        <td><?= htmlspecialchars($row['title']); ?></td>
                                        <td><img src="<?= htmlspecialchars($imagePath); ?>" width="60" height="40"></td>
                                        <td><?= htmlspecialchars($row['property_id']); ?></td>
                                        <td><?= htmlspecialchars($row['type']); ?></td>
                                        <td><?= htmlspecialchars($row['category']); ?></td>
                                        <td><?= htmlspecialchars($row['firstname']); ?></td>
                                        <td><?= htmlspecialchars($row['lastname']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['phone']); ?></td>
                                        <td><?= htmlspecialchars($row['message']); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No interests found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include("includes/footer.php"); ?>
// Add before closing </body> tag
<script>
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