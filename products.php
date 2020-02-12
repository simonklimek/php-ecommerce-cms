<?php
//Connect to MongoDB
$mongoClient = new MongoClient();

//Select a database
$db = $mongoClient->ecommerce;

$name= filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);




if ($name) {
    $findCriteria['name'] = new MongoRegex("/$name/i");
}
// if ($category) {
//     $findCriteria['category'] = new MongoRegex("/$category/i");
// }


$cursor = $db->Products->find($findCriteria);

$numResults = $cursor->count();
$cntr = 0;

if($cursor->count() > 0){
    echo '<table>';
    echo '<tr><th>Name</th><th>Category</th><th>Stock</th><th>Price</th><th>Description</th><th>Image</th><th>Click to buy</th></tr>';
    foreach ($cursor as $document) {
        echo '<tr>';
        echo '<td>' . $document["name"] . "</td>";
        echo '<td>' . $document["category"] . "</td>";
        echo '<td>' . $document["stock"] . "</td>";
        echo '<td>' . $document["cost"] . "</td>";
        echo '<td>' . $document["description"] . "</td>";
        // echo '<td><img src="img/' . $document["image"] . '" /></td>";
        echo "<td><img width='50' height'50' src='/img/" .$document['image'].  "'></td>";
        echo '<td><button onclick=\'addToBasket("' . $document["_id"] . '", "' . $document["name"] . '")\'>';
        echo '<img class="addButtonImg" src="basket-add-icon.png"></button></td>';
        echo '</tr>';
    }
    echo '</table>';
}

$mongoClient->close();


// echo "<td><img width='50' height'50' scr='/img" .$document['image'].  "'></td>";