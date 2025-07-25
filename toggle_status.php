<?php
header('Content-Type: application/json');

$mysqli = new mysqli("localhost", "root", "", "info");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $result = $mysqli->query("SELECT status FROM user WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newStatus = $row['status'] == 1 ? 0 : 1;
        $mysqli->query("UPDATE user SET status = $newStatus WHERE id = $id");

        echo json_encode(["success" => true, "new_status" => $newStatus]);
        exit;
    }
}

echo json_encode(["success" => false]);
