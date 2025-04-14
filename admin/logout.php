<?php
ob_start();
session_start(); 
if(isset($_GET['logout'])&&$_GET['logout']==1){
    if(isset($_SESSION['admin_logged_in'])){
        unset($_SESSION['admin_logged_in']);
    
unset($_SESSION['admin_email']);
        unset($_SESSION['admin_name']);
echo "session variable unset";
        header('location:login.php'); 
// Corrected line
        exit();
    } 
}

?>
