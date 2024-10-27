<?php
include_once '../common/common-function.php';

client_logged_in();
$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

// Get order ID from URL
$orderId = isset($_GET['oId']) ? intval(base64_decode($_GET['oId'])) : null;

// Get order details
$order = get_orders_by_id($orderId);

// Get order details by ID
$order_details = get_order_details_by_id($orderId);

// Set delivery charges
$delivery_charges = 25.00;

// Update order details status
if (isset($_POST['order_detail_id']) && isset($_POST['new_status']) && isset($_POST['order_id'])) {
    $order_detail_id = $_POST['order_detail_id'];
    $new_status = $_POST['new_status'];
    $order_id = $_POST['order_id'];
    
    $query = $connect->prepare('UPDATE `order_details` SET `order_status` = ? WHERE `order_detail_id` = ?');
    $query->bind_param('si', $new_status, $order_detail_id);
    if ($query->execute()) {
        // Fetch all order details
        $order_details = get_order_details_by_id($order_id);
        
        // Check if all statuses match
        $all_statuses_match = true;
        foreach ($order_details as $details) {
            if ($details['order_status'] !== $new_status) {
                $all_statuses_match = false;
                break;
            }
        }

        // Update main order status if all details match
        if ($all_statuses_match) {
            $update_order_query = $connect->prepare('UPDATE `orders` SET `status` = ? WHERE `id` = ?');
            $update_order_query->bind_param('si', $new_status, $order_id);
            $update_order_query->execute();
        }

        if ($new_status === 'Canceled') {
            $_SESSION['errors']['general'] = 'Order ' . $new_status . ' successfully.';
        } else {
            $_SESSION['success_message'] = 'Order ' . $new_status . ' successfully.'; 
        }
        echo json_encode(['success' => true, 'message' => 'Order updated successfully']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order']);
        exit;
    }
}
?>
<!doctype html>
<html lang="en">

<?php include_once 'layout/head.php' ?>

<body>
    <?php include_once 'layout/header.php' ?>
    <section class="inv-banner">
        <div class="container-wrap">
            <div class="inv-heading">
                <h2>Order Details</h2>
            </div>
        </div>
    </section>
    <section class="order-list">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col-4">
                    <div class="cart-box">
                        <h2>Payment Details</h2>
                        <ul>
                            <li>
                                <h3>Items</h3><span><?= $order['total_product'] ?></span>
                            </li>
                            <li>
                                <h3>Total Amount</h3><span>$
                                    <?= number_format($order['total_amount'] - $delivery_charges, 2) ?></span>
                            </li>
                            <li>
                                <h3>Delivery Fees</h3><span>$ <?= number_format($delivery_charges, 2) ?></span>
                            </li>
                            <li>
                                <h3>Grand Total</h3><span>$ <?= number_format($order['total_amount'], 2) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Customer Name</th>
                            <th>Product Name</th>
                            <th>Unit-Price</th>
                            <th>Total Qty</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 0; foreach ($order_details as $details) { $id++; ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td><img src="../manager/uploads/<?= $details['image'] ?>" alt="image" title="img"></td>
                            <td><?= $details['product_name'] ?></td>
                            <td>$ <?= $details['unit_price'] ?></td>
                            <td><?= $details['quantity'] ?></td>
                            <td>$ <?= number_format($details['unit_price'] * $details['quantity'], 2) ?></td>
                            <td>
                                <?php $orderStatus = $details['order_status']; ?>
                                <span class="order-status"
                                    style="background-color: <?= getStatusColor($orderStatus) ?>;">
                                    <?= $orderStatus ?>
                                </span>
                            </td>
                            <td>
                                <a href="#"
                                    class="cancel-order order-status <?= ($orderStatus !== 'Placed') ? 'disabled' : '' ?>"
                                    data-order-detail-id="<?= $details['order_detail_id'] ?>"
                                    data-order-id="<?= $details['order_id'] ?>">
                                    Cancel
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php include_once 'layout/footer.php' ?>
    <script>
        $(document).ready(function() {
            // Cancel order on click
            $('.cancel-order').on('click', function(e) {
                e.preventDefault();
                if ($(this).hasClass('disabled')) return;

                var orderDetailId = $(this).data('order-detail-id');
                var orderId = $(this).data('order-id');
                $.ajax({
                    url: 'order-details.php',
                    type: 'POST',
                    data: {
                        order_detail_id: orderDetailId,
                        order_id: orderId,
                        new_status: 'Canceled'
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success) {
                            $('body').append('<div class="success-message">' + response.message + '</div>');
                            setTimeout(function() {
                                $('.success-message').fadeOut();
                            }, 3000);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
