<?php
session_start();

unset($_SESSION['staff']);

header('Location:../login.php');
exit;

?>