<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_reminder";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $update_sql = "UPDATE tasks SET is_completed = 1 WHERE id = $task_id";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: mark_complete.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM tasks ORDER BY deadline ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 700px;
            background: white;
            padding: 20px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        h2 {
            margin-bottom: 15px;
            font-size: 22px;
            color: #333;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-finish {
            background-color: #28a745;
            color: white;
        }
        .btn-finish:hover {
            background-color: #218838;
        }
        .btn-back {
            margin-top: 15px;
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
        @media (max-width: 600px) {
            th, td {
                font-size: 13px;
                padding: 8px;
            }
            .btn-back {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Tugas</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row["task_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                    echo "<td>" . $row["deadline"] . "</td>";
                    echo "<td>" . ($row["is_completed"] ? "Selesai ✅" : "Belum ❌") . "</td>";
                    echo "<td>";
                    if (!$row["is_completed"]) {
                        echo "<a href='mark_complete.php?id=" . $row["id"] . "' class='btn btn-finish'>Selesai</a>";
                    } else {
                        echo "<span style='color: #28a745; font-weight: bold;'>✔</span>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <a href="index.php" class="btn btn-back">⬅ Kembali</a>
    </div>
</body>
</html>
