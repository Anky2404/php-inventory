<?php
include_once '../common/common-function.php';

client_logged_in();
$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
$del_address = client_dilevery_address($userId);
$carts = get_client_cart_item($userId) ?? [];
$total_item = 0;
$total_amount = 0.0;
$delivery_charges = 25.0;

//check cart is not empty
if (empty($carts)) {
    echo '<script>alert("Your cart is empty. Please add items to your cart first.");
        window.location.href="shop.php"; 
        </script>';
    exit();
}


if (isset($_POST['id'])) {
    $itemId = $_POST['id'];
    $query = $connect->prepare('DELETE FROM `carts` WHERE  `cart_id`=?');
    $query->bind_param('i', $itemId);
    if ($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Unable to remove item.']);
    }
}

//handle update cart quantity
if (isset($_POST['cart_id'])) {
    $cartId = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    $addedBy = $userId; 

    // Prepare the update statement
    $query = $connect->prepare('UPDATE `carts` SET `quantity` = ? WHERE `cart_id` = ?');
    $query->bind_param("ii", $quantity, $cartId);
    if ($query->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
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

                <h2>Cart</h2>

            </div>

        </div>
    </section>

    <section class="cart1">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col-8">
                    <table>
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $id = 0;foreach ($carts as $cart) {$id++;
    $total_item += $cart['quantity'];
    $total_amount += $cart['quantity'] * $cart['unit_price'];?>
                            <tr>
                                <td><?=$id?></td>
                                <td><img src="../manager/uploads/<?=$cart['image']?>" alt="image" title="img"></td>
                                <td><?=$cart['product_name']?></td>
                                <td>$ <?=$cart['unit_price']?></td>
                                <td><input type="number" value="<?=$cart['quantity']?>" min="1" max="3"
                                        class="cart-quantity" data-cart-id="<?=$cart['cart_id']?>"></td>
                                <td>$ <?=number_format($cart['unit_price'] * $cart['quantity'], 2)?></td>
                                <td>
                                    <a href="#" class="remove-item" data-id="<?=$cart['cart_id']?>">Remove</a>
                                </td>
                            </tr>
                            <?php }?>

                        </tbody>
                    </table>
                </div>
                <div class="col-4">
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
                        <button onclick="redirectToCheckout()">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('.remove-item').on('click', function(e) {
                e.preventDefault();
                //get item id
                var itemId = $(this).data('id');
                // Show a confirmation dialog
                if (confirm('Do you want to remove this item from your cart?')) {
                    $.ajax({
                        url: 'cart.php',
                        type: 'POST',
                        data: {
                            id: itemId
                        },
                        success: function(response) {
                            // handle success
                            if (response) {
                                location.reload();
                            } else {
                                alert('Failed to remove item: ' + response.message);
                            }
                        }.bind(this),
                        error: function() {
                            alert('An error occurred while removing the item.');
                        }
                    });
                }
            });
            //update cart quantity
            $('.cart-quantity').on('change', function() {
                var newQuantity = $(this).val();
                var cartId = $(this).data('cart-id');
                if (newQuantity < 1 || newQuantity > 3) {
                    alert("Quantity must be between 1 and 3.");
                    return;
                }
                $.ajax({
                    url: 'cart.php',
                    type: 'POST',
                    data: {
                        cart_id: cartId,
                        quantity: newQuantity
                    },
                    success: function(response) {
                        // Reload the page
                        location.reload();
                    },
                    error: function() {
                        alert("Failed to update cart.");
                    }
                });
            });
        });

        function redirectToCheckout() {
            window.location.href = 'checkout.php';
        }
    </script>

    <?php include_once 'layout/footer.php'?>
</body>

</html>