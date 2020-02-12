<?php

    $mongoClient = new MongoClient();

    // select the database to use
    $db = $mongoClient->ecommerce;

    // select collection to use
    $collection=$db->User;

    //Get name and address strings - need to filter input to reduce chances of SQL injection etc.
    $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


    // send to array 
    $userArray = [
        "email" =>$email,
        "password" =>$password
    ];

    // send the data to the customers collection 
    $sendData = $collection->insert($userArray);


    // give outcome
    if($sendData["ok"]==1){
        echo "pass";
    } else{
        echo "fail";
    }
        
 

// close database connection 
$mongoClient->close();
?>