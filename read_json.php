#!/usr/bin/php

<?php


	$sports_file = file_get_contents("Sports.json") or die ("That file does not exist in this directory");
	$sport_array = json_decode($sports_file, true);

	$sport_jsons = array();
	$global_sports = array();
	$global_searchterms = array();

	//var_dump($sport_array);

	foreach ($sport_array as $key => $value) {

		//var_dump($value);
		//echo "Key = " . (string)$key . "Value = " . (string)$value;

		foreach ($value as $array_num => $title) {
			//echo "array_num = " . $array_num . " title = " . $title;
			//var_dump($title);
			//echo "sport = " . $title["title"];
			$sport_name = $title["title"];
			if (!in_array($sport_name, $global_sports)) {
					array_push($global_sports, $sport_name);
			}
			$years = $title["results"];
			$search_terms = $title["searchterms"];
			
			//var_dump($years);

			foreach ($years as $sport => $sport_name) {
				//echo "sport = " . $sport . " sport_name = " . $sport_name;
				//var_dump($sport_name);
				//var_dump($years);
				//var_dump($sport_name);
				//echo "json file = $sport_name \n";
				array_push($sport_jsons, $sport_name);
			}
			//echo "\n\n";

			foreach ($search_terms as $term => $term_name) {
				//var_dump($term_name);
				//echo "searchterm = $term_name \n";
				if (!in_array($term_name, $global_searchterms)) {
					array_push($global_searchterms, $term_name);
				}
			}
			//echo "\n\n";

		}
	}

	//var_dump($global_sports);
	//var_dump($sport_jsons);
	//var_dump($global_searchterms);
	//echo "\n";
	//echo json_last_error();
	//echo;

	function showResults($file_name, $s_term = ""){
		
		//a) check for existence of the file, act accordingly.
		$result_file = file_get_contents($file_name) or die ("That file does not exist in this directory");
		
		//b) open the file and use json_decode() to produce either objects or arrays (your choice).
		$result_array = json_decode($result_file, true);

		//c) verify that the file is proper JSON with json_last_error().
		//echo json_last_error();
		switch (json_last_error()) {
        	case JSON_ERROR_NONE:
            	//echo " - No errors \n";
        		break;
        	case JSON_ERROR_DEPTH:
            	echo "<p style='font-size:20px; color:red;'> Maximum stack depth exceeded </p>\n";
        		break;
        	case JSON_ERROR_STATE_MISMATCH:
        	    echo "<p style='font-size:20px; color:red;'> Underflow or the modes mismatch </p> \n";
        		break;
        	case JSON_ERROR_CTRL_CHAR:
        	    echo "<p style='font-size:20px; color:red;'> Unexpected control character found </p> \n";
        		break;
        	case JSON_ERROR_SYNTAX:
        	    echo "<p style='font-size:20px; color:red;'> Syntax error, malformed JSON  </p>\n";
        		break;
        	case JSON_ERROR_UTF8:
        	    echo "<p style='font-size:20px; color:red;'> Malformed UTF-8 characters, possibly incorrectly encoded </p> \n";
        		break;
        	default:
        	    echo "<p style='font-size:20px; color:red;'> Unknown error </p> \n";
        		break;
    	}

    	//d) Produce a report (in HTML format) with the appropriate title/header which is filled in from the "comments" JSON element.
    	$comments = $result_array["comments"];
		$games = $result_array["games"];
		$a_game = $games[0];

		$column_titles = array();

		foreach ($a_game as $col_title => $t) {
			array_push($column_titles, $col_title);
		}

		foreach ($comments as $com_num => $comment) {
			echo '<p style="font-size:20px; color:black;">' . $comment . '</p>' . "\n";
		}
		

		echo '<table style="width:100%">';
			echo '<tr>' . "\n";
				foreach ($column_titles as $t => $column) {
					if ($s_term == $column) {
						echo '<td style="font-size:20px; font-weight:bold; color:black;">' . $column . '</td>' . "\n";
					}
					else{
						echo '<td style="font-size:20px; color:black;">' . $column . '</td>' . "\n";
					}
				}
			echo '</tr>';

			echo '<tr>';

				foreach ($games as $game_array => $game) {

					foreach ($game as $g => $value) {
						
						if ($g == $s_term) {
							echo '<td style="font-size:15px; font-weight:bold; color:black;">' . $value . '</td><br>' . "\n";
						}
						else{
							echo '<td style="font-size:15px; color:black;">' . $value . '</td><br>' . "\n";	
						}
					}

				}

			echo '</tr>';

		echo '</table>';

		echo "\n\n\n";

    }

    showResults($sport_jsons[0]);
    showResults($sport_jsons[1], $global_searchterms[1]);



?>
