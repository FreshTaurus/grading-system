<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:index.php");
    exit;
}

require_once 'connect.php';

$message = '';
$message_type = '';

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['groupMembers'])) {
    $group_members = pg_escape_string($conn, $_POST['groupMembers']);
    $project_title = pg_escape_string($conn, $_POST['projectTitle']);
    $group_number = pg_escape_string($conn, $_POST['groupNumber']);
    $criteria1 = isset($_POST['criteria1']) ? pg_escape_string($conn, $_POST['criteria1']) : '';
    $criteria2 = isset($_POST['criteria2']) ? pg_escape_string($conn, $_POST['criteria2']) : '';
    $criteria3 = isset($_POST['criteria3']) ? pg_escape_string($conn, $_POST['criteria3']) : '';
    $criteria4 = isset($_POST['criteria4']) ? pg_escape_string($conn, $_POST['criteria4']) : '';
    $judge_name = pg_escape_string($conn, $_POST['judgeName']);
    $comments = isset($_POST['comments']) ? pg_escape_string($conn, $_POST['comments']) : '';
    
    $query = "INSERT INTO submissions (group_members, project_title, group_number, criteria1, criteria2, criteria3, criteria4, judge_name, comments) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
    
    $result = pg_query_params($conn, $query, array(
        $group_members,
        $project_title,
        $group_number,
        $criteria1,
        $criteria2,
        $criteria3,
        $criteria4,
        $judge_name,
        $comments
    ));
    
    if($result) {
        $message = "Submission saved successfully!";
        $message_type = "success";
        // Clear form by redirecting
        header("location:loginsuccess.php?success=1");
        exit;
    } else {
        $message = "Error saving submission: " . pg_last_error($conn);
        $message_type = "error";
    }
}

// Check for success message from redirect
if(isset($_GET['success'])) {
    $message = "Submission saved successfully!";
    $message_type = "success";
}
?>
<!DOCTYPE HTML>

<html>
<head>
    <title>Computer Science Project - Grading Rubric</title>
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
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Judge) | <a href="index.php?logout=1">Logout</a></p>
    
    <h1>Computer Science Project</h1>
    
    <?php if($message): ?>
        <p style="color: <?php echo $message_type == 'success' ? 'green' : 'red'; ?>;">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>
    
    <form method="POST" action="">
        <p>Group Members: <input type="text" id="groupMembers" name="groupMembers" required></p>
        
        <p>Project Title: <input type="text" id="projectTitle" name="projectTitle" required></p>
        
        <p>Group Number: <input type="text" id="groupNumber" name="groupNumber" required></p>
        
        <table>
            <tr>
                <th>Criteria</th>
                <th>Developing (0-10)</th>
                <th>Accomplished (11-15)</th>
            </tr>
            <tr>
                <td>Articulate requirements</td>
                <td><input type="radio" name="criteria1" value="developing"></td>
                <td><input type="radio" name="criteria1" value="accomplished"></td>
            </tr>
            <tr>
                <td>Choose appropriate tools and methods for each task</td>
                <td><input type="radio" name="criteria2" value="developing"></td>
                <td><input type="radio" name="criteria2" value="accomplished"></td>
            </tr>
            <tr>
                <td>Give clear and coherent oral presentation</td>
                <td><input type="radio" name="criteria3" value="developing"></td>
                <td><input type="radio" name="criteria3" value="accomplished"></td>
            </tr>
            <tr>
                <td>Functioned well as a team</td>
                <td><input type="radio" name="criteria4" value="developing"></td>
                <td><input type="radio" name="criteria4" value="accomplished"></td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td colspan="2"></td>
            </tr>
        </table>
        
        <p>Judge's name: <input type="text" id="judgeName" name="judgeName" required></p>
        
        <p>Comments:<br>
        <textarea id="comments" name="comments" rows="4" cols="50"></textarea></p>
        
        <p><input type="submit" value="Submit"></p>
    </form>
</body>
</html>

