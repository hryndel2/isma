<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $avatar = $_FILES['avatar']['name'];
    $created_by = $_SESSION['user']['id'];

    // Загрузка аватара
    $target_dir = "avatars/";
    $target_file = $target_dir . basename($avatar);
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);

    // Создание сервера
    $sql = "INSERT INTO `servers` (`name`, `avatar`, `created_by`) VALUES ('$name', '$target_file', $created_by)";
    mysqli_query($connect, $sql);

    // Получение ID созданного сервера
    $server_id = mysqli_insert_id($connect);

    // Добавление создателя в список пользователей сервера
    $sql = "INSERT INTO `server_users` (`server_id`, `user_id`) VALUES ($server_id, $created_by)";
    mysqli_query($connect, $sql);

    // Создание основных каналов
    $channels = ['ОСНОВНОЙ', 'МЕМЫ'];
    foreach ($channels as $channel) {
        $sql = "INSERT INTO `channels` (`server_id`, `name`) VALUES ($server_id, '$channel')";
        mysqli_query($connect, $sql);
    }

    header('Location: ../servers.php');
}
?>
