<?php
//Connect to MongoDB
$mongoClient = new MongoClient();

//Select a database
$db = $mongoClient->ecommerce;

$collection = $db->Orders;

$id = filter_input(INPUT_GET, "_id", FILTER_SANITIZE_STRING);

$orderArray = [
    "id" =>$id
];

$find = $collection->find($orderArray);

foreach ($find as $doc) {
    echo '<h2>Order</h2>';
    echo '<p>Order ID: ' . $doc['_id'];
}

$mongoClient->close();

// for($i=0; $i<count($orderArray); $i++){
//     echo '<p>Order</p>';
//     echo '<p>Product ID: ' . $orderArray[$i]['id'] . '. Count: ' . $orderArray[$i]['count'] . '</p>';
// }

?>