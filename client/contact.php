<?php
include_once('../common/common-function.php');

if(isset($_POST['submit'])){

$required_fields = ['name','email','message'];
$error = [];
foreach($required_fields as $key => $value){
    if(isset($_POST[$value]) && empty($_POST[$value])){
      $error[] = $value." is required";
    }
}
if(count($error) == 0){

    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);
    $phone = trim($_POST["phone"]);

 $query = "INSERT INTO `contacts` (`name`,`email`,`message`,`phone`) VALUES ('$name','$email','$message','$phone')";
 $result = mysqli_query($connect, $query);
 
 if($result){
      echo '<script>alert("Contact submitted successfully!");
          window.location.href="contact.php";
      </script>';
      exit;
}
else {
  echo '<script>alert("Something Went Wrong");
      window.location.href="contact.php";
  </script>';
  exit;
}
}
else{
    echo '<script>alert("Please Complete All Fields");
    window.location.href="contact.php";
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

                <h2>Contact</h2>
                <p>Our team at InventoryMax is ready to provide you with the support you need. Get in touch with us today</p>
            </div>
        </div>
    </section>
    <section class="contact-wrap">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col4">
                    <div class="contact-info">
                        <h3>Reach Out to InventoryMax</h3>
                        <p>We’re here to assist you with any questions or support you may need. Contact us through the following channels: </p>
                        <ul>
                            <li><i class="fa-solid fa-phone"></i> <a href="tel: +(02) 9869 8889"> <h4>Call Us</h4> <span>+(02) 9869 8889</span> </a></li>
                            <li><i class="fa-regular fa-envelope"></i> <a href="mailto: inventory@gmail.com"> <h4>Email</h4>
                                    <span>  inventory@gmail.com</span></a></li>
                            <li><i class="fa-solid fa-map"></i> <a href=""><h4>Office Location</h4><span> 	50A Rawson St
                           	Sydney,New South Wales Australia</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col8">
                    <form method="post">
                        <h3>We're Here to Help You</h3>
                        <div class="input-field">
                            <label>Your Name </label>
                            <input type="text" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="input-box">
                            <div class="input-field">
                                <label>Email </label>
                                <input type="email" name="email" placeholder="Email" required>
                            </div>

                            <div class="input-field">
                                <label>Phone </label>
                                <input type="tel" name="phone" placeholder="Phone" required>
                            </div>
                        </div>
                        <div class="input-field">
                            <label>Message </label>
                            <textarea name="message" id="" placeholder="Subject" required></textarea>
                        </div>


                        <button type="submit" name="submit">Submit</button>

                    </form>
                </div>
            </div>
        </div>

    </section>

    <?php include_once('layout/footer.php') ?>



</body>

</html>