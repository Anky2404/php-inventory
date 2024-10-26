<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();
//show message after manger success full login
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$clients=get_all_users(2);
$staffs=get_all_users(3);
$products=get_all_products();
$orders=get_all_orders();






?>
<!DOCTYPE html>
<html lang="en">

<?php require_once 'mainFile/head.php';?>

<body>

    <?php require_once 'mainFile/header.php';?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <h2>Welcome Manager!</h2>
            </div>
            <?php if ($success_message): ?>
            <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif;?>
            <div class="dashboard-boxes">
                <div class="row">
                    <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>Total Clients</h4>
                                <i class="fa fa-users"></i>
                            </div>
                            <span><?=count($clients);?></span>
                        </div>
                    </div>
                    <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>Total Staffs</h4>
                                <i class="fa fa-user-plus"></i>
                            </div>
                            <span><?=count($staffs);?></span>
                        </div>
                    </div>
                    <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>Total Products</h4>
                                <i class="fa fa-th"></i> 
                            </div>
                            <span><?=count($products);?></span>
                        </div>
                    </div>
                    <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>Total Orders</h4>
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <span><?=count($orders);?></span>
                        </div>
                    </div>
                </div>

                <div class="blog-list">
                    <div class="heading" style="margin-top: 50px;">
                        <h2>Products Restock</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Current quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $id = 0;foreach ($products as $product) {
    if ($product['product_quantity'] <= 2 && $product['product_status'] == 1) {$id++;?>
                                <tr>
                                    <td><?=$id?></td>
                                    <td><img src="./uploads/<?php echo $product['image']; ?>" height="100px" /></td>
                                    <td><?=$product['product_name']?></td>
                                    <td><?=$product['name']?></td>
                                    <td> <?=$product['product_quantity']?></td>
                                    <td><a href="productAdd.php?edit=<?php echo base64_encode($product['id']); ?>"
                                            title="Update Quantity"><i class="fa fa-edit"></a></i></td>
                                </tr>
                                <?php }
}?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function hideSuccessMessage() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }
        }
        hideSuccessMessage();
    </script>

</body>

</html>