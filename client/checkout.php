<?php
include_once '../common/common-function.php';
include_once '../common/mailfunction.php';

client_logged_in();
$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
$del_address = client_dilevery_address($userId);
$carts = get_client_cart_item($userId);
$total_item = 0;
$total_amount = 0.0;
$delivery_charges = 25.0;

if (empty($carts)) {
    echo '<script>alert("your cart is empty !");
    window.location.href="shop.php";
    </script>';
    exit();
}

// Get total product and total amount of cart
foreach ($carts as $cart) {
    $total_item += $cart['quantity'];
    $total_amount += $cart['quantity'] * $cart['unit_price'];
}

// Handle placed order
if (isset($_POST['order_placed'])) {
    //get data from form
    $address_id = $_POST['selected_address'];
    $status = 'Placed';
    $delivery_email = dilevery_address_by_id($address_id)['email'];
    $delivery_name = dilevery_address_by_id($address_id)['fullname'];

    // Insert details in orders table
    $query = $connect->prepare('INSERT INTO `orders`(`client_id`, `address_id`, `status`) VALUES (?, ?, ?)');
    $query->bind_param('iis', $userId, $address_id, $status);
    $query->execute();

    // Get the last inserted order ID
    $order_id = $connect->insert_id;

    // Get total product and total amount of cart
    foreach ($carts as $cart) {
        $product_id = $cart['product_id'];
        $unit_price = $cart['unit_price'];
        $quantity = $cart['quantity'];
        $total_price = $cart['unit_price'] * $cart['quantity'];

        // Add cart product in order details
        $query1 = $connect->prepare('INSERT INTO `order_details`(`order_id`, `product_id`, `unit_price`, `quantity`, `total_amount`) VALUES (?,?,?,?,?)');
        $query1->bind_param('iidid', $order_id, $product_id, $unit_price, $quantity, $total_price);
        if($query1->execute()){
            //get product details by id
            $product=get_product_details_by_id($product_id);
            //update quantity
            $new_quantity=$product['product_quantity']-$quantity;
            //update product quantity after order placed
            $query2=$connect->prepare('UPDATE `products` SET `product_quantity`= ? WHERE `id`= ?');
            $query2->bind_param('ii', $new_quantity,$product_id);
            $query2->execute();
        }
    }

    // Update total product and amount in orders table
    $grand_total = $total_amount + 25;
    $query3 = $connect->prepare('UPDATE `orders` SET `total_product` = ?, `total_amount` = ? WHERE `id` = ?');
    $query3->bind_param('idi', $total_item, $grand_total, $order_id);
    if ($query3->execute()) {
        //empty cart item by client id
        empty_cart_item_by_clientId($userId);
        $to = $delivery_email;
        $toName = $delivery_name;
        $subject = 'Booking Request';
        $body = 'Hi ' . htmlspecialchars($delivery_name) . ",\n\n" .
            "Thank you for your order! We are pleased to confirm that Your order has been placed successfully.\n\n If you have any questions or need assistance, feel free to reach out to us.\n\n" .
            "Best regards,\n" .
            "Inventory Manager";

        sendEmail($to, $toName, $subject, $body);
        echo '<script>alert("Order placed successfully!");
        window.location.href="orders.php";
        </script>';
    } else {
        echo "Failed to update order totals.";
    }
}

