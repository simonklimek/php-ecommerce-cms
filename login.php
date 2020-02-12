<?php

session_start();

// connecting to the database 
$mongoClient = new MongoClient();

// select the database to use
$database = $mongoClient->ecommerce;


// taking user input data
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

// looks to see if given username is present in database 
$searchUsername = [
    "email" => $email,
    "password" => $password
];

// the given name which is set into the array is looked for in the databse collection 
$find = $database->User->findOne($searchUsername);

if ($find !== null) {
    //Start session for this user
    $_SESSION['loggedInUserEmail'] = $email;
}

// close database connection 
$mongoClient->close();

header('Location: index.php');

?>
    