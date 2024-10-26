<?php include_once('../common/vendor-common-function.php');

vender_logged_in();


$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

unset($_SESSION['success_message']);



$id = $_SESSION['vendor']['id'];

$qry = "SELECT products.product_name as product_name, users.name as vendor_name ,assigned.*
FROM `assigned`
INNER JOIN `products` ON  assigned.product_id = products.id
INNER JOIN `users` ON assigned.vendor_id = users.id
WHERE assigned.vendor_id = '$id'";
$result = mysqli_query($connect,$qry); 
$user = [];
while($rows = mysqli_fetch_array($result)){
$user[] = $rows;
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
                <h2>Welcome Vendor!</h2>
            </div>
            <?php if ($success_message): ?>
                <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            <div class="dashboard-boxes">
                <div class="row">
                    <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>Inventory Order's</h4>
                                <i class="fa fa-user"></i>
                            </div>
                            <span><?= count($user); ?></span>
                        </div>
                    </div>
                    <!-- <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>New Order's</h4>
                                <i class="fa fa-user"></i>
                            </div>
                            <span>4</span>
                        </div>
                    </div> -->
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