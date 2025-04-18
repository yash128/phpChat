<?php
include 'db.php';

if (isset($_SESSION['room_id'])) {
    $room_id = $_SESSION['room_id'];

    $stmt = $conn->prepare("SELECT sender_name, message, timestamp FROM messages WHERE room_id = ? ORDER BY id ASC");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
}
?>
