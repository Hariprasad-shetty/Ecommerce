<?php ob_start(); include("header.php"); ?>


<?php

    if(!isset($_SESSION['admin_logged_in'])){
      header("location: login.php");
      exit();
}

?>




<?php


if(isset($_GET['page_no'])&&$_GET['page_no']!=""){

     $page_no=$_GET['page_no'];

}else{

     $page_no=1;
}


     $stmt1=$conn->prepare("SELECT COUNT(*) AS total_records from orders");
     $stmt1->execute();
     $stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();


$total_records_per_pages=10;

$offset=($page_no-1)*$total_records_per_pages;

$previous_page=$page_no-1;
$next_page=$page_no+1;

$adjacents="2";

$total_no_of_pages=ceil($total_records/$total_records_per_pages);



$stmt2=$conn->prepare("SELECT * FROM  orders LIMIT $offset,$total_records_per_pages");

$stmt2->execute();
$orders=$stmt2->get_result();






?>






<div class="container-fluid">
  <div class="row" style="min-height:1000px">
<?php include("sidemenu.php"); ?>





<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Dashboard</h1>






    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
      </div>
    </div>
  </div>

  <h2>Orders</h2>

  <?php if(isset($_GET['order_updated'])){ ?>
    <p class="text-center" style="color: green"><?php echo $_GET['order_updated']; ?></p>
<?php } ?>

  <?php if(isset($_GET['order_failed'])){ ?>
    <p class="text-center" style="color: red"><?php echo $_GET['order_failed']; ?></p>
<?php } ?>


  <div class="table-responsive">
    <table class="table table-striped table-sm">

      <thead>
        <tr>
          <th scope="col">Order Id</th>
          <th scope="col">Order Status</th>
          <th scope="col">User Id</th>
          <th scope="col">Order Date</th>
          <th scope="col">User Phone</th>
          <th scope="col">User Address</th>


          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
  
        <?php foreach($orders as $order){ ?>
        <tr>
          <td><?php echo $order['order_id']; ?></td>
          <td><?php echo $order['order_status']; ?></td>
          <td><?php echo $order['user_id']; ?></td>
          <td><?php echo $order['order_date']; ?></td>
          <td><?php echo $order['user_phone']; ?></td>
          <td><?php echo $order['user_address']; ?></td>
          <td><a class="btn btn-primary" href="edit_order.php?order_id=<?php echo $order['order_id']; ?>">Edit</a></td>
          <td><a class="btn btn-danger" href="delete_order.php?order_id=<?php echo $order['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
</td>

        </tr>
        <?php } ?>
      </tbody>

    </table>


        <nav aria-label="Page navigation example">
          <ul class="pagination mt-5">
            <li class="page-item <?php if($page_no<=1){echo 'disabled';} ?>">
<a class="page-link" href="<?php if($page_no<=1){echo '#';}else{echo '?page_no='.($page_no-1);} ?>">Previous</a>
</li>       
             <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>
    
            <?php if($page_no>=3){ ?>
            <li class="page-item"><a class="page-link" href="#">...</a></li>


            <li class="page-item"><a class="page-link" href="<?php echo '?page_no='.$page_no; ?>"><?php echo $page_no; ?></a></li>


            <?php }?>

            <li class="page-item <?php if($page_no>=$total_no_of_pages){echo 'disabled';} ?>">
<a class="page-link" href="<?php if($page_no>=$total_no_of_pages){echo '#';}else{echo '?page_no='.($page_no+1); } ?>">Next</a>
</li>



         </ul>

        </nav>







  </div>



</main>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>

