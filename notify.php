<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_reminder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tasks WHERE deadline <= NOW() AND is_completed = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<script>alert('Task: " . $row['task_name'] . " is due!');</script>";
    }
}
