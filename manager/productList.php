<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();
$products = [];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
    unset($_SESSION['success_message']);

    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
    $general_error = isset($errors['general']) ? $errors['general'] : '';
    unset($_SESSION['errors']);


//get category id
$catID = isset($_GET['catID']) ? base64_decode($_GET['catID']) : null;

$result = get_product_by_catId($catID);
if (isset($catID)) {

    $result = get_product_by_catId($catID);
    $products=$result['products'];

    
} else {
    
        $products = get_all_products();
    }

    if (isset($_POST['submit'])) {

        if ($_POST['update'] == 2) {

            $id = $_POST['User'];
            $upd = $_POST['update'];

            $query = "UPDATE `products` SET `status` = $upd WHERE id = '$id'";
            $res = mysqli_query($connect, $query);

            if ($res) {

                $_SESSION['errors']['general'] = 'PRODUCT STATUS IS INACTIVE SUCCESSFULLY';
                header('Location: productList.php');
                exit();

            }

        }

        if ($_POST['update'] == 1) {

            $id = $_POST['User'];
            $upd = $_POST['update'];

            $query = "UPDATE `products` SET `status` = $upd WHERE id = '$id'";
            $res = mysqli_query($connect, $query);

            if ($res) {

                $_SESSION['success_message'] = 'PRODUCT STATUS IS ACTIVE SUCCESSFULLY';
                header('Location: productList.php');
                exit();

            }
        }

    }



?>
<!DOCTYPE html>
<html lang="en">

<?php require_once 'mainFile/head.php';?>

<body>

<?php require_once 'mainFile/header.php';?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <h2>Product's List</h2> <a href="productAdd.php" class="btn">Add Products</a>
            </div>

            <?php if ($success_message): ?>
                <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif;?>

            <?php if ($general_error): ?>
                <div class="error-message" id="error-message"><?php echo htmlspecialchars($general_error); ?></div>
            <?php endif;?>


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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php
$count = 0;
foreach ($products as $key => $value) {?>

                            <tr>
                                <td><img src="./uploads/<?php echo $value['image']; ?>" height="100px"  /></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td>£<?php echo $value['product_price']; ?></td>
                                <td><?php echo $value['product_quantity']; ?></td>
                                <td><?php echo $value['storage_level']; ?></td>
                                <?php if ($value['product_status'] == 1) {?>
                                <td>
                                <form  method="POST">
                                    <input type="hidden" name="User" value="<?=$value['id'];?>">
                                    <input type="hidden" name="update" value="2">
                                    <button class="badge badge-success" type="submit" name="submit">ACTIVE</button>
                                </form>
                                </td>
                                <?php } else {?>
                                <td>
                                <form method="POST">
                                    <input type="hidden" name="User" value="<?=$value['id'];?>">
                                    <input type="hidden" name="update" value="1">
                                    <button class="badge bg-danger" name="submit" type="submit">INACTIVE</button>
                                </form>
                                </td>
                                <?php }?>
                                <td><a href="productAdd.php?edit=<?php echo base64_encode($value['id']); ?>"><i class="fa fa-edit"></a></i></td>
                            </tr>

                       <?php }?>

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