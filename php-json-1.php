<?php
class User {
    public $firstname = "";
    public $lastname  = "";
    public $birthdate;
}

$user = new User();
$user->firstname = "foo";
$user->lastname  = "bar";

// Returns: {"firstname":"foo","lastname":"bar"}
echo json_encode($user);

echo "<p>";

$user->birthdate = new DateTime();

/* Returns:
    {
        "firstname":"foo",
        "lastname":"bar",
        "birthdate": {
            "date":"2012-06-06 08:46:58",
            "timezone_type":3,
            "timezone":"Europe\/Berlin"
        }
    }
*/
echo json_encode($user);
// var_dump($what);

?>

