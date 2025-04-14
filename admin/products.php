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


     $stmt1=$conn->prepare("SELECT COUNT(*) AS total_records from products");
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



$stmt2=$conn->prepare("SELECT * FROM  products LIMIT $offset,$total_records_per_pages");

$stmt2->execute();
$products=$stmt2->get_result();






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

  <h2>Products</h2>
  <?php if(isset($_GET['edit_success_message'])){ ?>
    <p class="text-center" style="color: green"><?php echo $_GET['edit_success_message']; ?></p>
<?php } ?>

  <?php if(isset($_GET['edit_failure_message'])){ ?>
    <p class="text-center" style="color: red"><?php echo $_GET['edit_failure_message']; ?></p>
<?php } ?>


  <?php if(isset($_GET['deleted_successfully'])){ ?>
    <p class="text-center" style="color: green"><?php echo $_GET['deleted_successfully']; ?></p>
<?php } ?>



  <?php if(isset($_GET['deleted_failure'])){ ?>
    <p class="text-center" style="color: red"><?php echo $_GET['deleted_failure']; ?></p>
<?php } ?>






  <?php if(isset($_GET['product_created'])){ ?>
    <p class="text-center" style="color: green"><?php echo $_GET['product_created']; ?></p>
<?php } ?>



  <?php if(isset($_GET['product_failed'])){ ?>
    <p class="text-center" style="color: red"><?php echo $_GET['product_failed']; ?></p>
<?php } ?>



  <?php if(isset($_GET['images_updated'])){ ?>
    <p class="text-center" style="color: green"><?php echo $_GET['images_updated']; ?></p>
<?php } ?>



  <?php if(isset($_GET['images_failed'])){ ?>
    <p class="text-center" style="color: red"><?php echo $_GET['images_failed']; ?></p>
<?php } ?>





  <p class="text-center"></p>
  <div class="table-responsive">
    <table class="table table-striped table-sm">

      <thead>
        <tr>
          <th scope="col">Product Id</th>
          <th scope="col">Product Image</th>
          <th scope="col">Product Name</th>
          <th scope="col">Product Price</th>
          <th scope="col">Product offer</th>
          <th scope="col">Product Category</th>
          <th scope="col">Product Color</th>
    

          <th scope="col">Edit Images</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
  
        <?php foreach($products as $product){ ?>
        <tr>
          <td><?php echo $product['product_id']; ?></td>
          <td><img src="<?php echo "../assets/imgs/".$product['product_image']; ?>" style ="width: 70px; height:70px" /></td>
          <td><?php echo $product['product_name']; ?></td>
          <td><?php echo "$".$product['product_price']; ?></td>
          <td><?php echo $product['product_special_offer']."%"; ?></td>
          <td><?php echo $product['product_category']; ?></td>
          <td><?php echo $product['product_color']; ?></td>


          <td><a class="btn btn-warning" href="<?php echo "edit_image.php? product_id=". $product['product_id']."& product_name=".$product['product_name']; ?> ">Edit Images</a></td>


          <td><a class="btn btn-primary" href="edit_product.php? product_id=<?php echo $product['product_id']; ?> ">Edit</a></td>
          <td><a class="btn btn-danger" href="delete_product.php? product_id=<?php echo $product['product_id']; ?>">Delete</a></td>

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

