<?php

session_start();
require_once('./DBconnection.php');

if(!isset($_SESSION['staff'])){
    echo '<script>
    window.location.href="login.php";
    </script>';
    exit();
}

//get order id from url
$orderId = isset($_GET['edit']) ? intval(base64_decode($_GET['edit'])) : null;

$order_details = [];
$query=$connect->prepare('SELECT * FROM `order_details` od JOIN products ON od.product_id=products.id WHERE order_id= ?');
$query->bind_param('i', $orderId);
$query->execute();
$result = $query->get_result();
if ($result->num_rows > 0) {
    while ($rows = $result->fetch_assoc()) {
         $order_details[] = $rows;
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
                <h2>Order's Details</h2>
            </div>

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
                            <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $id=0; foreach ($order_details as $details) { $id++; ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td> <img src="../manager/uploads/<?=$details['image']?>" alt="image" title="img"></td>
                            <td><?=$details['product_name']?></td>
                            <td>$ <?=$details['product_price']?></td>
                            <td><?=$details['quantity']?></td>
                            <td>$ <?= number_format($details['product_price'] * $details['quantity'], 2) ?></td>

                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>
</html>