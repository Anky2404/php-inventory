<?php include_once 'DBconnection.php';

//check client logged in
function client_logged_in()
{
    if (empty($_SESSION['user'])) {

        echo '<script>alert("Access denied ! , Please Logged In to access this page");
        window.location.href="login.php";
        </script>';
        exit();
    }
}

//check client not logged in
function client_not_loggedIn()
{
    if (isset($_SESSION['user'])) {

        echo '<script>alert("Access denied ! , You are already logged in");
        window.location.href="home.php";
        </script>';
        exit();
    }
}

//check manger logged in
function manager_logged_in(){
    if (empty($_SESSION['Manager'])) {
        echo '<script>alert("Access denied ! , Please Logged In to access this page");
        window.location.href="login.php";
        </script>';
        exit();
    }
}


//check client not logged in
function manager_not_loggedIn()
{
    if (isset($_SESSION['Manager'])) {

        echo '<script>alert("Access denied ! , You are already logged in");
        window.location.href="home.php";
        </script>';
        exit();
    }
}


//get all categories 
function get_all_categories(){
    $categories = [];
    global $connect;
    $query =$connect->prepare('SELECT * FROM `categories`');
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while($rows=$result->fetch_assoc()){
        $categories[] = $rows;
        }
    }
    return $categories;
}

//get categories by id
function get_category_by_id($cat_id){
    $category=[];
    global $connect;
    $query =$connect->prepare('SELECT * FROM `categories` WHERE `cat_id`=?');
    $query->bind_param("i", $cat_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while($rows=$result->fetch_assoc()){
        $category = $rows;
        }
    }
    return $category;

}

//get all active products
function get_all_products()
{
    $products = [];
    global $connect;
    $query = "SELECT p.*, c.*, p.status AS product_status, c.status AS category_status FROM products p JOIN 
    categories c ON p.cat_id = c.cat_id;";
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

function get_product_by_catId($cat_id)
{
    // Initialize the result array
    $details = [
        'total_products' => 0,
        'products' => []
    ];
    global $connect;

    // Prepare the query to join products and categories
    $query = $connect->prepare('SELECT p.status AS productStatus, p.*, c.status AS categoryStatus FROM `products` p JOIN `categories` c ON p.cat_id = c.cat_id 
        WHERE p.cat_id = ?');

    $query->bind_param("i", $cat_id);
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
        while($rows = $result->fetch_assoc()){
            $details['products'][] = $rows;
        }
        $details['total_products'] = $result->num_rows;
    } else {
        $details = null; // No products found
    } 

    return $details;
}


//get product details by id
function get_product_details_by_id($product_id)
{
    global $connect;
    $p_details = [];
    // Prepare the query
    $query = "SELECT * FROM `products` WHERE `id` = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $p_details = $result->fetch_array(MYSQLI_ASSOC);
    } else {
        echo '<script>alert("Product id not found in database !");
            window.location.href="shop.php";
            </script>';
        exit();
    }

    return $p_details;

}

//get offer products
function get_offers_products(){
    global $connect;
    $o_products = [];
    // Prepare the query
    $query = $connect->prepare('SELECT * FROM `offer_products` of JOIN offers o ON o.offer_id=of.offer_id JOIN products P ON of.product_id=P.id');
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while($rows=$result->fetch_assoc()){
            $o_products[] =$rows;
        }
    } 
    return $o_products;
}

//get offer of products by id
function get_offers_details_by_productId($product_id){
    global $connect;
    $o_details = [];
    // Prepare the query
    $query = $connect->prepare('SELECT * FROM `offer_products` of JOIN offers o ON o.offer_id=of.offer_id JOIN products P ON of.product_id=P.id WHERE p.id= ?');
    $query->bind_param("i", $product_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while($rows=$result->fetch_assoc()){
            $o_details =$rows;
        }
    } 
    return $o_details;
}

//get client dilevery address
function client_dilevery_address($client_id)
{
    global $connect;
    $delivery_address = [];
    //get delivery address of client
    $query = $connect->prepare('SELECT * FROM `delivery_address` WHERE `client_id`=?');
    $query->bind_param('i', $client_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        while ($rows = $result->fetch_assoc()) {
            $delivery_address[] = $rows;
        }
    }
    return $delivery_address;
}

//get dilevery address  by id
function dilevery_address_by_id($id)
{
    global $connect;
    $delivery_address = [];
    //get delivery address of client
    $query = $connect->prepare('SELECT * FROM `delivery_address` WHERE `address_id`=?');
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        while ($rows = $result->fetch_assoc()) {
            $delivery_address = $rows;
        }
    }
    return $delivery_address;
}

//get client cart product
function get_client_cart_item($client_id)
{
    global $connect;
    $cart_items = [];
    //get cart product by user id
    $query = $connect->prepare('SELECT * FROM carts c JOIN products p ON c.product_id=p.id WHERE added_by=?');
    $query->bind_param('i', $client_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            $cart_items[] = $rows;
        }
    } else {
        $cart_items = null;
    }
    return $cart_items;
}

//get client cart product
function empty_cart_item_by_clientId($client_id)
{
    global $connect;
    //get cart product by user id
    $query = $connect->prepare('DELETE FROM `carts` WHERE added_by=?');
    $query->bind_param('i', $client_id);
    $query->execute();
    
}

//get client order
function get_client_orders($client_id){
    global $connect;
    $orders = [];
    $query=$connect->prepare('SELECT * FROM `orders` WHERE `client_id`=?');
    $query->bind_param('i', $client_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            $orders[] = $rows;
        }
    } else {
        $orders = null;
    }
    return $orders;
}

//get client order
function get_orders_by_id($id){
    global $connect;
    $orders = [];
    $query=$connect->prepare('SELECT * FROM `orders` WHERE `id`=?');
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            $orders = $rows;
        }
    } else {
        $orders = null;
    }
    return $orders;
}

//get order details by id
function get_order_details_by_id($orderId){
    global $connect;
    $order_details = [];
    $query=$connect->prepare('SELECT * FROM `order_details` od JOIN products ON od.product_id=products.id WHERE order_id= ?');
    $query->bind_param('i', $orderId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
             $order_details[] = $rows;
        }
    } else {
         $order_details = null;
    }
    return  $order_details;
}

// Get all users
function get_all_users($role = null) {
    global $connect;
    $users = [];
    // Prepare the query 
    if (isset($role)) {
        $query = $connect->prepare('SELECT * FROM `users` WHERE `role` = ?');
        $query->bind_param('i', $role);
    } else {
        $query = $connect->prepare('SELECT * FROM `users`');
    }
    // Execute the query
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
             $users[] = $rows;
        }
    } else {
         $users = null;
    }
    return  $users;
}

//get all orders
function get_all_orders($status=null){
    global $connect;
    $orders = [];
    // Prepare the query 
    if (isset($role)) {
        $query = $connect->prepare('SELECT o.id AS orderId,o.status AS orderStatus, u.id AS userId, o.*, u.* FROM `orders` o JOIN `users` u ON o.client_id = u.id WHERE `status` = ?');
        $query->bind_param('i', $status);
    } else {
        $query = $connect->prepare('SELECT o.id AS orderId,o.status AS orderStatus, u.id AS userId, o.*, u.* FROM `orders` o JOIN `users` u ON o.client_id = u.id');
    }
    // Execute the query
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
             $orders[] = $rows;
        }
    } else {
         $orders = null;
    }
    return  $orders;
}


