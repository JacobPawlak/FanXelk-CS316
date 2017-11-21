# FanXelk-CS316
PHP project on FanXelk

to add this repo do the following:
git clone https://github.com/JacobPawlak/FanXelk-CS316.git

to check the status of the repo:

git status

to commit files:

git commit

git commit <file_name>

to add a file to the repo:

git add <file_name>

after you commit, push the files with:

git push

if there are any changes you need to incorporate:

git pull


### TODOs

2) Your program process (read) a given JSON file (Sports.json). 
	It will contain a JSON element "sport", which will be an array of
	JSON objects. Each object will have a "title", "results" and
	"searchterms" subobject.

	"title" will be the title of the sport for this object:
	"College Football", or "Mens College Basketball", etc.

	"results" will be a list of key/value pairs where the key
	is the season of the results. The value will be the
	name of a provided JSON file that contains game/match
	results for each in the season.

	"searchterms" will be a list of terms that can be searched
	for in the above files.


3)
a. check for existence of the file, act accordingly. 
b. open the file and use json_decode() to produce either objects or arrays (your choice).
c. verify that the file is proper JSON with json_last_error().
d. Produce a report (in HTML format) with the appropriate title/header which is filled in from the "comments"
	JSON element.
e. iterate over the "games" JSON element, printing out the results of each game in a nice readable format. While
	iterating, keep track of total wins and losses.
f. if the user selected a search parameter (from searchterms above), then in each game that key appears ("Opponent", or
	"Points", etc) - your report shall make the key and value BOLD in the output. If the key does not appears then
	no key/value is made bold.
g. After the game results are output, output a summary of Win/Loss and the win percentage (format your choice).


4) our shall produce an HTML form. This form shall present the user with a web page and form. The form shall contain pull down 
	choices for the title, the results (containing the key), and all searchterms across all sports. Note that this means that
	with the supplied example Sports.json file, "Digs" will not exist in the other two sports. Your program will accept
	non-existent searchterms for sports and simply treat them as elements not found in those games.

	Your action shall call your PHP program with the appropriate submissions. The submissions will determine, based on "title"
	and "results" selected, which filename to send to your function showResults() above. Note you shall not expose the
	filenames to the user, as a security measure.

### 5) You shall document (via comments at the top of your code), which items you did and did not implement. This is also
	critical for any extra credit you might have attempted. Look at the grading rubric below, list out each letter/item
	and put "implemented" or "not-implemented" or "partially implemented". If partially, explain what does/does not work.


EC) 
g. Code the HTML form and rest of your PHP all in one source file and not 2 separate files. Note that you must implement
	"d" above. 5 pts

h. Add an element to Sports.json for "College Football" and create the appropriate corresponding JSON file for the game
	results (and comments). Turn in both your updated Sports.json file and the game results file. 5 pts

### i. Add a 4th field to the HTML form. Add this field/search choice to the report's header (say, below the "comments".
	This field shall have three values ("all", "max", "min").  If the user selects "all" your search program acts as above, 
	simply highlighting all of that search key/value for each  result. If the user selects "max" then, in addition to 
	highlighting all key/values for the selected search term, your HTML will change the color to blue for the key/value 
	that matches the key and the value is the maximum for the whole season. If they select "min", the change the color 
	to red for the lowest value. Note that there are instances where min or max do not make a lot of sense (Opponent, 
	for example). Programmer's choice on what to do: treat strings as alphabetically ("L" is less than "W", so all 
	"L"s would be considered mins and all "W" would be maxs. Document explicitly your choices made. 15 pts
	[Note: it is critical to check for existence of keys before your program tries to access them, see "f" above. If
	you lose points on "f", you will lose them here as well!]
