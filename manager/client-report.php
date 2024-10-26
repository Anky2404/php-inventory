<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();

$qry = "SELECT * FROM `reviews`";
$result = mysqli_query($connect,$qry); 
$user = [];
while($rows = mysqli_fetch_array($result)){
$user[] = $rows;
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
                <h2>Customer Reviews List</h2>
            </div>

            <div class="blog-list">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>ProductName</th>
                                <th>CustomerName</th>
                                <th>CustomerPhone</th>
                                <th>CustomerReviews</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php $count = 0;
                        foreach($user as $key => $value){ ?>

                            <tr>
                                <td><?php echo ++$count.'.'; ?></td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><?php echo $value['customer_name']; ?></td>
                                <td><?php echo $value['customer_phone']; ?></td>
                                <td><?php echo $value['review']; ?></td>
                            </tr>
                   
                   <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</body>
</html>