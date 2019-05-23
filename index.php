<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'todo';


$db = mysqli_connect($servername, $username, $password, $database);

if(!$db){
    die("Connection failed: " . mysqli_connect_error());
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php

$errors = "";
$sql = "CREATE TABLE tasks (
    id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    due DATE NOT NULL)";

// if(mysqli_query($db, $sql)){
//     echo '<p>Table film created succesffully. </p>';
//     header('location: index.php');
// }else{
//     echo '<p> Error creating table: ' . mysqli_error($db) . "</p>";
// }




?>
<form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <label for="task" id="label">Task:</label>
	<input type="text" name="task" >
    <label for="due" id="label">Due Date:</label>
<input type="date" id="due" name="due" min="2019-01-01" max="2020-01-01" value="" >
	<input type="submit" name="submit">
    <br>
    <label for="del" id="label">Delete ID:</label>
	<input type="number" name="delT">
    <input type="submit" name="del">
    <br>
    <label for="del" id="label">Update ID:</label>
	<input type="number" name="upT">
    <label for="uTask" id="label">New Task:</label>
	<input type="text" name="uTask">
    <label for="uDate" id="label">New Date:</label>
	<input type="date" name="uDate" min="2019-01-01" max="2020-01-01" value="" >
    <input type="submit" name="update">
  

    
</form>

    
<?php


if(isset($_POST['submit'])){
    $submit = $_POST['submit'];
    if($submit){
    
    $task = $_POST['task'];
    $due = $_POST['due'];


    $sql = "INSERT INTO tasks (task, due) VALUES ('$task','$due')";
    if ($db->query($sql) === TRUE) {
        echo "New record created successfully <br>";
        header("location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
}

$sql = "SELECT id, task, due FROM tasks ORDER BY task ASC";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<p id='p'>ID:" . $row["id"]."---->"."Task: " . $row["task"]."---->". "Due Date: " . $row["due"]."</p>";
        
    }
} 
    

    

if(isset($_POST['del'])){
    $del = $_POST['delT'];
    if($_POST['del']){
        $sql = "DELETE FROM tasks WHERE id=$del";
        if ($db->query($sql) === TRUE) {
            echo "Record deleted successfully <br>";
            header("location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }
}

if(isset($_POST['update'])){
    $uTask = $_POST['uTask'];
    $uDate = $_POST['uDate'];
    $upT = $_POST['upT'];

    if($_POST['update']){
        $sql = "UPDATE tasks SET task='$uTask', due='$uDate' WHERE id=$upT";
        if ($db->query($sql) === TRUE) {
            echo "Record updated successfully <br>";
            header("location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }

    }
}

?>


<br>

    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>