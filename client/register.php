<?php
include_once('../common/common-function.php');

client_not_loggedIn();
 
 if(isset($_POST['submit'])){
 
   $required_fields = ['name','email','password','phone','address'];
   $error = [];
   foreach($required_fields as $key => $value){
       if(isset($_POST[$value]) && empty($_POST[$value])){
         $error[] = $value." is required";
       }
   }
   if(count($error) == 0){
 
       $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
       $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
       $password = trim($_POST['password']);
       $pass = md5($password);
       $phone = trim($_POST['phone']);
       $address = trim($_POST["address"]);
   
       $qry = "SELECT * FROM `users` WHERE `email` = '$email'";
       $res = mysqli_query($connect,$qry);
       $number = mysqli_num_rows($res);
   
       if($number == 1) {     
           echo '<script>alert("Email Only Aggest!");
             window.location.href="register.php";
            </script>';
           exit;
       }
   
    $query = "INSERT INTO `users` (`name`,`email`,`password`,`contact`,`address`,`role`) VALUES ('$name','$email','$pass','$phone','$address','2')";
    $result = mysqli_query($connect,$query);
    
    if($result){
         echo '<script>alert("Form submitted successfully!");
             window.location.href="login.php";
         </script>';
         exit;
   }
   else {
     echo '<script>alert("Something Went Wrong");
         window.location.href="register.php";
     </script>';
     exit;
   }
   }
   else{
       echo '<script>alert("Please Complete All Fields");
       window.location.href="register.php";
      </script>';
     exit;
   }
 }
?>
<!doctype html>
<html lang="en">

<?php include_once('layout/head.php') ?>

<body>

<?php include_once('layout/header.php') ?>

<section class="inv-banner">
    <div class="container-wrap">
    <div class="inv-heading">

        <h2>Register</h2>
        <p>Create your InventoryMax account and take the first step towards smarter inventory management. Whether you're a small business or a large enterprise, our platform is designed to help you optimize stock levels.</p>
    </div>
    </div>
</section>
    <section class="login-wrap">
        <div class="container-wrap">
            <form method="post">
                <h3>Register</h3>

                <div class="input-field">
                    <label>Name* </label>
                    <input type="text" id="name" name="name" placeholder="Enter Your Name" required 
                        pattern="[A-Za-z\s]+" title="Name can only contain letters and spaces" 
                        autocomplete="name">
                </div>

                <div class="input-field">
                    <label>Email Address * </label>
                    <input type="email" id="email" name="email" placeholder="Enter Your Valid Email" required 
                        autocomplete="email">
                </div>

                <div class="input-field">
                    <label>Password </label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required 
                    autocomplete="new-password">
                </div>

                <div class="input-field">
                    <label>Phone </label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter Your Valid Phone Number" required 
                        pattern="\d{10}" title="Phone number must be 10 digits" 
                        inputmode="numeric" autocomplete="tel">
                </div> 

                <div class="input-field">
                    <label>Address </label>
                    <input type="text" id="address" name="address" placeholder="Enter Your Valid Address" required 
                    pattern="[A-Za-z0-9\s,.-]+" title="Address can only contain letters, numbers, spaces, commas, periods, and hyphens" 
                    autocomplete="address-line1">
                </div>

                <div class="submit-wrap">
                   <button type="submit" name="submit">Submit</button>
                   <p>Have an account? <a href="login">Login</a></p>
                </div>
            </form>
        </div>
    </section>

    <?php include_once('layout/footer.php') ?>

</body>
</html>