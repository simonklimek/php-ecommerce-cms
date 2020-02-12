<?php


// connecting to the database 
$mongoClient = new MongoClient();

// select the database to use
$db = $mongoClient->ecommerce;

$collection = $db->Orders;

$id= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_STRING);

//Extract the product IDs that were sent to the server
$prodIDs= $_POST['prodIDs'];

//Convert JSON string to PHP array 
$productArray = json_decode($prodIDs, true);

$orderArray = [
    "id" =>$id,
    "stock" =>$stock
];

// send the data to the customers collection 
$sendData = $collection->insert($productArray);

echo '<h1>Order received</h1>';
for($i=0; $i<count($productArray); $i++){
    echo '<p>Product ID: ' . $productArray[$i]['id'] . '. Count: ' . $productArray[$i]['count'] . '</p>';
}

$mongoClient->close();
?>

