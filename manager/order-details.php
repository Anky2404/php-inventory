<?php
include_once '../common/common-function.php';
//check manager logged in
manager_logged_in();

//get order id from url
$orderId = isset($_GET['edit']) ? intval(base64_decode($_GET['edit'])) : null;

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$general_error = isset($errors['general']) ? $errors['general'] : '';
unset($_SESSION['errors']);

$order_details = [];
$query = $connect->prepare('SELECT * FROM `order_details` od JOIN products ON od.product_id=products.id WHERE order_id= ?');
$query->bind_param('i', $orderId);
$query->execute();
$result = $query->get_result();
if ($result->num_rows > 0) {
    while ($rows = $result->fetch_assoc()) {
        $order_details[] = $rows;
    }
}

//get status colort
function getStatusColor($status)
{
    switch ($status) {
        case 'Placed':
            return 'blue';
        case 'Shipped':
            return 'purple';
        case 'Delivered':
            return 'green';
        case 'Canceled':
            return 'red';
        default:
            return 'grey';
    }
}


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
        // Check if all statuses are same
        $all_statuses_match = true;
        foreach ($order_details as $details) {
            if ($details['order_status'] !== $new_status) {
                $all_statuses_match = false;
                break;
            }
        }
        // If all statuses match 
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

<!DOCTYPE html>
<html lang="en">

<?php require_once 'mainFile/head.php';?>

<body>

    <?php require_once 'mainFile/header.php';?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <h2>Order's Details</h2>
            </div>
            <!-- show success message -->
            <?php if ($success_message): ?>
            <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif;?>

            <?php if ($general_error): ?>
            <div class="error-message" id="error-message"><?php echo htmlspecialchars($general_error); ?></div>
            <?php endif;?>

            <div class="blog-list">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Unit-Price</th>
                                <th>Total Qty</th>
                                <th>Order Status</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $id = 0;foreach ($order_details as $details) {$id++;?>
                            <tr>
                                <td><?=$id?></td>
                                <td><img src="../manager/uploads/<?=$details['image']?>" alt="image" title="img"></td>
                                <td><?=$details['product_name']?></td>
                                <td>$ <?=$details['product_price']?></td>
                                <td><?=$details['quantity']?></td>
                                <td>
                                    <?php $orderStatus = $details['order_status']; $statusColor = getStatusColor($orderStatus); ?>

                                    <span class="order-status <?= ($orderStatus === 'Delivered' || $orderStatus === 'Canceled') ? 'disabled' : '' ?>" 
                                        data-order-detail-id="<?=$details['order_detail_id']?>"
                                        style="cursor: <?= ($orderStatus === 'Delivered' || $orderStatus === 'Canceled') ? 'not-allowed' : 'pointer' ?>; background-color: <?=$statusColor?>;">
                                        <?=$orderStatus?>
                                    </span>

                                    <div class="order-status-options" style="display: none;">
                                        <?php if ($orderStatus === 'Placed') {
                                            echo '<div class="status-option" data-status="Shipped" data-order-id="'.$orderId.'" style="background-color: purple; cursor:pointer;">Shipped</div>';
                                            echo '<div class="status-option" data-status="Canceled" data-order-id="'.$orderId.'" style="background-color: red; cursor:pointer;">Canceled</div>';
                                        } elseif ($orderStatus === 'Shipped') {
                                            echo '<div class="status-option" data-status="Delivered" data-order-id="'.$orderId.'" style="background-color: green; cursor:pointer;">Delivered</div>';
                                        }
                                        ?>
                                    </div>
                                </td>


                                <td>$ <?=number_format($details['product_price'] * $details['quantity'], 2)?></td>
                            </tr>
                            <?php }?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('.order-status').on('click', function(e) {
                var $cell = $(this);
                var $options = $cell.next('.order-status-options');
                // Check if the status is disabled
                if ($cell.hasClass('disabled')) {
                    return;
                }
                // Toggle visibility of the options
                $options.toggle();
                // Hide any other options
                $('.order-status-options').not($options).hide();
            });
            $('.status-option').on('click', function() {
    var newStatus = $(this).data('status');
    var orderDetailId = $(this).closest('tr').find('.order-status').data('order-detail-id');
    var orderId = $(this).data('order-id');
    var $statusElement = $(this).closest('tr').find('.order-status');

    $.ajax({
        url: 'order-details.php',
        type: 'POST',
        data: {
            order_detail_id: orderDetailId,
            new_status: newStatus,
            order_id: orderId 
        },
        dataType: 'JSON',
        success: function(response) {
            if (response.success) {
                $('body').append('<div class="success-message">' + response.message + '</div>');
                setTimeout(function() {
                    $('.success-message').fadeOut();
                }, 3000);
                // Reload the page
                location.reload();
            }
        }
    });
});

        });
    </script>

</body>

</html>