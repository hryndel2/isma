<?php
session_start();
require_once 'connect.php';

$username_or_email = $_POST['username_or_email'];
$password = md5($_POST['password']);

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE (`email` = '$username_or_email' OR `nickname` = '$username_or_email') AND `password` = '$password'");

if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);

    $_SESSION['user'] = [
        "id" => $user['id'],
        "nickname" => $user['nickname'],
        "avatar" => $user['avatar'],
        "email" => $user['email']
    ];

    header('Location: ../servers.php');

} else {
    $_SESSION['message'] = 'Не верный логин или пароль';
    header('Location: ../login.php');
}
?>

<pre>
    <?php
    print_r($check_user);
    print_r($user);
    ?>
</pre>
