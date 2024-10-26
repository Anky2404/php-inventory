<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();

//get all categories
$categories=get_all_categories();

if(isset($_GET['edit'])){

    $id = $_GET['edit'];
    $edit = base64_decode($id);

    $query2 = "SELECT * FROM `products` WHERE `id` = '$edit'";
    $result2 = mysqli_query($connect,$query2);
    
    if(!mysqli_num_rows($result2)){
        echo '<script>alert("Not Access ID!");
        window.location.href="productList";
        </script>';
     exit();
    }

    $out = '';
    $rows = mysqli_fetch_array($result2);
    $out = $rows;

    if(isset($_POST['update'])){

        $qty = $_POST['product_quantity'];
        $price = $_POST['product_price'];
        $product_description = $_POST['product_description'];

        $query = "UPDATE `products` SET `product_price` = $price , `product_quantity` = '$qty' , `product_description` = '$product_description' WHERE id = '$edit'";
        $res = mysqli_query($connect,$query);

        if($res){
            $_SESSION['success_message'] = 'Product edit completed Successfully';
            header('Location: productList.php');
            exit();
          }    
    }

}

if(isset($_POST['submit'])){

    $required_fields = ['product_name','product_quantity','product_price','product_description','storage_level'];
    $error = [];

    foreach($required_fields as $key => $value){

        if(isset($_POST[$value]) && empty($_POST[$value])){
          $error[] = $value." is required";
        }

        if(!isset($_FILES['image']['name']) && empty($_FILES['image']['name'])) {
            $error[] = "image is required";
        }
    }

    if(count($error) == 0){
  
        $name = $_POST['product_name'];
        $qty = $_POST['product_quantity'];
        $price = $_POST['product_price'];
        $description = $_POST['product_description'];
        $storage_level = $_POST['storage_level'];
        $cat_id=$_POST['cat_id'];
        $img_name = $_FILES['image']['name'];
        $imp_temp = $_FILES['image']['tmp_name'];
        $destinationFolder = './uploads/';
        $path_info = pathinfo($img_name);
        $extension = $path_info['extension'];
        $unque_name = time();
        $distination_path = $destinationFolder . $unque_name . '.' . $extension;
        $isUploaded = move_uploaded_file($imp_temp, $distination_path);
        $img_full_name = $unque_name . '.' . $extension;
  
    $qry = "INSERT INTO `products` (`cat_id`,`product_name`,`product_quantity`,`product_price`,`product_description`,`storage_level`,`image`) VALUES ($cat_id,'$name','$qty','$price','$description','$storage_level','$img_full_name')";
    $res = mysqli_query($connect,$qry);
      
      if($res){
        $_SESSION['success_message'] = 'The addition of the product was Successful';
        header('Location: productList.php');
        exit();
      }
  
     }
     else
     {
        $_SESSION['errors'] = $errors;
            header('Location: productAdd.php');
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

<?php require_once('mainFile/head.php'); ?>

<body>
<?php require_once('mainFile/header.php'); ?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
           <?php if(isset($_GET['edit'])){  ?>
                <h2>Edit Product Detail's</h2>
            <?php }else{ ?>
                <h2>Add Product</h2>
            <?php } ?>
            </div>
            <?php if ($general_error): ?>
                <div class="error-message" id="error-message"><?php echo htmlspecialchars($general_error); ?></div>
            <?php endif; ?>
            <div class="blog-form">
            <?php if(!isset($_GET['edit'])){  ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col6">
                            <label for="name">Product Category</label>
                            <select id="category" name="cat_id" class="form-control" required>
                                <option value="" disabled selected>Select Categories</option>
                                <?php foreach($categories as $category){  ?>
                                <option value="<?= $category['cat_id'] ?>"><?= $category['name'] ?></option>

                                <?php } ?>
                               
                            </select>
                        </div>
                        <div class="col6">
                            <label for="name">Product Name</label>
                            <input type="text" id="first_name" name="product_name" placeholder="Enter Your First Name" required 
                            pattern="[A-Za-z\s]+" title="Name can only contain letters and spaces" 
                            autocomplete="name">
                        </div>

                        <div class="col6">
                            <label for="product_quantity">Product Quantity</label>
                            <input type="number" id="product_quantity" name="product_quantity" class="form-control" placeholder="Enter Quantity" min="1" step="1" required>
                        </div>

                        <div class="col6">
                            <label for="product_price">Product Price</label>
                            <input type="number" id="product_price" name="product_price" class="form-control" placeholder="Enter price" min="0" step="0.01" required>
                        </div>

                        <div class="col6">
                            <label for="email">Product Image</label>
                            <input type="file" class="form-control" name="image" placeholder="Product Image">
                        </div>

                        <div class="col6">
                            <label for="name">Storage Level</label>
                            <input type="text" id="" name="storage_level" placeholder="Enter Your Storage Level" required >
                    
                        </div>

                        <div class="col12">
                            <label for="name">Product Description</label>
                            <textarea class="form-control" name="product_description" placeholder="Description"></textarea>
                        </div>
                        <div class="col12">
                            <div class="form-btn"><button type="submit" name="submit">Submit</button></div>
                        </div>
                    </div>
                </form>
                <?php } else{ ?>

                    <form method="post">
                    <div class="row">
                        <div class="col6">
                            <label for="product_price">Product Price</label>
                            <input type="number" id="product_price" name="product_price" class="form-control" placeholder="Enter price" min="0" step="0.01" value="<?php echo $out['product_price'] ?>" required>
                        </div>

                        <div class="col6">
                            <label for="product_quantity">Product Quantity</label>
                            <input type="number" id="product_quantity" name="product_quantity" class="form-control" placeholder="Enter Quantity" min="1" step="1" value="<?php echo $out['product_quantity'] ?>" required>
                        </div>

                        <div class="col12">
                            <label for="name">Product Description</label>
                            <textarea class="form-control" name="product_description" placeholder="Description" value="<?php echo $out['product_description'] ?>"><?php echo $out['product_description'] ?></textarea>
                        </div>

                        <div class="col12">
                            <div class="form-btn"><button type="submit" name="update">Update</button></div>
                        </div>
                    </div>
                </form>

         <?php } ?>

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