<?php include_once '../common/common-function.php';

//check manager not loggedIn
manager_not_loggedIn();

if(isset($_POST['submit'])){

$required_field = ['email','password'];
$errors = [];

foreach($required_field as $key => $value){

  if(isset($_POST[$value]) && empty($_POST[$value])){   
      $errors[] = ucfirst($value) . " is required";
  }
}

if(count($errors) == 0){

    $name = $_POST['username'];
    $password =  $_POST['password'];
    $pass = md5($password);

    $query = "SELECT * FROM `users` WHERE `name` = '$name' AND `password` = '$pass' AND `role` = 1";
    $result = mysqli_query($connect,$query);

    if($rows = mysqli_fetch_assoc($result)) {
       
        $_SESSION['Manager'] = $rows;

        if(isset($_SESSION['Manager'])){

            $_SESSION['success_message'] = 'Welcome ! Back To Manager-Panel';
            header('Location: dashboard.php');
            exit;
        }
    } 
    else {
        $_SESSION['errors']['general'] = 'Invalid email or password. Please try again.';
    }
    
    } 
    else {
        $_SESSION['errors'] = $errors;
    }

    header('Location: login.php');
    exit;
}

?>

<?php 

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$email_error = isset($errors['email']) ? $errors['email'] : '';
$password_error = isset($errors['password']) ? $errors['password'] : '';
$general_error = isset($errors['general']) ? $errors['general'] : '';

unset($_SESSION['errors']);

?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('mainFile/head.php'); ?>

<body class="admin">
    <header>
        <div class="headwrapper">
            <div class="colleft">
                <div class="logo">
                    <a href=""> <img src="img/logo.png" alt="logo" title="logo"></a>
                </div>
            </div>
        </div>

    </header>
    <section class="login">
        <div class="container">
            <div class="login-form">

                <form method="post">
                    <h2>Login </h2>

         <?php if ($general_error): ?>
            <div class="error-message" id="error-message"><?php echo htmlspecialchars($general_error); ?></div>
         <?php endif; ?>

                    <div class="row">
                        <div class="col12">
                            <label for="name">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="UserName" required>
                        </div>
                        <div class="col12">
                            <label for="name">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col12">
                            <div class="form-btn"><button type="submit" name="submit">Login</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <footer>
        <p>@copyright</p>
    </footer>
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