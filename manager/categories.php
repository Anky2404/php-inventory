<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$general_error = isset($errors['general']) ? $errors['general'] : '';
unset($_SESSION['errors']);

//get all categories
$id = 0;
$categories = get_all_categories();
if (isset($_POST['submit'])) {

    if ($_POST['update'] == 0) {

        $id = $_POST['User'];
        $upd = $_POST['update'];

        $query = "UPDATE `categories` SET `status`= $upd WHERE `cat_id`='$id'";
        $res = mysqli_query($connect, $query);

        if ($res) {

            $_SESSION['errors']['general'] = 'CATEGORY STATUS IS INACTIVE SUCCESSFULLY';
            header('Location: categories.php');
            exit();

        }

    }

    if ($_POST['update'] == 1) {

        $id = $_POST['User'];
        $upd = $_POST['update'];

        $query = "UPDATE `categories` SET `status`= $upd WHERE `cat_id`='$id'";
        $res = mysqli_query($connect, $query);

        if ($res) {

            $_SESSION['success_message'] = 'CATEGORY STATUS IS ACTIVE SUCCESSFULLY';
            header('Location: categories.php');
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
                <h2>Categorie's List</h2> <a href="add-category.php" class="btn">Add Categories</a>
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
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Total Product</th>
                                <th>Status</th>
                                <th>Created AT</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            foreach ($categories as $category) {$count++;?>

                            <tr>
                                <td><?=$count?></td>
                                <td><?=$category['name']?></td>
                                <td><?=$category['description']?></td>
                                <td><?=get_product_by_catId($category['cat_id'])['total_products']?></td>
                                <td>
                                    <?php if ($category['status'] == 1) {?>
                                    <form method="POST">
                                        <input type="hidden" name="User" value="<?=$category['cat_id'];?>">
                                        <input type="hidden" name="update" value="0">
                                        <button class="badge badge-success" type="submit" name="submit">ACTIVE</button>
                                    </form>
                                    <?php } else {?>
                                    <form method="POST">
                                        <input type="hidden" name="User" value="<?=$category['cat_id'];?>">
                                        <input type="hidden" name="update" value="1">
                                        <button class="badge bg-danger" name="submit" type="submit">INACTIVE</button>
                                    </form>
                                    <?php }?>
                                </td>
                                <td><?=date("d M Y", strtotime($category['created_at']))?></td>

                                <td><a href="productList.php?catID=<?php echo base64_encode($category['cat_id']); ?>"
                                        title="View Products"><i class="fa fa-eye"></a></i>
                                    <a href="add-category.php?edit=<?=base64_encode($category['cat_id']);?>"
                                        title="Edit Categories"><i class="fa fa-edit"></a></i></td>
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