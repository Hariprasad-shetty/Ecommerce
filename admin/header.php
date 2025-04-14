<?php session_start(); ?>
<?php include("../server/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Navbar Test</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>


<body>




<header class="navbar navbar-dark sticky-top bg-dark flex-nd-nowrap p- shadow">

<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Eshop</a> <button class="navbar-toggler position-absolute d-md-none collapsed" type="button"

<span class="navbar-toggler-icon"></span>

</button>

<div class="navbar-nav">

<div class="nav-item text-nowrap d-flex">
<?php if(isset($_SESSION['admin_logged_in'])){ ?>
<a class="nav-link px-3" href="logout.php?logout=1">
Sign out</a>
<?php } ?>


  <!-- Hamburger Icon (Visible only on mobile) -->

  <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-expanded="false" aria-controls="sidebarMenu">
    <span class="navbar-toggler-icon"></span>
  </button>



</div>
</div>



</header>




