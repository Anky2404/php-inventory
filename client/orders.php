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

if(isset($_POST['order_id'])){
    $orderId=$_POST['order_id'];
    $status='Canceled';
    $query=$connect->prepare('UPDATE `orders` SET `status`= ? WHERE `id`= ?');
    $query->bind_param('si',$status,$orderId);
    if ($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Cancellation failed.']);
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

                <h2>Orders</h2>

            </div>
        </div>
    </section>

    <section class="order-table">
        <div class="container-wrap">
            <div class="row-wrap">
                <?php foreach ($orders as $order) {?>
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
                                <td><?= $order['status'] ?></td>
                                <td class="table-btn">
                                    <a href="#" class="cancel-order" data-order-id="<?= $order['id'] ?>">Cancel</a>
                                <a href="order-details.php?oId=<?=urlencode(base64_encode($order['id']))?>">View</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>
                <?php }?>

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
                    // Prevent form submission and show warning message
                    e.preventDefault();
                    $('#address-warning').show();
                }
            });
        });

        //handle cancel order click
        $('.cancel-order').on('click', function(e) {
        e.preventDefault(); 
        // Get the order id
        var orderId = $(this).data('order-id'); 
        // Show confirmation message
        var confirmation = confirm("Are you sure you want to cancel this order?");
        if (confirmation) {
            $.ajax({
                url: 'orders.php',
                type: 'POST',
                data: { order_id: orderId},
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

    <?php include_once 'layout/footer.php'?>
</body>

</html>