<!DOCTYPE HTML>
<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:index.php");
    exit;
}
?>

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
    <h1>Computer Science Project</h1>
    
    <form method="POST" action="">
        <p>Group Members: <input type="text" id="groupMembers" name="groupMembers"></p>
        
        <p>Project Title: <input type="text" id="projectTitle" name="projectTitle"></p>
        
        <p>Group Number: <input type="text" id="groupNumber" name="groupNumber"></p>
        
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
        
        <p>Judge's name: <input type="text" id="judgeName" name="judgeName"></p>
        
        <p>Comments:<br>
        <textarea id="comments" name="comments" rows="4" cols="50"></textarea></p>
        
        <p><input type="submit" value="Submit"></p>
    </form>
</body>
</html>

