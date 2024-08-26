<?php
session_start(); 
session_unset(); 
session_destroy(); 
header("Location: ../adminarea/admindashboard.php"); 
exit();
?>