<header>
    <div class="headwrapper">
        <div class="colleft">
            <div class="logo">
                <a href="dashboard.php"> <img src="img/logo.png" alt="logo" title="logo"></a>
            </div>
        </div>
        <div class="colright">
            <h4>
                <a href="mainFile/logout.php" onClick="return confirm('You Are Confirm For Logout?')"><?= $_SESSION['staff']['name'] ?>/Logout</a>
            </h4>
        </div>
    </div>
</header>
<div class="side-menu">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="productList.php">Product List</a></li>
        <li><a href="orderList.php">Order's List</a></li>
    </ul>
</div>