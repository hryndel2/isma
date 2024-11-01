<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discord Registration</title>
    <style>
        body {
            background-image: url('styles/baground.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Arial', sans-serif;
            background-color: #404eed;
            /* Example Discord color */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            background-color: rgba(54, 57, 63, 0.8);
            /* Darker Discord color with opacity */
            border-radius: 8px;
            padding: 30px;
            backdrop-filter: blur(10px);
            /* Add blur effect */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            /* Add shadow */
            z-index: 0;
        }

		.logo {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin-right: -100px;
			opacity: 0.8; /* Add transparency */
			filter: blur(0.5px); /* Add blur effect */
		}

        .logo img {
            width: 75px;
            /* Adjust size as needed */
            height: auto;
        }

        .logo h2 {
            margin-top: 10px;
            font-weight: 700;
            color: #7289da;
            /* Discord purple */
        }

        .form-container {
            display: flex;
            flex-direction: column;
        }

        .logo-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-left: -228px;
            z-index: 1;
        }

        .form-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: white;
            /* White text */
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #7289da;
            /* Discord purple border */
            background-color: #2f3136;
            /* Dark background */
            color: white;
            /* White text */
        }

        button {
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #da7277;
            /* Discord purple */
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #974347;
            /* Darker purple on hover */
        }

        .legal {
            font-size: 12px;
            color: #72767d;
            /* Light gray text */
            margin-top: 20px;
            text-align: center;
        }

        .legal a {
            color: #da7277;
            /* Discord blue link */
            text-decoration: none;
        }
		.no-account {
			font-size: 14px;
			color: #72767d; /* Light gray text */
			margin-top: 20px;
			text-align: center;
		}

		.no-account a {
			color: #da7277; /* Discord blue link */
			text-decoration: none;
		}
    </style>
</head>

<body>
    <div class="logo-container">

    </div>
    <div class="container">
		<form action="vendor/signin.php" method="post">
			<div class="form-container">
				<h1>Войти в ISMA</h1>
				<input type="text" name="username_or_email" placeholder="Имя пользователя или адрес электронной почты">
				<input type="password" name="password" placeholder="Пароль">
				<button>Войти</button>
				<p class="no-account">Нет аккаунта? <a href="register.php">Пройти регистрацию</a></p>
			</div>
			<?php
			if (isset($_SESSION['message'])){
				echo ' <p class="msg"> '. $_SESSION['message'] .' </p>';
				unset ($_SESSION['message']);
			}
			?>
		</form>
    </div>
	
</body>

</html>