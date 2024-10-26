<?php
include_once('../common/common-function.php');

client_not_loggedIn();

if(isset($_POST['submit'])){

  $required_fields = ['email','password'];
  $error = [];
  foreach($required_fields as $key => $value){
      if(isset($_POST[$value]) && empty($_POST[$value])){
        $error[] = $value." is required";
      }
  }
  if(count($error) == 0){

    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $password =  mysqli_real_escape_string($connect, $_POST["password"]);
    $pass = md5($password);

    $query = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$pass'";
    $result = mysqli_query($connect,$query);
    
    if($rows = mysqli_fetch_assoc($result)){
      
      if($rows['status'] == 2){

         echo '<script>alert("YOUR ACCOUNT IS INACTIVE!");
         window.location.href="login.php";
        </script>';
       exit;
      }

      $_SESSION['user'] = $rows;
     }
      if(isset($_SESSION['user'])){

          echo '<script>alert("Login SuccessFul");
          window.location.href="home.php";
          </script>';
          exit;
      }
      else
      {
          echo '<script>alert("Your Details Were Wrong!!");
          window.location.href="login.php";
         </script>';
        exit;
      }
    }
    else
    {
        echo '<script>alert("Something Went Wrong");
        window.location.href="login.php";
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

        <h2>Login</h2>
        <p>Log in to your InventoryMax account to manage your inventory, track stock levels, and access powerful insights that help your business thrive.</p>
    </div>
    </div>
</section>
    <section class="login-wrap">
        <div class="container-wrap">
            <div class="row-wrap">

                <form method="post">
                    <h3>Login</h3>
                    <div class="input-field">
                        <label>Email address * </label>
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="input-field">
                        <label>Password * </label>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
    
                    <div class="submit-wrap">
                       <button type="submit" name="submit" >Log in</button>
                       <p>Don't have an account? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php include_once('layout/footer.php') ?>
   
</body>
</html>