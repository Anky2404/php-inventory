<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();
$qry = "SELECT * FROM `users` Where `role` = 4";
$result = mysqli_query($connect,$qry); 
$user = [];
while($rows = mysqli_fetch_array($result)){
$user[] = $rows;


if(isset($_POST['submit'])){

    if($_POST['update'] == 2){

    $id = $_POST['User'];
    $upd = $_POST['update'];
    
    $query = "UPDATE `users` SET `status` = $upd WHERE id = '$id'";
    $res = mysqli_query($connect,$query);
    
    if($res) {
        $_SESSION['errors']['general'] = 'VENDOR IS INACTIVE SUCCESSFULLY';
        header('Location: vendorList.php');
     exit();
      
}

}

if($_POST['update'] == 1){

    $id = $_POST['User'];
    $upd = $_POST['update'];
    
    $query = "UPDATE `users` SET `status` = $upd WHERE id = '$id'";
    $res = mysqli_query($connect,$query);
    
    if($res){

        $_SESSION['success_message'] = 'VENDOR IS ACTIVE SUCCESSFULLY';
        header('Location: vendorList.php');
        exit();

    }
  }
}

}
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
                <h2>Vendor List</h2><a href="vendorAdd.php" class="btn">Add Vendor</a>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php $count = 0;
                        foreach($user as $key => $value){ ?>

                            <tr>
                                <td><?php echo ++$count.'.'; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php echo $value['contact']; ?></td>
                                <td><?php echo $value['address']; ?></td>
                   
                                <?php if($value['status'] == 1){  ?> 
                                <td>
                                <form  method="POST">
                                    <input type="hidden" name="User" value="<?= $value['id'];?>">
                                    <input type="hidden" name="update" value="2">
                                    <button class="badge badge-success" type="submit" name="submit">ACTIVE</button>
                                </form>
                                </td>
                                <?php }
                                else{ ?>
                                <td>
                                <form method="POST">
                                    <input type="hidden" name="User" value="<?= $value['id'];?>">
                                    <input type="hidden" name="update" value="1">
                                    <button class="badge bg-danger" name="submit" type="submit">INACTIVE</button>
                                </form>
                                </td>
                                <?php } ?>
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