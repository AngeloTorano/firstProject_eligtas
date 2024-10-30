<?php
session_start();
include 'db.php';

$reports = [];
$type = 'all'; // Default value for type
$searchTerm = ''; // Variable to hold search term
$filterDate = ''; // Variable to hold filter date
$reportsPerPage = 10; // Number of reports per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected type, search term, and filter date
    $type = isset($_POST['type']) ? $_POST['type'] : 'all';
    $searchTerm = isset($_POST['searchTerm']) ? trim($_POST['searchTerm']) : '';
    $filterDate = isset($_POST['filterDate']) ? $_POST['filterDate'] : ''; // Get the filter date
}

// Prepare SQL query based on the selected type and search term
$fetchSql = "SELECT * FROM studentreport WHERE 1=1"; // Base query
if ($type !== 'all') {
    $fetchSql .= " AND disasterType = ?"; // Filtering by type of disaster
}

// Include the filter date in the SQL query if provided
if (!empty($filterDate)) {
    $fetchSql .= " AND DATE(date_reported) = ?"; // Searching by filter date
}

// Check if the search term is a valid date
if (isValidDate($searchTerm)) {
    $fetchSql .= " AND DATE(date_reported) = ?"; // Searching by date
} else {
    $fetchSql .= " AND (reportID LIKE ? OR Name LIKE ?)"; // Searching by reportID or Name
}

// Prepare statement
$stmt = mysqli_prepare($conn, $fetchSql);
if (!$stmt) {
    die('Prepare failed: ' . mysqli_error($conn)); // Error handling
}

// Initialize parameters array
$params = [];
if ($type !== 'all') {
    $params[] = $type; // Add type to parameters
}

// Add the filter date if provided
if (!empty($filterDate)) {
    $params[] = $filterDate; // Add filter date for filtering
}

if (isValidDate($searchTerm)) {
    $params[] = $searchTerm; // Add search date for filtering
} else {
    $searchTermForQuery = "%$searchTerm%"; // Add wildcards for LIKE search
    $params[] = $searchTermForQuery; // Add search term for reportID
    $params[] = $searchTermForQuery; // Add search term for Name
}

// Dynamically bind parameters
if ($params) {
    $types = str_repeat("s", count($params)); // Create type string for binding
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$fetchResult = mysqli_stmt_get_result($stmt);

// Get total number of reports for pagination
$totalReports = mysqli_num_rows($fetchResult);

// Calculate total pages
$totalPages = ceil($totalReports / $reportsPerPage);

// Adjust the query for pagination
$offset = ($currentPage - 1) * $reportsPerPage;
$fetchSql .= " LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $fetchSql);
if (!$stmt) {
    die('Prepare failed: ' . mysqli_error($conn));
}

// Add the offset and limit to parameters
$params[] = $offset; // Offset
$params[] = $reportsPerPage; // Limit
$types .= "ii"; // Append types for offset and limit
mysqli_stmt_bind_param($stmt, $types, ...$params);

// Execute the statement again for fetching reports
mysqli_stmt_execute($stmt);
$fetchResult = mysqli_stmt_get_result($stmt);

// Clear previous results
$reports = [];
if ($fetchResult) {
    while ($report = mysqli_fetch_assoc($fetchResult)) {
        $reports[] = $report; // Add fetched data to the array
    }
}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);

// Function to check if the input is a valid date
function isValidDate($dateString) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $dateString);
    return $dateTime && $dateTime->format('Y-m-d') === $dateString;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <link rel="stylesheet" href="style/management/studentReports.css">
    <title>Document</title>
</head>
<body>
    <section>
        <nav class="navbar">
            <div class="navbar-brand-container" style="gap: 1rem;">  
                <a class="navbar-brand" style="font-size: xx-large;" href="#">E-Ligtas</a>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="adminDashboard.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminProfile.html">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="management.html">Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="announcement.html">Announcement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminLog.html">Activity Log</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="" onclick="return confirmLogout()">Log out</a>
                </li>
            </ul>
        </nav>
    </section>
    <center>
        <section class="management">
            <div><a class="link" href="studentAccounts.php">Student Accounts</a></div>
            <div><a class="link" href="adminAccounts.php">Admin Accounts</a></div>
            <div><a class="link active" href="studentReports.php">Student Reports</a></div>
            <div><a class="link" href="srcode.php">Sr-Code</a></div>
            <div><a class="link " href="hotline.php">Hotlines</a></div>
        </section>
    </center>
    <section class="main">
        <form class="form" method="POST" action="">
            <div class="form-group" style="width: 300px;">
                <select id="type" name="type" required>
                    <option value="all" <?php if ($type === 'all') echo 'selected'; ?>>All</option>
                    <option value="earthquake" <?php if ($type === 'earthquake') echo 'selected'; ?>>Earthquake</option>
                    <option value="epidemics" <?php if ($type === 'epidemics') echo 'selected'; ?>>Epidemics</option>
                    <option value="fire" <?php if ($type === 'fire') echo 'selected'; ?>>Fire</option>
                    <option value="flood" <?php if ($type === 'flood') echo 'selected'; ?>>Flood</option>
                    <option value="landslide" <?php if ($type === 'landslide') echo 'selected'; ?>>Landslide</option>
                    <option value="tsunami" <?php if ($type === 'tsunami') echo 'selected'; ?>>Tsunami</option>
                    <option value="typhoon" <?php if ($type === 'typhoon') echo 'selected'; ?>>Typhoon</option>
                    <option value="volcanic" <?php if ($type === 'volcanic') echo 'selected'; ?>>Volcanic Eruption</option>
                </select>
                <button type="submit" name="filter">Filter</button>
            </div>
            
            <div class="form-group" style="width: 300px;">
                <input type="date" name="filterDate" placeholder="YYYY-MM-DD" value="<?php echo htmlspecialchars($filterDate); ?>">
                <button type="submit" name="filter">Date</button>
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

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
            
        <h1>Student Reports</h1>
        <?php if (count($reports) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type of Disaster</th>
                        <th>Contact Number</th>
                        <th>Location</th>
                        <th>Current Situation</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report['name']); ?></td>
                            <td><?php echo htmlspecialchars($report['disasterType']); ?></td>
                            <td><?php echo htmlspecialchars($report['contactNumber']); ?></td>
                            <td><?php echo htmlspecialchars($report['location']); ?></td>
                            <td><?php echo htmlspecialchars($report['situation']); ?></td>
                            <td><?php echo htmlspecialchars($report['date_reported']); ?></td>
                            <td>
                                <?php
                                // Check if the action field is NULL or not and set the status accordingly
                                if (is_null($report['action'])) {
                                    echo 'To Review';
                                } else {
                                    echo 'Reviewed';
                                }
                                ?>
                            </td>
                            <td>
                                <form action="reportdisplay.php" method="GET" onsubmit="return confirm('Are you sure you want to view this report?');">
                                    <input type="hidden" name="reportID" value="<?php echo htmlspecialchars($report['reportID']); ?>">
                                    <button type="submit">View</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No student report found.</p>
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
