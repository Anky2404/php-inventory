<?php

session_start();
require_once('./DBconnection.php');

if(!isset($_SESSION['staff'])){
    echo '<script>
    window.location.href="login.php";
    </script>';
    exit();
}

$qry = "SELECT o.id AS orderId,o.status AS orderStatus, u.id AS userId, o.*, u.* FROM `orders` o JOIN `users` u ON o.client_id = u.id";

$result = mysqli_query($connect,$qry); 
$product = [];
while($rows = mysqli_fetch_array($result)){
    $product[] = $rows;
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
                                <td><?php echo $value['orderStatus'] ?></td>       
                                <td><?= date("d M Y", strtotime($value['placed_at'])) ?></td>
                                <td><a href="order-details.php?edit=<?php echo base64_encode($value['orderId']); ?>"><i class="fa fa-edit"></a></i></td>
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