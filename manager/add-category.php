<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();
$managerId = isset($_SESSION['Manager']) ? $_SESSION['Manager']['id'] : null;

if (isset($_GET['edit'])) {

        $catID=base64_decode($_GET['edit']);
   $category=get_category_by_id($catID);

    if (isset($_POST['update'])) {

        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        $query = "UPDATE `categories` SET `name` = '$name', `description` = '$description', `status` = '$status' WHERE `cat_id` = '$catID'";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $_SESSION['success_message'] = 'Category edit completed Successfully';
            header('Location: categories.php');
            exit();
        }
    }

}

if (isset($_POST['submit'])) {

    $required_fields = ['name', 'description', 'status'];
    $error = [];

    foreach ($required_fields as $key => $value) {

        if (isset($_POST[$value]) && empty($_POST[$value])) {
            $error[] = $value . " is required";
        }
    }

    if (count($error) == 0) {

        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        $qry = "INSERT INTO `categories`(`name`, `description`, `status`,`created_by`) VALUES ('$name','$description',' $status','$managerId')";
        $res = mysqli_query($connect, $qry);

        if ($res) {
            $_SESSION['success_message'] = 'The addition of the category was Successful';
            header('Location: categories.php');
            exit();
        }

    } else {
        $_SESSION['errors'] = $errors;
        header('Location: add-category.php');
        exit();
    }
}
?>
<?php

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$general_error = isset($errors['general']) ? $errors['general'] : '';
unset($_SESSION['errors']);

?>
<!DOCTYPE html>
<html lang="en">

<?php require_once 'mainFile/head.php';?>

<body>
    <?php require_once 'mainFile/header.php';?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <?php if (isset($_GET['edit'])) {?>
                <h2>Edit Category Detail's</h2>
                <?php } else {?>
                <h2>Add Category</h2>
                <?php }?>
            </div>
            <?php if ($general_error): ?>
            <div class="error-message" id="error-message"><?php echo htmlspecialchars($general_error); ?></div>
            <?php endif;?>
            <div class="blog-form">
                <?php if (!isset($_GET['edit'])) {?>
                <form method="post">
                    <div class="row">
                        <div class="col6">
                            <label for="category_name">Category Name</label>
                            <input type="text" id="category_name" name="name"  placeholder="Enter Category Name" required
                                pattern="[A-Za-z\s]+" title="Name can only contain letters and spaces"
                                autocomplete="name">
                        </div>

                        <div class="col6">
                            <label for="category_status">Category Status</label>
                            <select id="category_status" name="status" class="form-control" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>

                        <div class="col12">
                            <label for="category_description">Category Description</label>
                            <textarea class="form-control" id="description" name="description" style="height: 150px;"
                                placeholder="Description" required></textarea>
                        </div>

                        <div class="col12">
                            <div class="form-btn"><button type="submit" name="submit">Submit</button></div>
                        </div>
                    </div>
                </form>

                <?php } else {?>

                <form method="post">
                    <div class="row">
                        <div class="col6">
                            <label for="category_name">Category Name</label>
                            <input type="text" id="category_name" name="name" value="<?= $category['name'] ?>" placeholder="Enter Category Name" required
                                pattern="[A-Za-z\s]+" title="Name can only contain letters and spaces"
                                autocomplete="name">
                        </div>

                        <div class="col6">
                            <label for="category_status">Category Status</label>
                            <select id="category_status" name="status" class="form-control" required>
                                <option value="" disabled selected>Select Status</option>
                                <?php if($category['status']==1){?>
                                <option value="1" <?php echo 'selected';?>>Active</option>
                                <option value="2" >Inactive</option>
                                <?php }else{  ?>
                                    <option value="1">Active</option>
                                <option value="2" <?php echo 'selected';}?>>Inactive</option>
                            </select>
                        </div>

                        <div class="col12">
                            <label for="category_description">Category Description</label>
                            <textarea class="form-control" id="description" name="description" style="height: 150px;" placeholder="Description" required><?= htmlspecialchars($category['description']) ?></textarea>

                        </div>

                        <div class="col12">
                            <div class="form-btn"><button type="submit" name="update">Update</button></div>
                        </div>
                    </div>
                </form>

                <?php }?>

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