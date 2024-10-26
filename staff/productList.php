<?php
session_start();

if(!isset($_SESSION['staff'])){
    echo '<script>
    window.location.href="login.php";
    </script>';
    exit();
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$general_error = isset($errors['general']) ? $errors['general'] : '';
unset($_SESSION['errors']);

require_once('./DBconnection.php');

$qry = "SELECT * FROM `products`";
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
                <h2>Product's List</h2> 
            </div>

            <?php if ($success_message): ?>
                <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <div class="blog-list">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Unit-Price</th>
                                <th>Quantity</th>
                                <th>Storage Name</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php 
                        $count = 0;
                        foreach($product as $key => $value){ ?>

                            <tr>
                                <td><img src="../manager/uploads/<?php echo $value['image']; ?>" height="100px"  /></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td>£<?php echo $value['product_price']; ?></td>
                                <td><?php echo $value['product_quantity']; ?></td>
                                <td><?php echo $value['storage_level']; ?></td>
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