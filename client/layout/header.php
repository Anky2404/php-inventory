<?php
include_once '../common/common-function.php';

?>
<div class="top-bar">
    <div class="container-wrap">
        <div class="row-wrap">
            <div class="colleft">
                <ul>
                    <li>
                        <a href="tel: +(02) 9869 8889"><i class="fa-solid fa-phone"></i> + (02) 9869 8889</i></a>
                    </li>
                    <li>
                        <a href="tel: +(02) 9869 8889"><i class="fa-regular fa-envelope"></i>
                            inventory@gmail.com</i></a>
                    </li>
                </ul>
            </div>
            <div class="colright">
                <ul>
                    <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    <li><a href="orders.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                    <?php if(empty($_SESSION['user'])){?>
                    <li><a href="login.php"><i class="fa-regular fa-user"></i></a></li>
                   <?php }else{ ?>
                    <li><i class="fa-solid fa-right-to-bracket"></i><a href="layout/logout.php" onclick="return confirm('Are you Sure For Logout?')"><b><?= $_SESSION['user']['name'] ?></b></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<header>
    <div class="container-wrap">
        <div class="row-wrap">
            <div class="colleft">
                <div class="headlogo">
                    <a href="home"><img src="images/logo.png"></a>
                </div>
            </div>
            <div class="colright">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="shop.php">Shop</a></li>
            
               
                    <li><a href="contact.php">Contact</a></li>
                
                </ul>
            </div>
        </div>
    </div>
</header>