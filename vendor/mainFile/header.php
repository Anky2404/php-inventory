<header>
    <div class="headwrapper">
        <div class="colleft">
            <div class="logo">
                <a href="dashboard.php"> <img src="img/logo.png" alt="logo" title="logo"></a>
            </div>
        </div>
        <div class="colright">
            <h4>
                <a href="mainFile/logout.php" onClick="return confirm('You Are Confirm For Logout?')"><?= $_SESSION['vendor']['name'] ?>/Logout</a>
            </h4>
        </div>
    </div>
</header>
<div class="side-menu">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="inventoryList.php">Inventory Order's</a></li>
    </ul>
</div>