<?php
session_start();
include 'db.php';

$admins = [];
$searchTerm = ''; // Variable to hold search term
$adminsPerPage = 10; // Number of admins per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL

// Ensure current page is at least 1
$currentPage = max(1, $currentPage);

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['srCode'])) {
    $srCode = mysqli_real_escape_string($conn, $_POST['srCode']);

    // Prepare the delete query
    $deleteSql = "DELETE FROM admininfo WHERE srCode = ?";
    $stmt = mysqli_prepare($conn, $deleteSql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $srCode);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Admin account deleted successfully.";
        } else {
            $_SESSION['errorMessage'] = "Error deleting admin account: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['errorMessage'] = "Error preparing delete statement: " . mysqli_error($conn);
    }

    // Redirect back to the admin accounts page
    header("Location: adminAccounts.php");
    exit();
}

// Search and pagination logic
$fetchSql = "SELECT * FROM admininfo";
$searchTermForQuery = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchTerm'])) {
    $searchTerm = trim($_POST['searchTerm']);
    if (!empty($searchTerm)) {
        $fetchSql .= " WHERE srCode LIKE ? OR fName LIKE ? OR lName LIKE ?";
        $searchTermForQuery = "%" . $searchTerm . "%";
    }
}

// Get total number of admins for pagination
$totalAdminsStmt = mysqli_prepare($conn, $fetchSql);
if ($totalAdminsStmt) {
    if (!empty($searchTerm)) {
        mysqli_stmt_bind_param($totalAdminsStmt, "sss", $searchTermForQuery, $searchTermForQuery, $searchTermForQuery);
    }
    mysqli_stmt_execute($totalAdminsStmt);
    $fetchResult = mysqli_stmt_get_result($totalAdminsStmt);
    $totalAdmins = mysqli_num_rows($fetchResult);
    mysqli_stmt_close($totalAdminsStmt);
}

// Calculate total pages
$totalPages = ceil($totalAdmins / $adminsPerPage);
$offset = ($currentPage - 1) * $adminsPerPage;
$fetchSql .= " LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $fetchSql);

if ($stmt) {
    if (!empty($searchTerm)) {
        // When there's a search term, bind 5 parameters: 3 for search, 2 for LIMIT
        mysqli_stmt_bind_param($stmt, "ssii", $searchTermForQuery, $searchTermForQuery, $searchTermForQuery, $offset, $adminsPerPage);
    } else {
        // When there's no search term, bind 2 parameters: 2 for LIMIT
        mysqli_stmt_bind_param($stmt, "ii", $offset, $adminsPerPage);
    }

    // Execute the statement for fetching admins
    mysqli_stmt_execute($stmt);
    $fetchResult = mysqli_stmt_get_result($stmt);

    if ($fetchResult) {
        while ($admin = mysqli_fetch_assoc($fetchResult)) {
            $admins[] = $admin; // Add fetched data to the array
        }
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/management/adminAccounts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <title>Admin Accounts</title>
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
            <div><a class="link active" href="adminAccounts.php">Admin Accounts</a></div>
            <div><a class="link" href="studentReports.php">Student Reports</a></div>
            <div><a class="link" href="srcode.php">Sr-Code</a></div>
            <div><a class="link" href="hotline.php">Hotlines</a></div>
        </section>
    </center>

    <section class="main">
        <form class="form" method="POST" action="">
            <div class="form-group" style="width: 300px;">
                <input type="text" name="searchTerm" placeholder="Search Sr-Code" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit" name="search">Search</button>
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

        <h1>Admin Account Information</h1>
        <?php if (count($admins) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>SR Code</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Position</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact Number</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admin['srCode']); ?></td>
                            <td><?php echo htmlspecialchars($admin['fName']); ?></td>
                            <td><?php echo htmlspecialchars($admin['lName']); ?></td>
                            <td><?php echo htmlspecialchars($admin['position']); ?></td>
                            <td><?php echo htmlspecialchars($admin['age']); ?></td>
                            <td><?php echo htmlspecialchars($admin['gender']); ?></td>
                            <td><?php echo htmlspecialchars($admin['contactNumber']); ?></td>
                            <td><?php echo htmlspecialchars($admin['pass']); ?></td>
                            <td>
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                    <input type="hidden" name="srCode" value="<?php echo htmlspecialchars($admin['srCode']); ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No admin accounts found.</p>
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
</body>
</html>
