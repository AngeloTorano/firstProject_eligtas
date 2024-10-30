<?php
session_start();
include 'db.php';

$students = [];
$searchTerm = ''; // Variable to hold search term
$studentsPerPage = 10; // Number of students per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL

// Ensure current page is at least 1
$currentPage = max(1, $currentPage);

// Handle search
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get search term
    $searchTerm = isset($_POST['searchTerm']) ? trim($_POST['searchTerm']) : '';
}

// Prepare base SQL query
$searchTermForQuery = '';
$fetchSql = "SELECT * FROM studentinfo";

if (!empty($searchTerm)) {
    $searchTermForQuery = "%" . $searchTerm . "%";
    $fetchSql .= " WHERE srCode LIKE ? OR firstName LIKE ? OR lastName LIKE ?";
}

// Prepare statement to get total number of students for pagination
$totalCountSql = $fetchSql;
$totalCountStmt = mysqli_prepare($conn, $totalCountSql);

if ($totalCountStmt) {
    if (!empty($searchTerm)) {
        mysqli_stmt_bind_param($totalCountStmt, "sss", $searchTermForQuery, $searchTermForQuery, $searchTermForQuery);
    }
    mysqli_stmt_execute($totalCountStmt);
    $fetchResult = mysqli_stmt_get_result($totalCountStmt);
    $totalStudents = mysqli_num_rows($fetchResult); // Count total students
    mysqli_stmt_close($totalCountStmt);
} else {
    echo "Error preparing total count statement: " . mysqli_error($conn);
}

// Calculate total pages
$totalPages = ceil($totalStudents / $studentsPerPage);
$offset = ($currentPage - 1) * $studentsPerPage;

// Add LIMIT clause for pagination
$fetchSql .= " LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $fetchSql);

if ($stmt) {
    // Bind parameters for LIMIT
    if (empty($searchTerm)) {
        mysqli_stmt_bind_param($stmt, "ii", $offset, $studentsPerPage);
    } else {
        mysqli_stmt_bind_param($stmt, "ssii", $searchTermForQuery, $searchTermForQuery, $searchTermForQuery, $offset, $studentsPerPage);
    }

    // Execute the statement for fetching students
    mysqli_stmt_execute($stmt);
    $fetchResult = mysqli_stmt_get_result($stmt);

    if ($fetchResult) {
        while ($student = mysqli_fetch_assoc($fetchResult)) {
            $students[] = $student; // Add fetched data to the array
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <link rel="stylesheet" href="style/management/studentAccounts.css">
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
            <div><a class="link active" href="studentAccounts.php">Student Accounts</a></div>
            <div><a class="link" href="adminAccounts.php">Admin Accounts</a></div>
            <div><a class="link" href="studentReports.php">Student Reports</a></div>
            <div><a class="link" href="srcode.php">Sr-Code</a></div>
            <div><a class="link " href="hotline.php">Hotlines</a></div>
        </section>
    </center>
    <section class="main">
        <form class="form" method="POST" action="">
            <div class="form-group" style="width: 300px;">
                <input type="text" name="searchTerm" placeholder="Search Sr-Code" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit" name="search">Search</button> <!-- Search button -->
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

        <h1>Student Account Information</h1>
        <?php if (count($students) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>SR Code</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact Number</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['srCode']); ?></td>
                            <td><?php echo htmlspecialchars($student['firstName']); ?></td>
                            <td><?php echo htmlspecialchars($student['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($student['address']); ?></td>
                            <td><?php echo htmlspecialchars($student['age']); ?></td>
                            <td><?php echo htmlspecialchars($student['gender']); ?></td>
                            <td><?php echo htmlspecialchars($student['contactNumber']); ?></td>
                            <td><?php echo htmlspecialchars($student['pass']); ?></td>
                            <td>
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                    <input type="hidden" name="srCode" value="<?php echo htmlspecialchars($student['srCode']); ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        <?php else: ?>
            <p>No student accounts found.</p>
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
