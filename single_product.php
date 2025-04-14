<?php include('layouts/header.php'); ?>


<?php
   ob_start();
   include('server/connection.php');

   if(isset($_GET['product_id'])){
       $product_id = $_GET['product_id'];

       // Fetch current product details
       $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
       $stmt->bind_param("i", $product_id);
       $stmt->execute();
       $product = $stmt->get_result();
       
       if ($row = $product->fetch_assoc()) {
           $category = $row['product_category']; // Assuming there is a category column
       } else {
           header('location: index.php'); // Redirect if product not found
           exit();
       }

       // Fetch related products (same category, excluding current product)
       $related_stmt = $conn->prepare("SELECT * FROM products WHERE product_category = ? AND product_id != ? LIMIT 4");
       $related_stmt->bind_param("si", $category, $product_id);
       $related_stmt->execute();
       $related_products = $related_stmt->get_result();
   } else {
       header('location: index.php');
       exit();
   }
?>


<!-- Single Product -->
<section class="container single-product my-5 pt-5">
    <div class="row mt-5">
        <div class="col-lg-5 col-md-6 col-sm-12">
            <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image'];?>" id="mainImg"/>
            <div class="small-img-group d-flex justify-content-between">
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image'];?>" width="100%" class="small-img" />
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image2'];?>" width="100%" class="small-img" />
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image3'];?>" width="100%" class="small-img" />
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image4'];?>" width="100%" class="small-img" />
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <h6><?php echo ucfirst($category); ?> / Shoes</h6>
            <h3 class="py-4"><?php echo $row['product_name'];?></h3>
            <h2>$<?php echo number_format($row['product_price'], 2); ?></h2>

            <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id'];?>" />
                <input type="hidden" name="product_image" value="<?php echo $row['product_image'];?>" />
                <input type="hidden" name="product_name" value="<?php echo $row['product_name'];?>" />
                <input type="hidden" name="product_price" value="<?php echo $row['product_price'];?>" />
                <input type="number" name="product_quantity" value="1" min="1" />
                <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
            </form>

            <h4 class="mt-5 mb-4">Product Details</h4>
            <span><?php echo $row['product_description'];?></span>
        </div>
    </div>
</section>



<!-- Related Products -->
<section id="related-products" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Related Products</h3>
        <hr class="mx-auto" />
    </div>
    <div class="row mx-auto  d-flex flex-wrap container-fluid">
        <?php while($related_row = $related_products->fetch_assoc()) { ?>
            <div class="product related-card text-center col-lg-3 col-md-4 col-sm-12">
           
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $related_row['product_image']; ?>" />
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $related_row['product_name']; ?></h5>
                <h4 class="p-price">$<?php echo number_format($related_row['product_price'], 2); ?></h4>
                <a href="single_product.php?product_id=<?php echo $related_row['product_id']; ?>">
                    <button class="buy-btn">View Product</button>
                </a>

           </div>
        <?php } ?>
     </div>
</section>



<script src="assets/js/main.js"></script>

<?php include('layouts/footer.php'); ?>
