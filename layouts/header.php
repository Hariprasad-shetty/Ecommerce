<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Navbar Test</title>

  <link rel="stylesheet" href="assets/css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



<script src="https://kit.fontawesome.com/8de20d1047.js" crossorigin="anonymous"></script>

<script src="place You client Id"></script>

</head>

<body>

<div class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
  <div class="container">
    <h1 style="color:#fb774b">Eshop</h1>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
      </ul>

      <!-- Right Side Icons -->
      <ul class="navbar-nav">
        <!-- Cart Icon -->
        <li class="nav-item me-3">
          <a href="cart.php" class="nav-link">
            <i class="fas fa-bag-shopping"></i>
            <?php if(isset($_SESSION['quantity']) && $_SESSION['quantity'] > 0) { ?>
              <span class="badge bg-danger"><?php echo $_SESSION['quantity']; ?></span>
            <?php } ?>
          </a>
        </li>

        <!-- Show User or Admin login options -->
        <li class="nav-item">
          <?php if (isset($_SESSION['admin_logged_in'])) { ?>
            <a href="admin/dashboard.php" class="nav-link"><i class="fas fa-user-shield"></i> Admin Panel</a>
            <a href="admin_logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
          <?php } elseif (isset($_SESSION['logged_in'])) { ?>
            <a href="account.php" class="nav-link"><i class="fas fa-user"></i> Profile</a>
            <a href="account.php?logout=1" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
          <?php } else { ?>
            <a href="login.php" class="nav-link"><i class="fas fa-user"></i> User Login</a>
            <a href="../admin/login.php" class="nav-link"><i class="fas fa-user-shield"></i> Admin Login</a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>


