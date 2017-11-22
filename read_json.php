#!/usr/bin/php

<?php

	function start_html(){

		echo '<html>';

		echo '<!--Chelsea Kuball and Jacob Pawlak CS316 Project 4 - FanXelk November 18th, 2017 -->';

		echo '<head>';

        	echo '<title>Chelsea Kuball and Jacob Pawlak P4 CS316</title>';

		echo '</head>';

		echo '<body>';

			echo '<p style="font-size: 30px; color: black; text-align: center">CS316 Chelsea Kuball and Jacob Pawlak | Project 4</p>';
	}

	function end_html(){

		echo '</body></html>';
		echo "\n";

	}

	if(isset($_GET['submit'])){
		showResults();
	} 
	else {
		showForm();
	}

	function showForm(){

	start_html();

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
				array_push($sport_jsons, $sport);
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

	echo '<form action="read_json.php" method="get">';

		echo '<label for="title">Title</label>';
		echo '<select name="title" id="title">';
		foreach ($global_sports as $key => $value) {
			echo '<option value="'. $value . '">' . $value . '</option>';
		}
		echo '</select><br>';
		echo '<label for="results">Results</label>';
		echo '<select name="results" id="results">';
		foreach ($sport_jsons as $key => $value) {
			echo '<option value="'. $value . '">' . $value . '</option>';
		}
		echo '</select><br>';
		echo '<label for="searchterms">Search Term</label>';
		echo '<select name="searchterms" id="searchterms">';
		foreach ($global_searchterms as $key => $value) {
			echo '<option value="'. $value . '">' . $value . '</option>';
		}
		echo '</select><br>';
		echo '<label for="highlight">Highlighter</label>';
		echo '<select name="highlight" id="highlight">';
			echo '<option value="all">All</option>';
			echo '<option value="max">Max</option>';
			echo '<option value="min">Min</option>';
		echo '</select><br>';

		echo '<input type="submit" name="submit" value="submit"><br>';    	

    echo "</form>";

    end_html();

	}

	function showResults(){
		
		start_html();

		$s_title =  $_GET['title'];
		$s_results = $_GET['results'];
		$s_term = $_GET['searchterms'];
		$s_highlight = $_GET['highlight'];



		//a) check for existence of the file, act accordingly.

		//looking for the result that matches with the right title
		//e.g. "College Football -> Y2015"

		$result = "blank";

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
				if ($sport_name == $s_title) {
					$years = $title["results"];
					
					foreach ($years as $sport => $sport_name) {
						//echo "sport = " . $sport . " sport_name = " . $sport_name;
						//var_dump($sport);
						//var_dump($years);
						//var_dump($sport_name);
						//echo "json file = $sport_name \n";
						//array_push($sport_jsons, $sport);
						if ($sport = $s_results) {
							$result = $sport_name;
						}

					}
				}
			}
		}





		$result_file = file_get_contents($result) or die ("That title does not have the year you selected, please try again");
		
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
		$total_wins = 0;

		$column_titles = array();

		foreach ($a_game as $col_title => $t) {
			array_push($column_titles, $col_title);
		}

		echo '<table style="width:100%">';
			echo '<tr>' . "\n";
			foreach ($comments as $com_num => $comment) {
				echo '<th style="font-size: 22px; color:black;">' . $comment . '</th>' . "\n";
			}
			echo '</tr>';
		echo '</table>';

		echo '<table style="width:100%">';
			echo '<tr>' . "\n";
				foreach ($column_titles as $t => $column) {

					//e) if the user selected a search parameter (from searchterms above), then in each 
					// game that key appears ("Opponent", or "Points", etc) - your report shall make the 
					// key and value BOLD in the output. If the key does not appears then no key/value is made bold.
					if ($s_term == $column) {
						echo '<td style="font-size:20px; font-weight:bold; color:black;">' . $column . '</td>' . "\n";
					}
					else{
						echo '<td style="font-size:20px; color:black;">' . $column . '</td>' . "\n";
					}
				}
			echo '</tr>';


			foreach ($games as $game_array => $game) {

				echo '<tr>';
				foreach ($game as $g => $value) {
					
					if ($g == "WinorLose") {
						if ($value == "W") {
							$total_wins += 1;
						}
					}

					if ($g == $s_term) {
						echo '<td style="font-size:15px; font-weight:bold; color:black;">' . $value . '</td>' . "\n";
					}
					else{
						echo '<td style="font-size:15px; color:black;">' . $value . '</td>' . "\n";	
					}
				}
				echo '</tr>';

			}


		echo '</table>' . "\n";
		//f) After the game results are output, output a summary of Win/Loss and the win percentage (format your choice).
		$ratio = 100 * $total_wins/count($games);
		echo "<p style='color: green; font-size: 20px;'>Win percentage is : $ratio\n";
		echo "\n\n\n";

		end_html();

    }

    //showResults($sport_jsons[0]);
    //showResults($sport_jsons[1], $global_searchterms[1]);


?>
