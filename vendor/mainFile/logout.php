<?php
session_start();

unset($_SESSION['vendor']);

header('Location:../login.php');
exit;

?>