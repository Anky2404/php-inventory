<?php
include_once '../common/common-function.php';

//get user id from session
$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
//get product id from url
$productId = isset($_GET['id']) ? $_GET['id'] : null;
//get product details by id
$details = get_product_details_by_id($productId);
//get offer details by product id
$offer=get_offers_details_by_productId($productId)?:null;

// Handle add product to cart
if (isset($_POST['addtocart'])) {
    $addedby = $userId;
    $proId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price']-$offer['discount_percentage'];

    // Check product is already in the cart
    $query = $connect->prepare('SELECT * FROM `carts` WHERE `added_by` = ? AND `product_id` = ?');
    $query->bind_param("ii", $addedby, $proId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        // Product already in cart
        echo '<script>alert("This product is already in your cart.");
         window.location.href="shop.php"; 
         </script>';
    } else {
        // Prepare the insert statement
        $query1 = $connect->prepare('INSERT INTO `carts` (`added_by`, `product_id`, `unit_price`, `quantity`) VALUES (?, ?, ?, ?)');
        $query1->bind_param("iisi", $addedby, $proId, $unit_price, $quantity);
        if ($query1->execute()) {
            echo '<script>alert("Product added to cart successfully!");
        window.location.href="cart.php"; 
        </script>';
        } else {
            echo '<script>alert("Failed to add product to cart.");
        window.location.href="shop.php";
        </script>';
        }
    }
}


?>

<!doctype html>
<html lang="en">
<?php include_once 'layout/head.php'?>

<body>

    <?php include_once 'layout/header.php'?>

    <section class="inv-banner">
        <div class="container-wrap">
            <div class="inv-heading">

                <h2>Product Detail</h2>
                <p>We Offer a comprehensive range of services designed to optimize every aspect of your inventory
                    Management. </p>
            </div>
        </div>
    </section>

    <section class="product-detail">
        <div class="container-wrap">
            <div class="row-wrap">

                <div class="col8">
                    <div class="detail-left">
                        <h2><?=$details['product_name']?></h2>
                        <div class="image">
                            <img src="../manager/uploads/<?=$details['image']?>" alt="product" title="product">
                        </div>
                        <div class="col4">
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?=$userId?>" required>
                                <input type="hidden" name="product_id" value="<?=$productId?>" required>
                                <input type="hidden" name="unit_price" value="<?=$details['product_price']?>" required>
                                <input type="hidden" name="quantity" value="1" required>
                                <?php if ($details['product_quantity'] > 0) { ?>
                                <?php if (isset($_SESSION['user'])) { ?>
                                <button class="btn" name="addtocart" type="submit">Add to Cart</button>
                                <?php } else { ?>
                                <a class="btn" href="login.php" title="Login first to add product to cart">Add to
                                    Cart</a>
                                <?php } ?>
                                <?php } else { ?>
                                <a class="btn" href="#" title="Out Of Stock" aria-disabled="true">Out of Stock</a>
                                <?php } ?>

                            </form>
                        </div>

                        <p><?=$details['product_description']?></p>
                    </div>
                </div>

                <div class="col4">
                    <div class="detail-right product-list">
                        <div class="price">
                            <?php if(isset($offer)){  ?>
                            <h3 style="text-align:left;" class="price1">$ <?=$details['product_price']?></h3>
                            <?php } ?>
                            <h3 style="text-align:left;">
                                $<?= number_format($details['product_price']-$offer['discount_percentage']?:0, 2); ?>
                            </h3>
                        </div>
                        <p style="text-align:left;"><?=$details['product_description']?></p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="newsletters">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col-6">
                    <div class="newsletter-left">
                        <h2>Subscribe Our Newsletter</h2>
                        <p>Subscribe to our newsletter to receive early discount offers, updates and info</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="newsletter-right">
                        <form action="">
                            <div class="input-field">
                                <input type="email" placeholder="Enter Your Email" readOnly>
                                <button>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once 'layout/footer.php'?>

</body>

</html>