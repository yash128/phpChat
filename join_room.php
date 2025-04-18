<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room = $_POST['room'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    // Check if room exists
    $stmt = $conn->prepare("SELECT id, room_password FROM rooms WHERE room_name = ?");
    $stmt->bind_param("s", $room);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($password === $row['room_password']) {
            $_SESSION['room_id'] = $row['id'];
            $_SESSION['user_name'] = $name;
            header("Location: chat.php");
        } else {
            echo "Wrong room password!";
        }
    } else {
        // Create new room
        $stmt = $conn->prepare("INSERT INTO rooms (room_name, room_password) VALUES (?, ?)");
        $stmt->bind_param("ss", $room, $password);
        $stmt->execute();
        $_SESSION['room_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $name;
        header("Location: chat.php");
    }
}
?>
