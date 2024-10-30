<?php
session_start();
include 'db.php';

$municipality = 'all'; // Default value
$searchTerm = ''; // Default search term

// Pagination settings
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Get municipality and search term from GET parameters
$municipality = isset($_GET['municipality']) ? $_GET['municipality'] : 'all';
$searchTerm = isset($_GET['searchTerm']) ? trim($_GET['searchTerm']) : '';

// Prepare SQL query for counting total items
$countSql = "SELECT COUNT(*) AS total FROM hotline WHERE 1=1";
$params = [];

if ($municipality !== 'all') {
    $countSql .= " AND municipality = ?";
    $params[] = $municipality;
}

if (!empty($searchTerm)) {
    $countSql .= " AND (municipality LIKE ? OR agency LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}

$stmt = mysqli_prepare($conn, $countSql);
if (!empty($params)) {
    $types = str_repeat("s", count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$totalItems = mysqli_fetch_assoc($result)['total'];
$totalPages = ceil($totalItems / $itemsPerPage);
mysqli_stmt_close($stmt);

// Prepare SQL query to fetch data
$dataSql = "SELECT * FROM hotline WHERE 1=1";
$params = [];

if ($municipality !== 'all') {
    $dataSql .= " AND municipality = ?";
    $params[] = $municipality;
}

if (!empty($searchTerm)) {
    $dataSql .= " AND (municipality LIKE ? OR agency LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}

$dataSql .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $itemsPerPage;

$stmt = mysqli_prepare($conn, $dataSql);
if (!empty($params)) {
    $types = str_repeat("s", count($params) - 2) . "ii";
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$fetchResult = mysqli_stmt_get_result($stmt);

$hotlines = [];
if ($fetchResult && mysqli_num_rows($fetchResult) > 0) {
    while ($hotline = mysqli_fetch_assoc($fetchResult)) {
        $hotlines[] = $hotline;
    }
}
mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <link rel="stylesheet" href="style/management/srcode.css">
    <title>Hotline Management</title>
</head>
<body>
    <section>
        <nav class="navbar">
            <div class="navbar-brand-container" style="gap: 1rem;">  
                <a class="navbar-brand" style="font-size: xx-large;" href="#">E-Ligtas</a>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="adminDashboard.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="adminProfile.html">Profile</a></li>
                <li class="nav-item"><a class="nav-link active" href="management.html">Management</a></li>
                <li class="nav-item"><a class="nav-link" href="announcement.html">Announcement</a></li>
                <li class="nav-item"><a class="nav-link" href="adminLog.html">Activity Log</a></li>
                <li class="nav-item"><a class="nav-link" href="" onclick="return confirmLogout()">Log out</a></li>
            </ul>
        </nav>
    </section>

    <center>
    <section class="management">
            <div><a class="link" href="studentAccounts.php">Student Accounts</a></div>
            <div><a class="link" href="adminAccounts.php">Admin Accounts</a></div>
            <div><a class="link" href="studentReports.php">Student Reports</a></div>
            <div><a class="link" href="srcode.php">Sr-Code</a></div>
            <div><a class="link active" href="hotline.php">Hotlines</a></div>
        </section>
    </center>

    <section class="main">
        <form class="form" method="GET" action="">
            <div class="form-group" style="width: 300px;">
                <select id="municipality" name="municipality" required>
                    <option value="all" <?php if ($municipality === 'all') echo 'selected'; ?>>All</option>
                    <option value="Lipa City" <?php if ($municipality === 'lipa city') echo 'selected'; ?>>Lipa City</option>
                    <option value="agoncillo" <?php if ($municipality === 'agoncillo') echo 'selected'; ?>>Agoncillo</option>
                    <option value="alitagtag" <?php if ($municipality === 'alitagtag') echo 'selected'; ?>>Alitagtag</option>
                    <option value="balayan" <?php if ($municipality === 'balayan') echo 'selected'; ?>>Balayan</option>
                    <option value="batangas city" <?php if ($municipality === 'batangas city') echo 'selected'; ?>>Batangas City</option>
                    <option value="balete" <?php if ($municipality === 'balete') echo 'selected'; ?>>Balete</option>
                    <option value="cuenca" <?php if ($municipality === 'cuenca') echo 'selected'; ?>>Cuenca</option>
                    <option value="lemery" <?php if ($municipality === 'lemery') echo 'selected'; ?>>Lemery</option> 
                    <option value="malvar" <?php if ($municipality === 'malvar') echo 'selected'; ?>>Malvar</option>
                    <option value="padre garcia" <?php if ($municipality === 'padre garcia') echo 'selected'; ?>>Padre Garcia</option>
                    <option value="rosario" <?php if ($municipality === 'rosario') echo 'selected'; ?>>Rosario</option>
                    <option value="san pascual" <?php if ($municipality === 'san pascual') echo 'selected'; ?>>San Pascual</option>
                    <option value="san juan" <?php if ($municipality === 'san juan') echo 'selected'; ?>>San Juan</option>
                    <option value="taal" <?php if ($municipality === 'taal') echo 'selected'; ?>>Taal</option>   
                </select>
                <button type="submit" name="filter">Filter</button>
            </div>
            <div class="form-group" style="width: 300px;">
                <input type="text" name="searchTerm" placeholder="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit" name="search">Search</button>
            </div>
        </form>

        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php 
            // Determine the range of pages to display
            $startPage = max(1, $currentPage - 1); // Start at current page - 1
            $endPage = min($totalPages, $currentPage + 1); // End at current page + 1

            // Adjust for edge cases
            if ($currentPage === 1) {
                $endPage = min(2, $totalPages); // Show page 1 and 2
            } elseif ($currentPage === $totalPages) {
                $startPage = max(1, $totalPages - 1); // Show last two pages
            }

            // Loop through the page numbers
            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>



        <h1>Hotlines</h1>
        <?php if (count($hotlines) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Municipality</th>
                        <th>Agency</th>
                        <th>Hotline Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hotlines as $hotline): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($hotline['municipality']); ?></td>
                            <td><?php echo htmlspecialchars($hotline['agency']); ?></td>
                            <td><?php echo htmlspecialchars($hotline['hotlineNumber']); ?></td>
                            <td>
                                <form action="editHotline.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="hotlineID" value="<?php echo htmlspecialchars($hotline['hotlineID']); ?>">
                                    <button type="submit">Edit</button>
                                </form>

                                <form action="deleteHotline.php" method="POST" style="display:inline;" 
                                    onsubmit="return confirm('Are you sure you want to delete this hotline?');">
                                    <input type="hidden" name="hotlineID" value="<?php echo htmlspecialchars($hotline['hotlineID']); ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No Hotline found.</p>
        <?php endif; ?>
    </section>

    
    <center>
        <footer class="footer" style="text-align: center; padding: 1rem 0;">
            <hr style="height: 0.2rem; background-color: rgb(253, 253, 253); width: 100%; border: none; margin: auto;"/>
            <p style="color: rgb(255, 255, 255); margin: 10px 0; font-size: small;">
                Copyright &copy; 2024 All rights reserved E-ligtas
            </p>
        </footer> 
    </center>

<script>
function redirectToAddSrCode() {
    if (confirm('Are you sure you want to add sr-code?')) {
        // If the user confirms, redirect to addSrCode.php
        window.location.href = 'addHotline.php';
        return false; // Prevent default form submission
    }
    return false; // Prevent default form submission if canceled
}
</script>


</body>
</html>
