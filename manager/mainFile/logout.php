<?php
session_start();

unset($_SESSION['Manager']);

header('Location:../login.php');
exit;

?>