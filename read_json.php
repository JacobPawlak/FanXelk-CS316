#!/usr/bin/php

<?php


	$sports_file = file_get_contents("Sports.json") or die ("That file does not exist in this directory");
	$json_array = json_decode($sports_file, true);

	var_dump($json_array);

	//echo json_last_error();
	echo;


?>
