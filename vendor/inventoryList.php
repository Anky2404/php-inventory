<?php include_once('../common/vendor-common-function.php');

vender_logged_in();


$id = $_SESSION['vendor']['id'];

$qry = "SELECT products.product_name as product_name, users.name as vendor_name , assigned.*
FROM `assigned`
INNER JOIN `products` ON  assigned.product_id = products.id
INNER JOIN `users` ON assigned.vendor_id = users.id
WHERE assigned.vendor_id = '$id'";

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
                <h2>Inventory Order's List</h2> 
            </div>

            <div class="blog-list">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                                <th>Sr.No</th>
                                <th>Product Name</th>
                                <th>Assigned Vendor Name</th>
                                <th>Quantity</th>
                                <th>Shipping Address</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                      <?php 
                        $count = 0;
                        foreach($product as $key => $value){ ?>

                             <tr>
                                <td><?php echo ++$count.'.'; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><?php echo $value['vendor_name']; ?></td>
                                <td><?php echo $value['qty']; ?></td>
                                <td><?php echo $value['address']; ?></td>
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