<?php
include_once '../common/common-function.php';

client_logged_in();
$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

//get order id from url
$orderId = isset($_GET['oId']) ? intval(base64_decode($_GET['oId'])) : null;

//get order details
$order=get_orders_by_id($orderId);

//get order details by id
$order_details=get_order_details_by_id($orderId);
//set delivery changes
$delivery_charges=25.00;






?>
<!doctype html>
<html lang="en">

<?php include_once 'layout/head.php'?>

<body>

    <?php include_once 'layout/header.php'?>
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
                                    <?=number_format($order['total_amount']-$delivery_charges, 2)?></span>
                            </li>
                            <li>
                                <h3>Dilevery Fees</h3><span>$ <?=number_format($delivery_charges, 2)?></span>
                            </li>
                            <li>
                                <h3>Grand Total</h3><span>$ <?=number_format($order['total_amount'], 2)?></span>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id=0; foreach ($order_details as $details) { $id++; ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td> <img src="../manager/uploads/<?=$details['image']?>" alt="image" title="img"></td>
                            <td><?=$details['product_name']?></td>
                            <td>$ <?=$details['unit_price']?></td>
                            <td><?=$details['quantity']?></td>
                            <td>$ <?= number_format($details['unit_price'] * $details['quantity'], 2) ?></td>
                            <td>
                                <a href="#" class="cancel-order" data-order-id="<?= $order['id'] ?>">Cancel</a>
                            </td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php include_once 'layout/footer.php'?>

</body>

</html>