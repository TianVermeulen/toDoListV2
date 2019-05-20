<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css">
    <title>toDO V2</title>
</head>
<body>
<?php
include_once 'connect.php';
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
        header('location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
}

$sql = "SELECT id, task, due FROM tasks";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<p id='p'>ID:" . $row["id"]."---->"."Task: " . $row["task"]."---->". "Due Date: " . $row["due"]."</p>";
        
    }
} else {
    echo "0 results";
}

if(isset($_POST['del'])){
    $del = $_POST['delT'];
    if($_POST['del']){
        $sql = "DELETE FROM tasks WHERE id=$del";
        if ($db->query($sql) === TRUE) {
            echo "Record deleted successfully <br>";
            header('location: index.php');
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
            header('location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }

    }
}

?>

</body>
</html>