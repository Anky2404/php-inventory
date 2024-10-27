<?php
include_once '../common/common-function.php';
//check manager logged in
manager_logged_in();

$qry = "SELECT o.id AS orderId,o.status AS orderStatus, u.id AS userId, o.*, u.* FROM `orders` o JOIN `users` u ON o.client_id = u.id";


$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$general_error = isset($errors['general']) ? $errors['general'] : '';
unset($_SESSION['errors']);


$result = mysqli_query($connect,$qry); 
$product = [];
while($rows = mysqli_fetch_array($result)){
    $product[] = $rows;
}



// Update order status
if (isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    $query = $connect->prepare('UPDATE `orders` SET `status` = ? WHERE `id` = ?');
    $query->bind_param('si', $new_status, $order_id);
    if ($query->execute()) {
            //update order details status
            $query1=$connect->prepare('UPDATE `order_details` SET `order_status`= ? WHERE `order_id`= ?');
            $query1->bind_param('si', $new_status, $order_id);
            if ($query1->execute()) {
            if($new_status === 'Canceled'){
                $_SESSION['errors']['general'] = 'Order ' . $new_status . ' successfully.';
            }else{
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
<!DOCTYPE html>
<html lang="en">

<?php require_once('mainFile/head.php'); ?>

<body>

<?php require_once('mainFile/header.php'); ?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <h2>Order's List</h2>
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
                                <th>Order Number</th>
                                <th>Customer Name</th>
                                <th>Total Qty</th>
                                <th>Total Amount</th>
                                <th>Order Status</th>
                                <th>Placed At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php foreach($product as $key => $value){?>
                            <tr>
                                <td><?php echo $value['orderId'] ?></td>
                                <td><?php echo $value['name'] ?></td>
                                <td><?php echo $value['total_product'] ?></td> 
                                <td>$<?php echo $value['total_amount'] ?></td>
                                <td>
                                <?php 
                                // Check order details status by order id
                                $order_details = get_order_details_by_id($value['orderId']);
                                $change_status=true;

                                foreach ($order_details as $details) {
                                    //check order status and order details is not same
                                    if ($details['order_status'] !== $value['orderStatus']) {
                                        $change_status=false;
                                    } 
                                }
                                ?>

                                    <?php $orderStatus = $value['orderStatus']; $statusColor = getStatusColor($orderStatus); ?>

                                    <span
                                        class="order-status <?= ($orderStatus === 'Delivered' || $orderStatus === 'Canceled' || !$change_status) ? 'disabled' : '' ?>"
                                        data-order-id="<?=$value['orderId']?>"
                                        style="cursor: <?= ($orderStatus === 'Delivered' || $orderStatus === 'Canceled' || !$change_status) ? 'not-allowed' : 'pointer' ?>; background-color: <?=$statusColor?>;">
                                        <?=$orderStatus?>
                                    </span>

                                    <div class="order-status-options" style="display: none;">
                                        <!-- show order option according to status -->
                                        <?php if ($orderStatus === 'Placed') {
                                                echo '<div class="status-option" data-status="Shipped" style="background-color: purple; cursor:pointer;">Shipped</div>';
                                                echo '<div class="status-option" data-status="Canceled" style="background-color: red; cursor:pointer;">Canceled</div>';
                                            } elseif ($orderStatus === 'Shipped') {
                                                echo '<div class="status-option" data-status="Delivered" style="background-color: green; cursor:pointer;">Delivered</div>';
                                            }
                                            ?>
                                    </div>
                                </td>
   
                                <td><?= date("d M Y", strtotime($value['placed_at'])) ?></td>
                                <td><a href="order-details.php?edit=<?php echo base64_encode($value['orderId']); ?>"><i class="fa fa-eye"></a></i></td>
                            </tr>
                  <?php } ?>
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
                var orderId = $(this).closest('tr').find('.order-status').data('order-id');
                var $statusElement = $(this).closest('tr').find('.order-status');
                $.ajax({
                    url: 'orderList.php',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        new_status: newStatus
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            $('body').append('<div class="success-message">' + response
                                .message + '</div>');
                            setTimeout(function() {
                                $('.success-message').fadeOut();
                            }, 3000);
                            // Reload the page
                            location.reload();
                        }
                    }
                });
            });
            // Close options if clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.order-status').length) {
                    // Hide all options
                    $('.order-status-options').hide(); 
                }
            });
        });
    </script>

</body>
</html>
