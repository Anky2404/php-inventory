<?php
include_once '../common/common-function.php';

client_logged_in();
$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

//get client order
$orders = get_client_orders($userId);
if (empty($orders)) {

    echo '<script>alert("First, You Place The Order.");
        window.location.href="shop.php";
        </script>';
    exit();
}

// Update order status
if (isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    $query = $connect->prepare('UPDATE `orders` SET `status` = ? WHERE `id` = ?');
    $query->bind_param('si', $new_status, $order_id);
    if ($query->execute()) {
        //update order details status
        $query1 = $connect->prepare('UPDATE `order_details` SET `order_status`= ? WHERE `order_id`= ?');
        $query1->bind_param('si', $new_status, $order_id);
        if ($query1->execute()) {
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

                <h2>Orders</h2>

            </div>
        </div>
    </section>

    <section class="order-table">
        <div class="container-wrap">
            <div class="row-wrap">
                <?php foreach ($orders as $order) { ?>
                <div class="col-6">

                    <table>
                        <thead>
                            <tr>
                                <th>Order ID </th>
                                <th>Order Date </th>
                                <th>Total Item </th>
                                <th>Total Amount </th>
                                <th>status </th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>ORD_00<?= $order['id'] ?></td>
                                <td><?= date("d M Y", strtotime($order['placed_at'])) ?></td>
                                <td><?= $order['total_product'] ?></td>
                                <td>$ <?= $order['total_amount'] ?></td>
                                <td>
                                    <?php $orderStatus = $order['status']; ?>
                                    <span class="order-status"
                                        style="background-color: <?= getStatusColor($orderStatus) ?>;">
                                        <?= $orderStatus ?>
                                    </span>
                                </td>
                                <td class="table-btn">
                                    <a href="#"
                                        class="cancel-order order-status <?= ($orderStatus !== 'Placed') ? 'disabled' : '' ?>"
                                        data-order-id="<?= $order['id'] ?>"
                                        <?= ($orderStatus !== 'Placed') ? 'style="pointer-events: none; color: grey; cursor: not-allowed;"' : '' ?>>
                                        Cancel
                                    </a>
                                    <a href="order-details.php?oId=<?= urlencode(base64_encode($order['id'])) ?>"
                                        class="order-status" style="background-color:cornflowerblue">
                                        View
                                    </a>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>
                <?php } ?>

            </div>
        </div>

    </section>

    <script>
        $(document).ready(function() {
            // Handle address selection
            $('input[name="selected_address"]').change(function() {
                // Hide the warning message
                $('#address-warning').hide();
            });
            // Handle form submission
            $('#order-form').submit(function(e) {
                var selectedAddress = $('input[name="selected_address"]:checked');
                if (selectedAddress.length > 0) {
                    // Set the value of the hidden input to the selected address
                    $('#selected_address').val(selectedAddress.val());
                } else {
                    // Prevent form submission 
                    e.preventDefault();
                    $('#address-warning').show();
                }
            });
        });
        // Handle cancel order click
        $('.cancel-order').on('click', function(e) {
            // Prevent action if button is disabled
            if ($(this).hasClass('disabled')) {
                e.preventDefault();
                return;
            }
            e.preventDefault();
            // Get the order id
            var orderId = $(this).data('order-id');
            // Show confirmation message
            var confirmation = confirm("Are you sure you want to cancel this order?");
            if (confirmation) {
                $.ajax({
                    url: 'orders.php',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        new_status: 'Canceled'
                    },
                    success: function(response) {
                        // Handle success response
                        alert('Order cancelled successfully.');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        alert('An error occurred while cancelling the order. Please try again.');
                    }
                });
            }
        });
    </script>

    <?php include_once 'layout/footer.php' ?>
</body>

</html>