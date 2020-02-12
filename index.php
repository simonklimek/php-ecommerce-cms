<?php
include('check_login.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- main css -->
        <link rel="stylesheet" href="css/style.css">

        <!-- font awesome -->
        <link rel="stylesheet" href="css/all.css">
        <script src="js/basket.js"></script>
        <script src="js/update_user.js"></script>
        <title>Shopping Cart MDX</title>
    </head>
    <body>

     <!-- header -->
    <header>
        <!-- navbar  -->
        <nav class="navbar navbar-expand-lg px-4">
            <a class="navbar-brand" href="#"><img src="img/logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNav">
                <span class="toggler-icon"><i class="fas fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="myNav">
                <ul class="navbar-nav mx-auto text-capitalize">
                    
                </ul>
                <div class="nav-info-items d-none d-lg-flex ">
                    <!-- LOGIN STATUS  -->
                <?php if (isset($_SESSION['loggedInUserEmail'])) : ?>
                    logged in as   <strong><?php echo $_SESSION['loggedInUserEmail']; ?></strong>
                <?php else : ?>
                <p> not logged in<p>
                <?php endif; ?>
                <form action="logout.php" method="post">
                    <button>Logout</button>
                </form>
                <!-- END OF LOGIN STATUS -->
                </div>
            </div>
        </nav>
        <!-- end of nav -->
        <!-- banner  -->
        <div class="container-fluid">
            <div class="row max-height justify-content-center align-items-center">
                <div class="col-10 mx-auto banner text-center">
                <h1 class="text-capitalize">welcome to <strong class="banner-title ">armory</strong></h1>
                </div>
                <div class="col-5 mx-auto text-center">
                <!-- REGISTRATION ---------------------------------------------------------- -->
                <h1>Registration</h1><br />
                    Email: <input type="text" name="email" id="regEmail">
                    Password: <input type="password" name="password" id="regPassword">
                    <button onclick="register()">Register</button>
                    <h3 id="regFeedback"></h3>
                </div>
                <div class="col-5 mx-auto text-center">
                    <!-- LOGIN  ---------------------------------------------------------------- -->
                    <form action="login.php" method="post">
                    <h1>Customer Login</h1>
                    Email: <input type="email" name="email" id="email2" required>
                    Password: <input type="password" name="password" id="password2" required>
                    <button>Login</button>
                    <!-- <h3 id="loginFeedback"></h3> -->
                </form>
                </div>
            </div>
        </div>
        <!--end of  banner  -->
    </header>

            <div class="row">
                <div class="col-10 mx-auto col-sm-6 text-center">
                <h1 class="text-capitalize">our <strong class="banner-title ">store</strong></h1>
                </div>
            </div>
            <!-- search box -->
            <div class="row">
                <div class="col-10 mx-auto col-md-6">
                    <div class="input-group mb-3">
                        Search for product: <input type="text" class="form-control" name="name" id="product_name" required>
                        <button onclick="loadProducts()">Search</button>
                    </div>
                </div>
            </div>




      <div class="row">
      <div class=" col-lg-8 mx-auto d-flex justify-content-around my-2 sortBtn flex-wrap">
        <h1>Sort</h1>
        
        <!-- PHP loads product information -->        
        <form action="index.php" method="post">
           <input type="hidden" name="sort" value="lowtohigh">
           <button class="btn btn-outline-secondary btn-black text-uppercase filter-btn m-2">Sort by Price Ascending</button>
       </form>
       <br>
       <form action="index.php" method="post">
           <input type="hidden" name="sort" value="hightolow">
           <button class="btn btn-outline-secondary btn-black text-uppercase filter-btn m-2">Sort by Price Descending</button>
       </form>
       <br>
       <form action="index.php" method="post">
           <input type="hidden" name="sort" value="atoz">
           <button class="btn btn-outline-secondary btn-black text-uppercase filter-btn m-2">Sort from A to Z</button>
       </form>
       <br>
       <form action="index.php" method="post">
           <input type="hidden" name="sort" value="ztoa">
           <button class="btn btn-outline-secondary btn-black text-uppercase filter-btn m-2">Sort from Z to A</button>
       </form>
       <br>
       <form action="index.php" method="post">
           <input type="hidden" name="sort" value="all">
           <button class="btn btn-outline-secondary btn-black text-uppercase filter-btn m-2">Show unsorted</button>
       </form>
       <br>
        </div>
        </div>

        <!-- end of sortign -->
        <section class="store py-5">
            <div class="container">
               
                    <h1>Product list</h1><br />
                    <div class="row" class="store-items">
                    <div id="products">
                        <?php
                            //Connect to MongoDB and select database
                            $mongoClient = new MongoClient();
                            $db = $mongoClient->ecommerce;

                            //Find all products
                            $products = $db->Products->find();
                            

                            $sort = filter_input(INPUT_POST, 'sort', FILTER_SANITIZE_STRING);

                            if ($sort === 'atoz') {
                                $products = $db->Products->find([])->sort(['name' => 1]);
                            }
                            if ($sort === 'ztoa') {
                                $products = $db->Products->find([])->sort(['name' => -1]);
                            }
                            if ($sort === 'lowtohigh') {
                                $products = $db->Products->find([])->sort(['cost' => 1]);
                            }
                            if ($sort === 'hightolow') {
                                $products = $db->Products->find([])->sort(['cost' => -1]);
                            }
                            if ($sort === 'all') {
                                $products = $db->Products->find([]);
                            }
                            //Output results onto page
                                if($products->count() > 0){
                                    echo '<table>';
                                    echo '<tr><th>Name</th><th>Description</th><th>Price</th><th>Cost</th><th>Add to Basket</th></tr>';
                                    foreach ($products as $document) {
                                        echo '<tr>';
                                        echo '<td>' . $document["name"] . "</td>";
                                        echo '<td>' . $document["description"] . "</td>";
                                        echo '<td>' . $document["cost"] . "</td>";
                                        echo "<td><img width='50' height'50' src='/img/" .$document['image'].  "'></td>";
                                        echo '<td><button onclick=\'addToBasket("' . $document["_id"] . '", "' . $document["name"] . '")\'>';
                                        echo '<img class="addButtonImg" src="basket-add-icon.png"></button></td>';
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                }
                            //Close the connection
                            $mongoClient->close();
                        ?>
                    </div>
                </div>
                <?php if (isset($_SESSION['loggedInUserEmail'])) : ?>
                <h2>Basket</h2>
                <div id="basketDiv"></div>
                <br />
                <h2>Order History</h2>
                <form action="orderhistory.php" method="get">
                <button>Show Order History</button>
                </form>
                <h1>Edit user details</h1>
                <?php
                    echo '<form action="save_customer.php" method="post">';
                    echo 'Email: <input type="email" name="email" value="' . $_SESSION['loggedInUserEmail'] . '" required><br>';
                    // echo 'Password: <input type="password" name="password" value="' . $_SESSION['loggedInUserPassword']  . '" required><br>'; 
                    // echo '<input type="hidden" name="id" value="' . $_SESSION[$id] . '" required>'; 
                    echo '<input type="submit">';
                    echo '</form><br>';
                ?>
                <?php else : ?>
                <?php endif; ?>



            </div>
        </section>
    <!-- ------------------------------------------------------------------------ -->
    <script>
        function register(){
            //Create request object 
            var request = new XMLHttpRequest();

            //Create event handler that specifies what should happen when server responds
            request.onload = function(){

                // variable to get the response given back
                var response = request.responseText;

                if (response === "pass") {
                    document.getElementById("regFeedback").innerHTML = "Account created, please login!";
                    document.getElementById("regEmail").value = "";
                    document.getElementById("regPassword").value = "";
                    }
                // if theres issues in the data
                else if (response === "fail") {
                    document.getElementById("regFeedback").innerHTML = "Error creating an account, please try again!";
                    document.getElementById("regEmail").value = "";
                    document.getElementById("regPassword").value = "";
                }
            };
            
            // start registration 
            //Set up request with HTTP method and URL 
            request.open("POST", "registration1.php");
            //method by which data is sent so retrun is not null
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            
            //Extract registration data
            var regemail = document.getElementById("regEmail").value;
            var regpassword = document.getElementById("regPassword").value;
            
            //Data being sent to the registration page 
            request.send("email=" + regemail + "&password=" + regpassword);
        }

        // --------------------------------------------------------------------------
        //Download products when page loads
        //Downloads JSON description of products from server
        function loadProducts(){
            //Create request object 
            var request = new XMLHttpRequest();
            
            var product_name = document.getElementById('product_name').value;
            console.log(product_name);
            //Set up request and send it
            request.open("GET", "products.php?name="+product_name);
            request.send();
            //Create event handler that specifies what should happen when server responds
            request.onload = function(){
            //Check HTTP status code
            if(request.status === 200){
                //Add data from server to page
                //displayProducts(request.responseText);
                document.getElementById('products').innerHTML = request.responseText;
            }
            else
                alert("Error communicating with server: " + request.status);
            };
        }

        //Loads products into page
        function displayProducts(jsonProducts){
            //Convert JSON to array of product objects
            var prodArray = JSON.parse(jsonProducts);
            
            //Create HTML table containing product data
            var htmlStr = "<table>";
            for(var i=0; i<prodArray.length; ++i){
                htmlStr += "<tr>";
                htmlStr += "<td>" + prodArray[i].name + "</td>";
                htmlStr += "<td><img width=50 height=50 src='" + prodArray[i].image_url + "'></td>";
                htmlStr += "<td>£" + prodArray[i].cost + "</td>";
                htmlStr += "</tr>";
            }
            //Finish off table and add to document
            htmlStr += "</table>";
            document.getElementById("products").innerHTML = htmlStr;
        }
    </script>
     <!-- jquery -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>

