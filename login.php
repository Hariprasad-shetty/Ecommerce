<?php
ob_start();
 include('layouts/header.php'); 
?>



<?php


include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = ? AND user_password = ? LIMIT 1");

    if ($stmt) {
        $stmt->bind_param('ss', $email, $password);

        if ($stmt->execute()) {

            $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
            $stmt->store_result(); // Store the result

            if ($stmt->num_rows() == 1) {
                $stmt->fetch();

                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['logged_in'] = true;

                header('location: account.php?login_success=logged in successfully');
                exit;
            } else {
                header('location: login.php?error=Could not verify your account.' .$stmt->num_rows());
                exit;
            }
        } else {
            header('location: login.php?error=Execute failed: ' . $stmt->error);
            exit;
        }
        $stmt->close();
    } else {
        header('location: login.php?error=Prepare failed: ' . $conn->error);
        exit;
    }

    $conn->close();
}
?>






    
   
         <!--Login-->

     <section class="my-5 py-5">
       <div class="container text-center mt-3 pt-5">
         <h2 class="font-weight-bold">Login       </h2>
         <hr class="mx-auto">
       </div>

       <div class="mx-auto container">
         <form id="login-form" method="POST" action="login.php">
           <p style="color: red" class="text-center"><?php if(isset($_GET['error'])){echo $_GET['error']; }?></p>
           <div class="form-group">
             <label>Email</label>
             <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required />
           </div>
         
           <div class="form-group">
             <label>Password</label>
             <input type="password" class="form-control" id="login-password" name="password" placeholder="password" required />
           </div>
           <div class="form-group">
             
             <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login" />
           </div>
        
           <div class="form-group">
             
             <a id="register-url" class="btn" href="register.php">Don't have account? Register</a>
           </div>
  
         </form>
       </div>   

     </section>



<?php include('layouts/footer.php'); ?>

<style>
@media (max-width: 768px) {
  #login-form {
    width: 100%;
    padding: 20px;
  }

  #login-form .form-group input {
    width: 100%;
    font-size: 16px;
  }

  #login-form .form-group input[type="submit"] {
    width: 100%;
    font-size: 16px;
  }
}


</style>

