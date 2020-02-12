//Globals#
window.onload = loadBasket;

//Displays basket in page.
function loadBasket(){
    //Get basket from local storage or create one if it does not exist
    var basketArray;
    if(sessionStorage.basket === undefined || sessionStorage.basket === ""){
        basketArray = [];
        
    }
    else {
        basketArray = JSON.parse(sessionStorage.basket);
    }
    
    //Build string with basket HTML
    var htmlStr = "<p>Number of items in basket: " + basketArray.length + "</p>";
    var htmlStr = "<form action='checkout.php' method='post'>";
    var prodIDs = [];
    for(var i=0; i<basketArray.length; ++i){
        htmlStr += "Product name: " + basketArray[i].name + "<br>";
        prodIDs.push({id: basketArray[i].id, count: 1});//Add to product array
    }
    //Add hidden field to form that contains stringified version of product ids.
    htmlStr += "<input type='hidden' name='prodIDs' value='" + JSON.stringify(prodIDs) + "'>";
    
    //Add checkout and empty basket buttons
    htmlStr += "<input type='submit' value='Checkout'></form>";
    htmlStr += "<br><button onclick='emptyBasket()'>Empty Basket</button>";
    
    //Display nubmer of products in basket
    document.getElementById("basketDiv").innerHTML = htmlStr;
}

//Adds an item to the basket
function addToBasket(prodID, prodName){
    //Get basket from local storage or create one if it does not exist
    var basketArray;
    if(sessionStorage.basket === undefined || sessionStorage.basket === ""){
        basketArray = [];
    }
    else {
        basketArray = JSON.parse(sessionStorage.basket);
    }
    
    //Add product to basket
    basketArray.push({id: prodID, name: prodName});
    
    //Store in local storage
    sessionStorage.basket = JSON.stringify(basketArray);
    
    //Display basket in page.
    loadBasket();      
}

//Deletes all products from basket
function emptyBasket(){
    sessionStorage.clear();
    loadBasket();
}