if (isset($_POST['add_address'])) {
    // Retrieve and sanitize form data
    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $zip = trim($_POST['zip']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
    $address = trim($_POST['address']);
    $client_id = trim($_POST['client_id']);

    // validate of all required fields
    if (empty($fullname) || empty($email) || empty($phone) || empty($zip) ||
        empty($city) || empty($state) || empty($country) || empty($address)) {
        echo "Please fill in all fields.";die;
    }

    $query2 = $connect->prepare('INSERT INTO `delivery_address`(`client_id`, `fullname`, `email`, `phone`, `address`, `city`, `state`, `country`, `zipcode`) VALUES (?,?,?,?,?,?,?,?,?)');
    // Bind the parameters
    $query2->bind_param('issssssss', $client_id, $fullname, $email, $phone, $address, $city, $state, $country, $zip);
    // Execute the query
    if ($query2->execute()) {
        echo '<script>alert("Address added successfully!");window.location.href="checkout.php";</script>';
        // show error
    } else {
        echo "Error executing the query: " . $query2->error;
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

                <h2>Booking</h2>
                <p>InventoryMax streamlines booking, ensuring accurate stock levels, real-time updates, and smooth
                    operations for better inventory management.</p>
            </div>
        </div>
    </section>
    <section class="checkout">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col4">
                    <div class="cart-box">
                        <h2>Cart Details</h2>
                        <ul>
                            <li>
                                <h3>Items</h3><span><?=$total_item?></span>
                            </li>
                            <li>
                                <h3>Total Amount</h3><span>$ <?=number_format($total_amount, 2)?></span>
                            </li>
                            <li>
                                <h3>Dilevery Fees</h3><span>$ <?=number_format($delivery_charges, 2)?></span>
                            </li>
                            <li>
                                <h3>Grand Total</h3><span>$
                                    <?=number_format($total_amount + $delivery_charges, 2)?></span>
                            </li>
                        </ul>
                        <div id="address-warning" style="color: red; display: none;">Please select an address to place
                            your
                            order.</div>
                        <form id="order-form" method="post">
                            <input type="hidden" name="selected_address" id="selected_address" value="">
                            <button type="submit" id="order-button" name="order_placed">Order Placed</button>
                        </form>
                    </div>

                </div>
                <div class="col8">
                    <div class="save-address">
                        <div class="select-addrees">
                            <h3>Select Address</h3><button id="toggle-form">Add New Address</button>
                        </div>

                        <div class="address-list">
                            <?php foreach ($del_address as $add) { ?>
                            <div class="address-option">
                                <ul>
                                    <li>
                                        <input type="checkbox" class="address-checkbox" value="<?=$add['address_id']?>"
                                            id="address-<?=$add['address_id']?>" required>
                                        <label for="address-<?=$add['address_id']?>"></label>
                                    </li>
                                    <li>
                                        <h4>Name:</h4>
                                        <span><?=htmlspecialchars($add['fullname'])?></span>
                                    </li>
                                    <li>
                                        <h4>Address:</h4>
                                        <span><?=htmlspecialchars($add['address'])?>,
                                            <?=htmlspecialchars($add['city'])?>, <?=htmlspecialchars($add['state'])?>,
                                            <?=htmlspecialchars($add['zipcode'])?></span>
                                    </li>
                                    <li>
                                        <h4>Email:</h4>
                                        <span><?=htmlspecialchars($add['email'])?></span>
                                    </li>
                                    <li>
                                        <h4>Phone:</h4>
                                        <span><?=htmlspecialchars($add['phone'])?></span>
                                    </li>
                                </ul>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="booking-form" style="display: none;">
                            <form method="post">
                                <div class="input-box">
                                    <div class="input-field">
                                        <label>Your Name</label>
                                        <input type="text" name="name" placeholder="Your Name" required>
                                    </div>
                                    <div class="input-field">
                                        <label>Email</label>
                                        <input type="email" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <div class="input-field">
                                        <label>Phone</label>
                                        <input type="text" name="phone" placeholder="Phone" required>
                                    </div>
                                    <div class="input-field">
                                        <label>Zip Code</label>
                                        <input type="text" name="zip" placeholder="Zip Code" maxlength="6" required
                                            pattern="[0-9]{6}">
                                    </div>
                                </div>
                                <div class="input-box">
                                    <div class="input-field">
                                        <label>City</label>
                                        <input type="text" name="city" placeholder="City" required>
                                    </div>
                                    <div class="input-field">
                                        <label>State</label>
                                        <input type="text" name="state" placeholder="State" required>
                                    </div>
                                    <div class="input-field">
                                        <label>Country</label>
                                        <input type="text" name="country" placeholder="Country" required>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <label>Address</label>
                                    <textarea name="address" placeholder="Address" required></textarea>
                                </div>
                                <input type="hidden" name="client_id" value="<?=$userId?>" required>
                                <button type="submit" name="add_address">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Handle checkbox selection
            $('.address-checkbox').change(function() {
                // toggle checked
                if ($(this).is(':checked')) {
                    $('.address-checkbox').not(this).prop('checked', false);
                }
                // Hide the warning message
                $('#address-warning').hide();
            });
            // Handle form submission
            $('#order-form').submit(function(e) {
                var selectedAddresses = $('.address-checkbox:checked');
                if (selectedAddresses.length > 0) {
                    // Set the value of the hidden input to the selected addresses
                    var addresses = selectedAddresses.map(function() {
                        return $(this).val();
                    }).get().join(', ');
                    $('#selected_address').val(addresses);
                } else {
                    // Prevent form submission
                    e.preventDefault();
                    $('#address-warning').show();
                }
            });
            $('#toggle-form').on('click', function() {
                // Toggle address list show
                $('.address-list').toggle();
                // Toggle form show
                $('.booking-form').toggle();
                // Change button text
                $(this).text($(this).text() === 'Add New Address' ? 'X Close Form' : 'Add New Address');
            });
            $('#close-form').on('click', function() {
                // Show address list
                $('.address-list').show();
                // Hide form
                $('.booking-form').hide();
                // Reset button text
                $('#toggle-form').text('Add New Address');
            });
        });
    </script>

    <?php include_once 'layout/footer.php'?>
</body>

</html>