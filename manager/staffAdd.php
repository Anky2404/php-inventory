<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();

if(isset($_POST['submit'])){

    $required_fields = ['name','email','password','phone','address'];
    $error = [];
    foreach($required_fields as $key => $value){
        if(isset($_POST[$value]) && empty($_POST[$value])){
          $error[] = $value." is required";
        }
    }
    if(count($error) == 0){
    
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $pass = md5($password);
        $phone = $_POST['phone'];
        $address = $_POST['address'];
    
        $qry = "SELECT * FROM `users` WHERE `email` = '$email' AND `role` = 3";
        $res = mysqli_query($connect,$qry);
        $number = mysqli_num_rows($res);
    
        if($number == 1) {     
    
            echo '<script>alert("Email Only Aggest!");
              window.location.href="staffList.php";
             </script>';
            exit;
        }
    
    $query = "INSERT INTO `users` (`name`,`email`,`password`,`contact`,`address`,`role`) VALUES ('$name','$email','$pass','$phone','$address','3')";
    $result = mysqli_query($connect,$query);
    
    if($result){

        $_SESSION['success_message'] = 'The addition of the Staff was Successful';
        header('Location: staffList.php');
    }
    
    }
    else{
        $_SESSION['errors']['general'] = 'Please complete all fields before Submitting.';
        header('Location: addStaff.php');
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
                <h2>Add Staff</h2>
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
                            <label for="name">Name</label>
                            <input type="text" id="first_name" name="name" placeholder="Enter Name" required 
                            pattern="[A-Za-z\s]+" title="Name can only contain letters and spaces" 
                            autocomplete="name">
                        </div>
                        <div class="col6">
                            <label for="name">Email</label>
                            <input type="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="col6">
                            <label for="name">Password</label>
                            <input type="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="col6">
                            <label for="name">Phone</label>
                            <input type="tel" name="phone" placeholder="Enter Phone" required>
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