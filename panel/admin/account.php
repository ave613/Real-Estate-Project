<?php
include("includes/header.php");
include("includes/topbar.php");
include("includes/sidebar.php");
include("connect.php");

// Fetch user data
$query = "SELECT id, firstName, lastName, email, phone, created_at FROM registered_users";
$result = $conn->query($query);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex align-items-center">
                    <h1 class="m-0 text-dark mr-3">Registered Accounts</h1>
                    <div class="input-group w-50">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table id="usersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">ID <span id="icon0"></span></th>
                                <th onclick="sortTable(1)">First Name <span id="icon1"></span></th>
                                <th onclick="sortTable(2)">Last Name <span id="icon2"></span></th>
                                <th onclick="sortTable(3)">Email <span id="icon3"></span></th>
                                <th onclick="sortTable(4)">Phone <span id="icon4"></span></th>
                                <th onclick="sortTable(5)">Created At <span id="icon5"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']); ?></td>
                                        <td><?= htmlspecialchars($row['firstName']); ?></td>
                                        <td><?= htmlspecialchars($row['lastName']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['phone']); ?></td>
                                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No users found</td></tr>";
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
        let table = document.getElementById("usersTable");
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

<!-- Add this before the existing sortTable script -->
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#usersTable tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
