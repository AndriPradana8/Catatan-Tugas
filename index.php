<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_reminder";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tambah task baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_name'], $_POST['description'], $_POST['deadline'])) {
    $task_name = $conn->real_escape_string($_POST['task_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $deadline = date('Y-m-d H:i:s', strtotime($_POST['deadline'])); // Format datetime
    
    $sql = "INSERT INTO tasks (task_name, description, deadline) VALUES ('$task_name', '$description', '$deadline')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New task created successfully'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Ambil data tugas
$sql = "SELECT * FROM tasks ORDER BY deadline";
$result = $conn->query($sql);

// Cek dan tampilkan notifikasi
include 'notify.php';

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Tugas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Tugasku</h1>
        <form method="POST">
            <input type="text" name="task_name" placeholder="Mata Kuliah" required>
            <textarea name="description" placeholder="Deskripsi Tugas" required></textarea>
            <input type="datetime-local" name="deadline" required>
            <button type="submit">Tambah Tugas</button>
        </form>
        <button onclick="window.location.href='mark_complete.php'" style="width: 100%; margin-top: 10px; background-color: #007bff;">Lihat Tugas</button>
        <div class="task-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $task_class = $row['is_completed'] ? 'completed' : '';
                    echo "<div class='task-item $task_class'>";
                    echo "<div>";
                    echo "<strong>" . htmlspecialchars($row['task_name']) . "</strong><br>";
                    echo "<em>" . htmlspecialchars($row['description']) . "</em><br>";
                    echo "Deadline: " . htmlspecialchars($row['deadline']);
                    echo "</div>";
                    if (!$row['is_completed']) {
                        echo "<form method='POST' action='mark_complete.php' style='display:inline;'>";
                        echo "<input type='hidden' name='task_id' value='".$row['id']."'>";
                        echo "<button type='submit'>Done</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<div class='task-item'></div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
