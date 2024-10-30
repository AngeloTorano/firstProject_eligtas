<?php
session_start();
include 'db.php';

$srcodes = [];
$role = 'all'; // Default value
$searchTerm = ''; // Variable to hold search term

// Pagination variables
$itemsPerPage = 10; // Set items per page

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected role and search term
    $role = isset($_POST['role']) ? $_POST['role'] : 'all'; 
    $searchTerm = isset($_POST['searchTerm']) ? trim($_POST['searchTerm']) : ''; 

    // Redirect to the first page with query parameters for role and search term
    header("Location: ?page=1&role=$role&searchTerm=" . urlencode($searchTerm));
    exit();
}

// Get the current page from GET, default to 1 if not set
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Get role and search term from GET parameters if available
$role = isset($_GET['role']) ? $_GET['role'] : 'all';
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

// Prepare SQL query based on the selected role and search term
$fetchSql = "SELECT COUNT(*) AS total FROM srcode WHERE 1=1";
$params = [];

if ($role !== 'all') {
    $fetchSql .= " AND role = ?";
    $params[] = $role;
}

if (!empty($searchTerm)) {
    $fetchSql .= " AND srCode LIKE ?";
    $params[] = "%$searchTerm%";
}

// Prepare statement for total count
$stmt = mysqli_prepare($conn, $fetchSql);

// Dynamically bind parameters for total count
if (!empty($params)) {
    $types = str_repeat("s", count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Execute the statement for total count
mysqli_stmt_execute($stmt);
$totalResult = mysqli_stmt_get_result($stmt);
$totalItems = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Fetch the records based on filters and pagination
$fetchSql = "SELECT * FROM srcode WHERE 1=1";

if ($role !== 'all') {
    $fetchSql .= " AND role = ?";
}

if (!empty($searchTerm)) {
    $fetchSql .= " AND srCode LIKE ?";
}

$fetchSql .= " LIMIT ?, ?";
$params = [];

if ($role !== 'all') {
    $params[] = $role;
}

if (!empty($searchTerm)) {
    $params[] = "%$searchTerm%";
}

$params[] = $offset;
$params[] = $itemsPerPage;

// Prepare statement for data fetch
$stmt = mysqli_prepare($conn, $fetchSql);

// Bind parameters for data fetch
if (!empty($params)) {
    $types = str_repeat("s", count($params) - 2) . "ii";
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Execute the statement
mysqli_stmt_execute($stmt);
$fetchResult = mysqli_stmt_get_result($stmt);

$srcodes = [];
if ($fetchResult) {
    while ($srcode = mysqli_fetch_assoc($fetchResult)) {
        $srcodes[] = $srcode;
    }
}

// Close the prepared statement
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
    <title>Document</title>
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
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="management.html">Management</a></li>
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
            <div><a class="link active" href="srcode.php">Sr-Code</a></div>
            <div><a class="link " href="hotline.php">Hotlines</a></div>
        </section>
    </center>

    <section class="main">
        <form class="form" method="POST" action="">
            <div class="form-group" style="width: 300px;">
                <select id="role" name="role" required>
                    <option value="all" <?php if ($role === 'all') echo 'selected'; ?>>All</option>
                    <option value="admin" <?php if ($role === 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="student" <?php if ($role === 'student') echo 'selected'; ?>>Student</option>      
                </select>
                <button type="submit" name="filter">Filter</button>
            </div>
            <div class="form-group" style="width: 300px;">
                <input type="text" name="searchTerm" placeholder="Search Sr-Code" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit" name="search">Search</button>
            </div>
            <div>
                <form class="addForm" action="" method="GET" onsubmit="return redirectToAddSrCode();">
                    <button style="width: 120px;" type="submit">Add Sr-Code</button>
                </form>
            </div>
        </form>

        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>

        <h1>SR-CODE</h1>
        <?php if (count($srcodes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Sr-Code</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($srcodes as $srcode): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($srcode['srCode']); ?></td>
                            <td><?php echo htmlspecialchars($srcode['role']); ?></td>
                            <td>
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this sr-code?');">
                                    <input type="hidden" name="srCode" value="<?php echo htmlspecialchars($srcode['srCode']); ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>No sr-codes found.</p>
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
        window.location.href = 'addSrCode.php';
        return false; // Prevent default form submission
    }
    return false; // Prevent default form submission if canceled
}
</script>

</body>
</html>
