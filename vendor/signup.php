<?php

session_start();
require_once 'connect.php';

$nickname = $_POST['nickname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

if ($password === $password_confirm) {

    $password = md5($password);

    try {
        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = mysqli_query($connect, $sql);
        $count = mysqli_num_rows($result);

        if ($count == 0) {
            // Generate a Gravatar URL using the user's email address
            $avatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=200&d=robohash";

            mysqli_query($connect, "INSERT INTO `users` (`nickname`, `email`, `password`, `avatar`) VALUES ('$nickname', '$email', '$password', '$avatar')");

            header('Location: ../login.php');
        } else {
            $_SESSION['message'] = 'Почта уже зарегистрирована';
            header('Location: ../register.php');
        }

    } catch (mysqli_sql_exception $e) {
        header('Location: ../register.php');
    }

} else {
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../register.php');
}

?>