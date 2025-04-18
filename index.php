<?php
session_start();
$lifetime = 60 * 60 * 48; // 48 hours in seconds
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
// If session is already set, redirect to chat
if (isset($_SESSION['room_id']) && isset($_SESSION['user_name'])) {
    header("Location: chat.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Join Chat Room</title>
</head>
<body>
    <h2>Join or Create Chat Room</h2>
    <form method="POST" action="join_room.php">
        <input type="text" name="name" placeholder="Your Name" required><br><br>
        <input type="text" name="room" placeholder="Room Name" required><br><br>
        <input type="password" name="password" placeholder="Room Password" required><br><br>
        <button type="submit">Enter Room</button>
    </form>
</body>
</html>
