<!DOCTYPE html>
<html>

<!--Chelsea Kuball and Jacob Pawlak
    CS316 Project 4 - FanXelk
    November 18th, 2017
 -->

<head>

        <title>Chelsea Kuball and Jacob Pawlak P4 CS316</title>

</head>

<body>

	<p style="font-size: 30px; color: black; text-align: center">CS316 Chelsea Kuball and Jacob Pawlak | Project 4</p>

	<?php
		$sports_file = file_get_contents("Sports.json") or die ("That file does not exist in this directory");
        	$json_array = json_decode($sports_file, true);
        	var_dump($json_array);
        	//echo json_last_error();
	?>

	<form action="" method="get">

		<label for="title"> </label>
		<input id="title">
		<label for="results"> </label>
		<input id="results">
		<label for="searchterms"> </label>
		<input id="searchterms">

		<input type="submit" value="Submit">

	</form>

	<?php
		var_dump($json_array);
	?>

</body>

</html>
