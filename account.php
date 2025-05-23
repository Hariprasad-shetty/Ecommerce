<?php
ob_start(); 

 include('layouts/header.php'); ?>



<?php

include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

$_SESSION['quantity']=0;
unset($_SESSION['cart']);

        header('location: login.php'); // Corrected line
        exit;
    } 
}

if(isset($_POST['change_password'])){
    $password=$_POST['password'];
    $confirm_password=$_POST['confirmPassword'];
    $user_email=$_SESSION['user_email'];

    if($password !== $confirm_password){
        header('location: account.php?error=password dont match');
    } else if(strlen($password) < 6){
        header('location: account.php?error=password must be atleast 6 characters');
    } else {
        $stmt=$conn->prepare("UPDATE users SET user_password=? WHERE user_email=?"); 

$stmt->bind_param('ss',md5($password),$user_email);

        if($stmt->execute()){
          header('location: account.php? message=password has been updated successfully');
        } else {
            header('location: account.php? error=could not update password');
        }
    }
}






//get orders 

if(isset($_SESSION['logged_in'])){

   $user_id=$_SESSION['user_id'];

   $stmt=$conn->prepare("SELECT * FROM orders where user_id=?");

  $stmt->bind_param('i',$user_id);

  $stmt->execute();

  $orders=$stmt->get_result();



}





ob_end_flush();
?>







     <!--Account-->

     <section class="my-5 py-5">
       <div class="row container mx-auto">
       

         <?php if(isset($_GET['payment_message'])){ ?>
         <p class="mt-5 text-center" style="color: green"> <?php echo $_GET['payment_message']; ?> </p>

         <?php } ?>

         <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">

             <p class="text-center" style="color: green"><?php if(isset($_GET['register_success'])){echo $_GET['register_success'];}?></p>
             <p class="text-center" style="color: green"><?php if(isset($_GET['login_success'])){echo $_GET['login_success'];}?></p>




           <h3 class="font-weight-bold">Account Info</h3>
           <hr class="mx-auto" />
           <div class="account-info">
             <p>Name:<span> <?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];} ?></span></p>
<p>Email:<span> <?php if(isset($_SESSION['user_email'])){ echo $_SESSION['user_email'];} ?><span></p>
<p><a href="#orders" id="orders-btn">Your orders</a></p>
<p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
           </div>

         </div>
         <div class="col-lg-6 col-md-12 col-sm-12 mx-auto">
           <form id="account-form" method="POST" action="account.php">
             <p class="text-center" style="color: red"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
             <p class="text-center" style="color: green"><?php if(isset($_GET['message'])){echo $_GET['message'];}?></p>


             <h3>Change Password</h3>
             <hr class="mx-auto" />
             <div class="form-group">
               <label>Password</label>
               <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required />
             </div>
             <div class="form-group">
               <label>Confirm Password</label>
               <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Confirm Password" required />
             </div>
             <div class="form-group">
               <input type="submit" value="Change Password" class="btn" id="change-pass-btn" name="change_password" />
             </div>
           </form>
         </div>
       </div>

     </section>




    
     <!--Orders-->



     <section id="orders" class="orders container my-5 py-5">

     <div class="container mt-2">
       <h2 class="font-weight-bold  text-center">Your Orders</h2>
       <hr class="mx-auto" />

     </div>
<div class="table-responsive">
     <table class="mt-5 pt-5">
       <tr>
         <th>Order id</th>
         <th>Order cost</th>
         <th>Order status</th>
         <th>Order Date</th>
         <th>Order Details</th>
       </tr>

       <?php while($row=$orders->fetch_assoc()){ ?>

       <tr>
         <td>
        <!--   <div class="product-info">
             <img src="assets/imgs/featured1.jpg"/> 

             <div>
               <p class="mt-3"><?php echo $row['order_id']; ?></p>
             </div>
           </div>-->
           <span><?php echo $row['order_id']; ?></span>
         </td>

         <td>
           <span><?php echo $row['order_cost']; ?></span>
         </td>

         <td>
           <span><?php echo $row['order_status']; ?></span>
         </td>

         <td>
           <span><?php echo $row['order_date']; ?></span>
         </td>
         <td>
           <form method="POST" action="order_details.php">
             <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status" />
             <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id" />
             <input class="btn order-details-btn" type="submit" name="order_details_btn" value="Details" />
          </form>
         </td> 
       </tr>
       <?php } ?>
     </table>
</div>
     </section>



<?php include('layouts/footer.php'); ?>



<style>
.table-responsive {
  overflow-x: auto;
  width: 100%;
}
table {
  width: 100%;
  min-width: 600px; /* Ensures scroll on smaller screens */
}

@media (max-width: 768px) {
  #account-form {
    width: 100%;
    padding: 20px;
  }

  #account-form .form-group input {
    width: 100%;
    font-size: 16px;
  }

  #change-pass-btn {
    width: 100%;
    font-size: 16px;
  }
}


</style>








