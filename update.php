<?php 

// connecting to the database 
$mongoClient = new MongoClient();

// select the database to use
$database = $mongoClient->ecommerce;

// takes username from the current logged user
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);


// array to set the value of the current user to be passed for later 
$search = [

    "email" => $email,
    "password" => $password

];

// close database connection 
$mongoClient->close();
?>
