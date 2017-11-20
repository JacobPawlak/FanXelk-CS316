#!/usr/bin/php

<?php


	$sports_file = file_get_contents("Sports.json") or die ("That file does not exist in this directory");
	$sport_array = json_decode($sports_file, true);

	$sport_jsons = array();
	$global_searchterms = array();

	//var_dump($sport_array);

	foreach ($sport_array as $key => $value) {

		//var_dump($value);
		//echo "Key = " . (string)$key . "Value = " . (string)$value;

		foreach ($value as $array_num => $title) {
			//echo "array_num = " . $array_num . " title = " . $title;
			//var_dump($title);
			echo "\n\n";
			echo "sport = " . $title["title"];
			echo "\n\n";
			$sport_name = $title["title"];
			$years = $title["results"];
			$search_terms = $title["searchterms"];
			
			//var_dump($years);

			foreach ($years as $sport => $sport_name) {
				//echo "sport = " . $sport . " sport_name = " . $sport_name;
				//var_dump($sport_name);
				//var_dump($years);
				//var_dump($sport_name);
				echo "json file = $sport_name \n";
				array_push($sport_jsons, $sport_name);
			}
			echo "\n\n";

			foreach ($search_terms as $term => $term_name) {
				//var_dump($term_name);
				echo "searchterm = $term_name \n";
				if (!in_array($term_name, $global_searchterms)) {
					array_push($global_searchterms, $term_name);
				}
			}
			echo "\n\n";

		}
	}

	var_dump($sport_jsons);
	var_dump($global_searchterms);
	echo "\n";
	//echo json_last_error();
	//echo;

	function showResults($file_name, $s_term = ""){
		
		//a) check for existence of the file, act accordingly.
		$result_file = file_get_contents($file_name) or die ("That file does not exist in this directory");
		
		//b) open the file and use json_decode() to produce either objects or arrays (your choice).
		$result_array = json_decode($result_file, true);


		//c) verify that the file is proper JSON with json_last_error().
		echo json_last_error();
		switch (json_last_error()) {
        	case JSON_ERROR_NONE:
            	echo " - No errors \n";
        		break;
        	case JSON_ERROR_DEPTH:
            	echo " - Maximum stack depth exceeded \n";
        		break;
        	case JSON_ERROR_STATE_MISMATCH:
        	    echo " - Underflow or the modes mismatch \n";
        		break;
        	case JSON_ERROR_CTRL_CHAR:
        	    echo " - Unexpected control character found \n";
        		break;
        	case JSON_ERROR_SYNTAX:
        	    echo " - Syntax error, malformed JSON \n";
        		break;
        	case JSON_ERROR_UTF8:
        	    echo " - Malformed UTF-8 characters, possibly incorrectly encoded \n";
        		break;
        	default:
        	    echo " - Unknown error \n";
        		break;
    	}

    	var_dump($result_array);

    	//d) Produce a report (in HTML format) with the appropriate title/header which is filled in from the "comments" JSON element.
    	

    }

    showResults($sport_jsons[0]);


?>
