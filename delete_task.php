<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_reminder";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_id'])) {
    $task_id = $conn->real_escape_string($_POST['task_id']);
    $sql = "DELETE FROM tasks WHERE id = '$task_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Tugas berhasil dihapus!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "'); window.location.href='index.php';</script>";
    }
}

$conn->close();
?>
