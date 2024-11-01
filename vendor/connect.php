<?php

	$connect = mysqli_connect('localhost', 'root', '', 'ismads');
	
	if (!$connect) {
		die('Error connect to DataBase');
	}