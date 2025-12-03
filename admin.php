<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['role'] != 'admin') {
    header("location:index.php");
    exit;
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
    <p>All grading submissions will be displayed here.</p>
    
    <h3>Manage Judges</h3>
    <p>Judge management functionality will be available here.</p>
    
    <h3>Reports</h3>
    <p>Generate reports and statistics.</p>
</body>
</html>

