<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['role'] != 'admin') {
    header("location:index.php");
    exit;
}

require_once 'connect.php';

// Fetch all submissions
$query = "SELECT * FROM submissions ORDER BY created_at DESC";
try {
    $stmt = $conn->query($query);
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error fetching submissions: " . $e->getMessage();
    $submissions = array();
}
?>
<!DOCTYPE HTML>

<html>
<head>
    <title>Administrator Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Administrator Dashboard</h1>
    
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Administrator)</p>
    
    <p><a href="index.php?logout=1">Logout</a></p>
    
    <hr>
    
    <h2>System Management</h2>
    
    <h3>View All Submissions</h3>
    
    <?php if(isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php elseif(!empty($submissions)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Group Members</th>
                <th>Project Title</th>
                <th>Group Number</th>
                <th>Criteria 1</th>
                <th>Criteria 2</th>
                <th>Criteria 3</th>
                <th>Criteria 4</th>
                <th>Judge Name</th>
                <th>Comments</th>
                <th>Submitted At</th>
            </tr>
            <?php foreach($submissions as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['group_members']); ?></td>
                    <td><?php echo htmlspecialchars($row['project_title']); ?></td>
                    <td><?php echo htmlspecialchars($row['group_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['criteria1']); ?></td>
                    <td><?php echo htmlspecialchars($row['criteria2']); ?></td>
                    <td><?php echo htmlspecialchars($row['criteria3']); ?></td>
                    <td><?php echo htmlspecialchars($row['criteria4']); ?></td>
                    <td><?php echo htmlspecialchars($row['judge_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['comments']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p><strong>Total Submissions: <?php echo count($submissions); ?></strong></p>
    <?php else: ?>
        <p>No submissions found.</p>
    <?php endif; ?>
    
    <h3>Manage Judges</h3>
    <p>Judge management functionality will be available here.</p>
    
    <h3>Reports</h3>
    <p>Generate reports and statistics.</p>
</body>
</html>

