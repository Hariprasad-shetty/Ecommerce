<?php
session_start();
unset($_SESSION['admin_logged_in']);
session_destroy(); // Optional: destroys all session data
header('Location: ../index.php');
exit();
