<?php include_once('../common/DBconnection.php');

//check vendor logged in
function vender_logged_in(){
    if(empty($_SESSION['vendor'])){
        echo '<script>alert("Access denied ! , Please Logged In to access this page");
        window.location.href="login.php";
        </script>';
        exit();
    }
}



//check vendor not logged in
function vendor_not_logged_in(){
    if(isset($_SESSION['vendor'])){
        echo '<script>alert("Access denied ! , You are already logged in");
        window.location.href="dashboard.php";
        </script>';
        exit();
    }
}





