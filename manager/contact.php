<?php include_once '../common/common-function.php';

//check manager login
manager_logged_in();


$qry = "SELECT * FROM `contacts`";
$result = mysqli_query($connect,$qry); 
$contact = [];
while($rows = mysqli_fetch_array($result)){
$contact[] = $rows;

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
                <h2>Enquiries List</h2>
            </div>

            <div class="blog-list">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Contact </th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php $count = 0;

                        foreach($contact as $key => $value){ ?>

                            <tr>
                                <td><?php echo ++$count.'.'; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php echo $value['phone']; ?></td>
                                <td><?php echo $value['message']; ?></td>
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