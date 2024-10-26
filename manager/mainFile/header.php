<header>
    <div class="headwrapper">
        <div class="colleft">
            <div class="logo">
                <a href="dashboard.php"> <img src="img/logo.png" alt="logo" title="logo"></a>
            </div>
        </div>
        <div class="colright">
            <h4>
                <a href="mainFile/logout.php" onClick="return confirm('You Are Confirm For Logout?')"><?= $_SESSION['Manager']['name'] ?>/Logout</a>
            </h4>
        </div>
    </div>
</header>
<div class="side-menu">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="categories.php">Categories List</a></li>
        <li><a href="productList.php">Products List</a></li>
        <li><a href="staffList.php">Staffs List</a></li>
        <li><a href="vendorList.php">Vendors List</a></li>
        <li><a href="product_assign.php">Inventory Order's</a></li>
        <li><a href="clientList.php">Clients List</a></li>
        <li><a href="orderList.php">Order's List</a></li>
        <li><a href="client-report.php">Customer Review's</a></li>
        <li><a href="contact.php">Enquiries List</a></li>
    </ul>
</div>