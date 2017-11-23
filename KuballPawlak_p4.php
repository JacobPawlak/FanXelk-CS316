#!/usr/bin/php

<?php

//Chelsea Kuball and Jacob Pawlak
//November 22nd, 2017
//CS316 Project 4 - PHP

//Implemented in full:
// a, b, c, d, e, f, g, h, i

	// build the shell of the html file, will be called at the beggining of both functions
	function start_html(){

		echo '<html>';

		echo '<!--Chelsea Kuball and Jacob Pawlak CS316 Project 4 - FanXelk November 18th, 2017 -->';

		echo '<head>';

        	echo '<title>Chelsea Kuball and Jacob Pawlak P4 CS316</title>';

		echo '</head>';

		echo '<body>';

			echo '<p style="font-size: 30px; color: black; text-align: center">CS316 Chelsea Kuball and Jacob Pawlak | Project 4</p>';
	}

	//close the end of the html shell
	function end_html(){

		echo '</body></html>';
		echo "\n";

	}


	//this is where we determine what function we should be in.
	//	this helps us keep the php and html form in the same file
	//	If the submit button has been clicked, and yes we are expecting
	//	you to either use the form or to know to include the submit button
	//	when you wget or curl or whatever
	if(isset($_GET['submit'])){
		//if the submit button has been set, then we want to showResults
		showResults();
	} 
	else {
		//if the submit button has not been clicked/set, we just want to show
		//	the form - we assume that the user still needs to enter in the data
		showForm();
	}

	//this is the function that displays the html form - it needs to read in sports.json
	function showForm(){

	//call the html shell starter
	start_html();

	//read in the Sports.json file as a string, or die if it is not found
	$sports_file = file_get_contents("Sports.json") or die ("That file does not exist in this directory<br><a href='read_json.php'> Return to Main Page</a>");
	//turn that string into a json object, we want to use arrays because why not.
	$sport_array = json_decode($sports_file, true);

	//global arrays for the filling of the select tags
	$sport_jsons = array();
	$global_sports = array();
	$global_searchterms = array();

	//loop through sports.json for each sport title
	foreach ($sport_array as $key => $value) {

		//loop through each sport for all its components
		foreach ($value as $array_num => $title) {
			
			//if the title of the sport is not already in the 'global' array for the
			//	sport titles, add it
			$sport_name = $title["title"];
			if (!in_array($sport_name, $global_sports)) {
					array_push($global_sports, $sport_name);
			}
			//grab the array of results (Y20XX) and the array of search terms
			$years = $title["results"];
			$search_terms = $title["searchterms"];

			foreach ($years as $sport => $sport_name) {
				//push the (Y20XX) string to its global array
				array_push($sport_jsons, $sport);
			}

			foreach ($search_terms as $term => $term_name) {
				
				//if the search term for each sport is not already in the global array, put it there
				if (!in_array($term_name, $global_searchterms)) {
					array_push($global_searchterms, $term_name);
				}
			}
		}
	}

	//this is the form, its action points back to itself, and we are using the get method 
	echo '<form action="KuballPawlak_p4.php" method="get">';

		//select tag for the titles
		echo '<label for="title">Title</label>';
		echo '<select name="title" id="title">';
		foreach ($global_sports as $key => $value) {
			echo '<option value="'. $value . '">' . $value . '</option>';
		}
		echo '</select><br>';

		//select tag for the results
		echo '<label for="results">Results</label>';
		echo '<select name="results" id="results">';
		foreach ($sport_jsons as $key => $value) {
			echo '<option value="'. $value . '">' . $value . '</option>';
		}
		echo '</select><br>';

		//select tag for the search terms
		echo '<label for="searchterms">Search Term (Optional)</label>';
		echo '<select name="searchterms" id="searchterms">';
			echo '<option value="NA"></option>';
		foreach ($global_searchterms as $key => $value) {
			echo '<option value="'. $value . '">' . $value . '</option>';
		}
		echo '</select><br>';

		//select tag for the highlighter
		echo '<label for="highlight">Highlighter</label>';
		echo '<select name="highlight" id="highlight">';
			echo '<option value="all">All</option>';
			echo '<option value="max">Max</option>';
			echo '<option value="min">Min</option>';
		echo '</select><br>';

		//submit button
		echo '<input type="submit" name="submit" value="submit"><br>';    	

    echo "</form>";

    //close out the html, its done for now
    end_html();

	}

	//our showResults() function
	function showResults(){
		
		//again, start the html skele
		start_html();

		//a few statements for setting (and checking) the status of our $_get variables
		if (isset($_GET['title'])) {
			$s_title =  $_GET['title'];
		}
		else{
			$s_title = "blank";
		}
		if (isset($_GET['results'])) {
			$s_results = $_GET['results'];
		}
		else{
			$s_results = "blank";	
		}
		if (isset($_GET['searchterms'])) {
			$s_term = $_GET['searchterms'];
		}
		else{
			$s_term = "blank";
		}
		if (isset($_GET['highlight'])) {
			$s_highlight = $_GET['highlight'];
		}
		else{
			$s_highlight = "blank";
		}



		//a) check for existence of the file, act accordingly.

		//looking for the result that matches with the right title
		//e.g. "College Football -> Y2015"

		$result = "blank";

		//same thing that we did above
		$sports_file = file_get_contents("Sports.json") or die ("That file does not exist in this directory<br><a href='read_json.php'> Return to Main Page</a>");
		$sport_array = json_decode($sports_file, true);

		//dont actually need these here but i am too scared to pull them out.
		$sport_jsons = array();
		$global_sports = array();
		$global_searchterms = array();

		//looking for the file that the user wants, if we find a match between the result and the title
		//	set the $result to that file
		foreach ($sport_array as $key => $value) {

			foreach ($value as $array_num => $title) {
				
				$sport_name = $title["title"];
				if ($sport_name === $s_title) {
					$years = $title["results"];
					
					foreach ($years as $sport => $sport_name) {

						if ($sport === $s_results) {
							$result = $sport_name;
						}

					}
				}
			}
		}


		//grab the contents out of the json that we want to look at
		$result_file = file_get_contents($result) or die ("That title does not have the year you selected, please try again<br><a href='read_json.php'> Return to Main Page</a>");
		
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

		//this starts the displaying process, we make a table for the comments
		echo '<table style="width:100%">';
			echo '<tr>' . "\n";
			foreach ($comments as $com_num => $comment) {
				echo '<td style="font-size: 22px; color:black;">' . $comment . '</td>' . "\n";
			}
			echo '</tr>';
		echo '</table>';

		//now a table for the column headers

		echo '<table style="width:100%">';
			echo '<tr>' . "\n";

				foreach ($column_titles as $t => $column) {

					//e) if the user selected a search parameter (from searchterms above), then in each 
					// game that key appears ("Opponent", or "Points", etc) - your report shall make the 
					// key and value BOLD in the output. If the key does not appears then no key/value is made bold.
					if (($s_term === $column) && ( ($s_highlight === "all") || ($s_highlight === "max") || ($s_highlight === "min") )) {
						echo '<td style="font-size:22px; font-weight:bold; color:black;">' . $column . '</td>' . "\n";
					}
					else{
						echo '<td style="font-size:20px; color:black;">' . $column . '</td>' . "\n";
					}
				}
			echo '</tr>';


			$search_array = array();

			foreach ($games as $game_array => $game) {
				
				foreach ($game as $c_title => $c_value) {
					
					if ($c_title ==== $s_term) {
						if (!in_array($c_value, $search_array)) {
							array_push($search_array, strtolower($c_value));
						}
					}
				}
				
			}
			sort($search_array);

			foreach ($games as $game_array => $game) {

				echo '<tr>';
				foreach ($game as $g => $value) {
					
					if ($g === "WinorLose") {
						if ($value === "W") {
							$total_wins += 1;
						}
					}

					if (($g == $s_term) && ($s_highlight == "all")) {
						echo '<td style="font-size:15px; font-weight:bold; color:black;">' . $value . '</td>' . "\n";
					}
					elseif(($g == $s_term) && ($s_highlight == "max") && (strtolower($value) == $search_array[count($search_array) - 1])){
						echo '<td style="font-size:15px; font-weight:bold; color:blue;">' . $value . '</td>' . "\n";
					}
					elseif(($g == $s_term) && ($s_highlight == "max") && (strtolower($value) != $search_array[count($search_array) - 1])){
						echo '<td style="font-size:15px; font-weight:bold; color:black;">' . $value . '</td>' . "\n";
					}
					elseif(($g == $s_term) && ($s_highlight == "min") && (strtolower($value) == $search_array[0])) {
						echo '<td style="font-size:15px; font-weight:bold; color:red;">' . $value . '</td>' . "\n";
					}
					elseif(($g == $s_term) && ($s_highlight == "min") && (strtolower($value) != $search_array[0])) {
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
		$total_losses = count($games)-$total_wins;
		echo "<p style='color: green; font-size: 20px;'>Win percentage is : $ratio </p>" ;
		echo "<p style='color: green; font-size: 20px;'>Total Wins / Losses : $total_wins / $total_losses </p>";
		echo '<br><a href="read_json.php"> Return to Main Page</a>';

		end_html();

    }

?>
