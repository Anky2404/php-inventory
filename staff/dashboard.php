<?php
session_start();

if(!isset($_SESSION['staff'])){
    echo '<script>
    window.location.href="login.php";
    </script>';
    exit();
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

unset($_SESSION['success_message']);

include_once('./DBconnection.php');

$query = "SELECT * FROM `products`";
$result = mysqli_query($connect,$query);
$output = [];
while($row = mysqli_fetch_assoc($result)){
   $output[] = $row;
}


?>
<!DOCTYPE html>
<html lang="en">

<?php require_once('mainFile/head.php'); ?>

<body>
    
<?php require_once('mainFile/header.php'); ?>

    <section class="admin">
        <div class="dashboard">
            <div class="heading">
                <h2>Welcome Staff!</h2>
            </div>
            <?php if ($success_message): ?>
                <div class="success-message" id="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            <div class="dashboard-boxes">
                <div class="row">
                    <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>Total Product's</h4>
                                <i class="fa fa-user"></i>
                            </div>
                            <span><?= count($output); ?></span>
                        </div>
                    </div>
                    <div class="col4">
                        <div class="blog-box">
                            <div class="box-top">
                                <h4>New Order's</h4>
                                <i class="fa fa-user"></i>
                            </div>
                            <span>4</span>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </section>
<script>

function hideSuccessMessage() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 5000); 
    }
}

hideSuccessMessage();

</script>

</body>
</html>