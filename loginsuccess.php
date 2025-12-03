<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:index.php");
    exit;
}

try {
    require_once 'connect.php';
} catch(Exception $e) {
    // Database connection failed - show error page
    die("<!DOCTYPE HTML><html><head><title>Database Error</title></head><body><h1>Database Connection Error</h1><pre>" . htmlspecialchars($e->getMessage()) . "</pre></body></html>");
}

$message = '';
$message_type = '';

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['groupMembers'])) {
    try {
        $group_members = $_POST['groupMembers'];
        $project_title = $_POST['projectTitle'];
        $group_number = $_POST['groupNumber'];
        // Criteria values are individual numeric scores chosen by the judge
        $criteria1 = isset($_POST['criteria1']) ? (int)$_POST['criteria1'] : 0;
        $criteria2 = isset($_POST['criteria2']) ? (int)$_POST['criteria2'] : 0;
        $criteria3 = isset($_POST['criteria3']) ? (int)$_POST['criteria3'] : 0;
        $criteria4 = isset($_POST['criteria4']) ? (int)$_POST['criteria4'] : 0;
        $judge_name = $_POST['judgeName'];
        $comments = isset($_POST['comments']) ? $_POST['comments'] : '';

        // Total score is the sum of the individual numeric scores
        $score1 = $criteria1;
        $score2 = $criteria2;
        $score3 = $criteria3;
        $score4 = $criteria4;
        $total_score = $score1 + $score2 + $score3 + $score4;
        
        $query = "INSERT INTO submissions (group_members, project_title, group_number, criteria1, criteria2, criteria3, criteria4, judge_name, comments) 
                  VALUES (:group_members, :project_title, :group_number, :criteria1, :criteria2, :criteria3, :criteria4, :judge_name, :comments)";
        
        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            ':group_members' => $group_members,
            ':project_title' => $project_title,
            ':group_number' => $group_number,
            ':criteria1' => $criteria1,
            ':criteria2' => $criteria2,
            ':criteria3' => $criteria3,
            ':criteria4' => $criteria4,
            ':judge_name' => $judge_name,
            ':comments' => $comments
        ));
        
        // Store the judge's total score in the session so it can be shown after redirect
        $_SESSION['last_total_score'] = $total_score;

        $message = "Submission saved successfully!";
        $message_type = "success";
        // Clear form by redirecting
        header("location:loginsuccess.php?success=1");
        exit;
    } catch(PDOException $e) {
        $message = "Error saving submission: " . $e->getMessage();
        $message_type = "error";
    }
}

// Check for success message from redirect
if(isset($_GET['success'])) {
    if(isset($_SESSION['last_total_score'])) {
        $message = "Submission saved successfully! Total score: " . (int)$_SESSION['last_total_score'];
        unset($_SESSION['last_total_score']);
    } else {
        $message = "Submission saved successfully!";
    }
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
                <td>
                    <?php for($i = 0; $i <= 10; $i++): ?>
                        <label>
                            <input type="radio" name="criteria1" value="<?php echo $i; ?>" <?php echo $i === 0 ? 'required' : ''; ?>>
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
                <td>
                    <?php for($i = 11; $i <= 15; $i++): ?>
                        <label>
                            <input type="radio" name="criteria1" value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
            </tr>
            <tr>
                <td>Choose appropriate tools and methods for each task</td>
                <td>
                    <?php for($i = 0; $i <= 10; $i++): ?>
                        <label>
                            <input type="radio" name="criteria2" value="<?php echo $i; ?>" <?php echo $i === 0 ? 'required' : ''; ?>>
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
                <td>
                    <?php for($i = 11; $i <= 15; $i++): ?>
                        <label>
                            <input type="radio" name="criteria2" value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
            </tr>
            <tr>
                <td>Give clear and coherent oral presentation</td>
                <td>
                    <?php for($i = 0; $i <= 10; $i++): ?>
                        <label>
                            <input type="radio" name="criteria3" value="<?php echo $i; ?>" <?php echo $i === 0 ? 'required' : ''; ?>>
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
                <td>
                    <?php for($i = 11; $i <= 15; $i++): ?>
                        <label>
                            <input type="radio" name="criteria3" value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
            </tr>
            <tr>
                <td>Functioned well as a team</td>
                <td>
                    <?php for($i = 0; $i <= 10; $i++): ?>
                        <label>
                            <input type="radio" name="criteria4" value="<?php echo $i; ?>" <?php echo $i === 0 ? 'required' : ''; ?>>
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
                <td>
                    <?php for($i = 11; $i <= 15; $i++): ?>
                        <label>
                            <input type="radio" name="criteria4" value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </td>
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

