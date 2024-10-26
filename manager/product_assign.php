<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();

$qry = "SELECT products.product_name as product_name, users.name as vendor_name ,assigned.*
FROM `assigned`
INNER JOIN `products` ON  assigned.product_id = products.id
INNER JOIN `users` ON assigned.vendor_id = users.id";
$result = mysqli_query($connect,$qry); 
$user = [];
while($rows = mysqli_fetch_array($result)){
$user[] = $rows;
}

// print_r($user);die;
?>
<?php
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$general_error = isset($errors['general']) ? $errors['general'] : '';
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('mainFile/head.php'); ?>

<body>

<?php require_once('mainFile/header.php'); ?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <h2>Inventory Order's List</h2><a href="product_assign_add.php" class="btn">Add Inventory-Order</a>
            </div>

            <?php if ($success_message): ?>
                <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <?php if ($general_error): ?>
                <div class="error-message" id="error-message"><?php echo htmlspecialchars($general_error); ?></div>
            <?php endif; ?>

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
                    <?php $count = 0;
                        foreach($user as $key => $value){ ?>

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

    <script>     
        function hideMessage() {
            var successMessage = document.getElementById('success-message');
            var errorMessage = document.getElementById('error-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000);
            }
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 3000);
            }
        }
        hideMessage();
    </script>

</body>
</html>