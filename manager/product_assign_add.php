<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();
$qry = "SELECT * FROM `users` Where `role` = 4";
$result = mysqli_query($connect,$qry); 
$out = [];
while($rows = mysqli_fetch_array($result)){
    $out[] = $rows;
}

$qry = "SELECT * FROM `products` Where `status` = 1";
$result = mysqli_query($connect,$qry); 
$output = [];
while($rows = mysqli_fetch_array($result)){
    $output[] = $rows;
}

if(isset($_POST['submit'])){

    $required_fields = ['product_name','vendor_name','quantity','address'];
    $error = [];

    foreach($required_fields as $key => $value){
        if(isset($_POST[$value]) && empty($_POST[$value])){
          $error[] = $value." is required";
        }
    }

    if(count($error) == 0){
    
        $product_name = $_POST['product_name'];
        $vendor_name = $_POST['vendor_name'];
        $quantity = $_POST['quantity'];
        $address = $_POST['address'];
    
    $query = "INSERT INTO `assigned` (`product_id`,`vendor_id`,`qty`,`address`) VALUES ('$product_name','$vendor_name','$quantity','$address')";
    $result = mysqli_query($connect,$query);
    
    if($result) {
        $_SESSION['success_message'] = 'Order Assign Was Successful';
        header('Location: product_assign.php');
    }
    }
    else{
        $_SESSION['errors']['general'] = 'Please complete all fields before Submitting.';
        header('Location: product_assign_add.php');
    exit();
    }
  }

?>

<?php 

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$general_error = isset($errors['general']) ? $errors['general'] : '';
unset($_SESSION['errors']);

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('mainFile/head.php'); ?>

<body>
<?php require_once('mainFile/header.php'); ?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <h2>Add Inventory Order</h2>
            </div>
            
            <?php if ($general_error): ?>
                <div class="error-message" id="error-message"><?php echo htmlspecialchars($general_error); ?></div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <div class="blog-form">
                <form method="post">
                    <div class="row">
                        <div class="col6">
                            <label for="name">Vendor Name</label>
                            <select name="vendor_name" required>
                              <?php foreach($out as $key => $val){ ?>
                                <option value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
                               <?php } ?>
                             </select>
                        </div>
                        <div class="col6">
                            <label for="name">Product Name</label>
                            <select name="product_name" required>
                            <?php foreach($output as $key => $val1){ ?>
                                <option value="<?= $val1['id'] ?>"><?= $val1['product_name'] ?></option>
                               <?php } ?>
                             </select>
                        </div>
                        <div class="col12">
                            <label for="name">Quantity</label>
                            <input type="number" name="quantity" placeholder="Enter Quantity" required>
                        </div>
                        <div class="col12">
                            <label for="name">Address</label>
                            <textarea class="form-control" name="address" placeholder="Address" required></textarea>
                        </div>
                        <div class="col12">
                            <div class="form-btn"><button type="submit" name="submit">Submit</button></div>
                        </div>
                    </div>
                </form>
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
                }, 2000);
            }
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 2000);
            }
        }

        hideMessage();
    </script>
</body>
</html>