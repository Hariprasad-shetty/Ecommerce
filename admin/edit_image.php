<?php ob_start(); include("header.php"); ?>


<?php

  if(isset($_GET['product_id'])){
       $product_id=$_GET['product_id'];
$product_name=$_GET['product_name'];
}else{

header("location: products.php");

}

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

  <h2>Update Images</h2>
  <div class="table-responsive">
    <div class="mx-auto container">
      <form id="edit-image-form" enctype="multipart/form-data" method="POST" action="update_images.php">

        <p style="color: red"><?php if(isset($_GET['error'])){echo $_GET['error']; } ?></p>

        <input type="hidden" name="product_id" value="<?php echo $product_id?>" />

        <input type="hidden" name="product_name" value="<?php echo $product_name?>" />



        <div class="form-group mt-2">
          <label>Image 1</label>
          <input type="file" class="form-control" id="image1" name="image1" placeholder="Image 1" required />
        </div>

        <div class="form-group mt-2">
          <label>Image 2</label>
          <input type="file" class="form-control" id="image2" name="image2" placeholder="Image 2" required />
        </div>

        <div class="form-group mt-2">
          <label>Image 3</label>
          <input type="file" class="form-control" id="image3" name="image3" placeholder="Image 3" required />
        </div>

        <div class="form-group mt-2">
          <label>Image 4</label>
          <input type="file" class="form-control" id="image4" name="image4" placeholder="Image 4" required />
        </div>

        <div class="form-group mt-2">
          <input type="submit" class="btn btn-primary" name="update_images" value="Update" />
 
        </div>

      </form>
    </div>
  </div>
</main>
</div>
</div>


