<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['room_id']) && isset($_SESSION['user_name'])) {
    $room_id = $_SESSION['room_id'];
    $name = $_SESSION['user_name'];
    $msg = trim($_POST['message']);

    if (!empty($msg)) {
        $stmt = $conn->prepare("INSERT INTO messages (room_id, sender_name, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $room_id, $name, $msg);
        $stmt->execute();
    }
}
?>
