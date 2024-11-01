<?php
session_start();
require_once 'connect.php';

$user_id = $_SESSION['user']['id'];

$sql = "SELECT s.id, s.name, s.avatar FROM `servers` s JOIN `server_users` su ON s.id = su.server_id WHERE su.user_id = $user_id";
$result = mysqli_query($connect, $sql);

$servers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $servers[] = $row;
}

echo json_encode($servers);
?>
