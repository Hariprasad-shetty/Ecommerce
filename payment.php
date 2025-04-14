<?php include('layouts/header.php'); ?>



<?php

  // session_start();

   if(isset($_POST['order_pay_btn'])){
    $order_status=$_POST['order_status'];
   $order_total_price=$_POST['order_total_price'];


 }


// Optionally: Clear cart


   

?>







    <!--Payment-->

         <section class="my-5 py-5">
 
      <div class="container text-center mt-3 pt-5">
         <h2 class="font-weight-bold">Payment</h2>
         <hr class="mx-auto">
       </div>

       <div class="mx-auto container text-center">
                  <?php if(isset($_POST['order_status']) && $_POST['order_status']=="not paid"){ ?>

         <?php $amount=strval($_POST['order_total_price']); ?>


         <?php $order_id=$_POST['order_id']; ?>


         <p>Total payment: $<?php echo number_format($_POST['order_total_price']); ?>
      <!--   <input type="submit" class="btn btn-primary" value="Pay Now" /> -->


        <div id="paypal-button-container"></div>


         <?php }else if(isset($_SESSION['total']) && $_SESSION['total']!=0){ ?>

         <?php $amount=strval($_SESSION['total']); ?>


         <?php $order_id=$_SESSION['order_id']; ?>




         <p>Total payment: $<?php echo $_SESSION['total']; ?></p>
     <!--    <input type="submit" class="btn btn-primary" value="Pay Now" /> -->


        <div id="paypal-button-container"></div>


         



 
         <?php }else{ ?>
<p>You don't have an order</p>

        <?php } ?>







       </div>   
       

     </section>

  


 <script>
try{
paypal.Buttons({
    createOrder: function(data, actions) {
      alert("order created");
        return actions.order.create({
            purchase_units: [{
                amount: { value: <?php echo json_encode($amount); ?> } // Fixed PHP variable
            }]
        });
    },
    onApprove: function(data, actions) {
alert("order approved");


        return actions.order.capture().then(function(details) {

 let transactionId = details.purchase_units[0].payments.captures[0].id;

            // Send transaction details to PHP for verification
            fetch('process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ orderID: data.orderID })
            })
            .then(response => response.json()) // Convert response to JSON
            .then(data => {
                if (data.success) {
                    alert('Transaction completed by ' + details.payer.name.given_name);
                } else {
                    alert('Payment verification failed.');
                }

   window.location.href="server/complete_payment.php?transaction_id="+transactionId+"&order_id="+<?php echo $order_id; ?>;


            }).catch(error => console.error('Error:', error)); // Error handling
        });
    }
}).render('#paypal-button-container').catch(error => alert("PayPal Error: " + error)); // Fixed button rendering
}catch (e) {
    alert("JavaScript Error: " + e.message);
}
</script>



<?php include('layouts/footer.php'); ?>





