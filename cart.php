<?php 
ob_start();
include('layouts/header.php'); ?>



<?php

    //session_start();
    




    if(isset($_POST['add_to_cart'])){



      if (!isset($_SESSION['logged_in'])) {
        echo '<script>alert("Please login first to add products to your cart.");</script>';
       header("location: login.php");
      exit;
    } else{




      if(isset($_SESSION['cart'])){

          $products_array_ids= 
array_column($_SESSION['cart'],"product_id");
 
      if(!in_array($_POST['product_id'],$products_array_ids)){
      
  $product_id=$_POST['product_id'];

$product_array=array(                'product_id' => $_POST['product_id'],
 'product_name' => $_POST['product_name'],
 'product_price' => $_POST['product_price'],
 'product_image' => $_POST['product_image'],
 'product_quantity' => $_POST['product_quantity']
);
    
  $_SESSION['cart'][$product_id]=$product_array;


}else{

    echo '<script>alert("Product was already to cart")</script>'; 
  /*  echo '<script>window.location="index.php"</script>'; */
}




      }else{
          
          $product_id=$_POST['product_id'];
$product_name=$_POST['product_name'];
$product_price=$_POST['product_price'];
$product_image=$_POST['product_image'];
$product_quantity=$_POST['product_quantity'];

$product_array=array(                'product_id' => $product_id,
 'product_name' => $product_name,
 'product_price' => $product_price,
 'product_image' => $product_image,
 'product_quantity' => $product_quantity
);
    
    $_SESSION['cart'][$product_id]=$product_array;


       }

     calculateTotalCart();
}
    }else if(isset($_POST['remove_product'])){
    
   $product_id=$_POST['product_id'];
   unset($_SESSION['cart'][$product_id]);

   calculateTotalCart();

}else if(isset($_POST['edit_quantity'])){
 
  $product_id=$_POST['product_id'];
  $product_quantity=$_POST['product_quantity'];

$product_array=$_SESSION['cart'][$product_id];

$product_array['product_quantity']=$product_quantity;

$_SESSION['cart'][$product_id]=$product_array;

  calculateTotalCart();


}else{

     // header('location: index.php');
   
     }



   function calculateTotalCart(){

       $total=0;
       $total_quantity=0;

       foreach($_SESSION['cart'] as $key => $value){
           $product=$_SESSION['cart'][$key];
$price=$product['product_price'];
$quantity=$product['product_quantity'];

$total=$total + ($price * $quantity);
$total_quantity=$total_quantity+$quantity;

}
  
   $_SESSION['total']=$total;
   $_SESSION['quantity']=$total_quantity;
 
}





?>




 


   <!--Cart-->

    <section class="cart container my-5 py-5">
      <div class="container mt-5"> 
        <h2 class="font-weight-bold text-center">Your Cart</h2>
        <hr class="mx-auto"/>
      </div>
      <table class="mt-5 pt-5">
        <tr>
          <th>Products</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>


    <?php if(isset($_SESSION['cart'])){ ?>

    <?php  foreach($_SESSION['cart'] as  $key=>$value){  ?>



        <tr>
          <td>
            <div class="product-info">
              <img src="assets/imgs/<?php echo $value['product_image']; ?>" />
              <div>
                <p><?php echo $value['product_name']; ?></p>
                <small><span>$</span><?php echo $value['product_price']; ?></small>
                <br />
              <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />

                <input type="submit" name="remove_product" class="remove-btn" value="Remove" />
              </form>
              </div>
            </div>
          </td>
          <td>
          <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
            <input type="number" name="product_quantity" class="add-quantity" value="<?php echo $value['product_quantity']; ?>" />
            <input type="submit" class="edit-btn" value="edit" name="edit_quantity" />
          </form>
          </td>
          <td>
            <span>$<span>
            <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>

          </td>
        </tr>

        <?php } ?>
        <?php } ?>

      </table>
      
      <div class="cart-total">
        <table>
        <!--  <tr>
            <td>Subtotal</td>
            <td>$155</td>
          </tr> -->
          <tr>
            <td>Total</td>
    <?php if(isset($_SESSION['cart'])){ ?>

            <td>$ <?php echo $_SESSION['total']; ?></td>

    <?php }?>
          </tr>
        </table>
      </div>
     
      <div "checkout-container">
      <form method="POST" action="checkout.php">
        <input type="submit" class="btn-checkout-btn" value="Checkout" name="checkout" />
      </form>
      </div>

    </section>







 <?php include('layouts/footer.php'); ?>










