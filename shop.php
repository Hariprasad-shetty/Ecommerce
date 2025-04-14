<?php include('layouts/header.php'); ?>
<?php
    include('server/connection.php');
    $category = $_GET['category'] ?? '';
    $price = $_GET['price'] ?? '';
    $color = $_GET['color'] ?? '';

    $page_no = $_GET['page_no'] ?? 1;
    $total_records_per_page = 8;
    $offset = ($page_no - 1) * $total_records_per_page;

    $query = "SELECT * FROM products WHERE 1";
    $count_query = "SELECT COUNT(*) FROM products WHERE 1";
    $params = [];
    $types = '';

    if (!empty($category)) {
        $query .= " AND product_category=?";
        $count_query .= " AND product_category=?";
        $params[] = $category;
        $types .= 's';
    }

    if (!empty($price)) {
        $query .= " AND product_price<=?";
        $count_query .= " AND product_price<=?";
        $params[] = (int)$price;
        $types .= 'i';
    }

    if (!empty($color)) {
        $query .= " AND product_color=?";
        $count_query .= " AND product_color=?";
        $params[] = $color;
        $types .= 's';
    }

    $stmt1 = $conn->prepare($count_query);
    if (!empty($params)) $stmt1->bind_param($types, ...$params);
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->fetch();
    $stmt1->close();

    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    $query .= " LIMIT $offset, $total_records_per_page";
    $stmt2 = $conn->prepare($query);
    if (!empty($params)) $stmt2->bind_param($types, ...$params);
    $stmt2->execute();
    $products = $stmt2->get_result();
?>

<!-- Show Filters Button (mobile only) -->
<div class="filter-toggle-container d-lg-none text-start px-3">
    <button class="btn btn-primary" id="toggleSidebar">Show Filters</button>
</div>

<!-- Filters + Content -->
<div class="shop-container">
    <!-- Sidebar -->
    <aside class="shop-sidebar-overlay">
        <div class="filter-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Filters</h5>
            <button type="button" class="btn-close d-lg-none mb-3" aria-label="Close" id="closeSidebar"></button>
        </div>
        <hr />
        <form method="GET" action="shop.php">
            <!-- Category -->
            <div class="mb-3">
                <p class="fw-bold">Category</p>
                <?php $categories = ['shoe', 'Clothes', 'Watch', 'Bags']; ?>
                <?php foreach ($categories as $cat): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" value="<?= $cat ?>" id="cat_<?= $cat ?>" <?= ($category == $cat) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="cat_<?= $cat ?>"><?= ucfirst($cat) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Price -->
            <div class="mb-3">
                <p class="fw-bold">Price</p>
                <?php foreach ([50, 100, 200, 500, 1000] as $p): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="price" value="<?= $p ?>" id="price_<?= $p ?>" <?= ($price == $p) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="price_<?= $p ?>">Under $<?= $p ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Color -->
            <div class="mb-3">
                <p class="fw-bold">Color</p>
                <?php foreach (['black', 'white', 'red', 'blue', 'green'] as $c): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="color" value="<?= $c ?>" id="color_<?= $c ?>" <?= ($color == $c) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="color_<?= $c ?>"><?= ucfirst($c) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">Apply Filters</button>
            <!-- Reset Filters Button -->
            <a href="shop.php" class="btn btn-secondary mt-2 w-100">Reset Filters</a>
        </form>
    </aside>



    <!-- Product List -->
    <section class="shop-content">
        <div class="container text-center mt-4">
            <h3>Our Products</h3>
            <hr class="mx-auto" />
        </div>
        <div class="row mx-auto container d-flex flex-wrap justify-content-start">
            <?php if ($products->num_rows > 0): ?>
                <?php while ($row = $products->fetch_assoc()): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
                        <div class="product text-center w-100 d-flex flex-column shadow-sm p-2">
                            <img class="img-fluid mb-3" src="assets/imgs/<?= $row['product_image'] ?>" alt="<?= $row['product_name'] ?>" />
                            <h5 class="p-name"><?= $row['product_name'] ?></h5>
                            <h4 class="p-price">$<?= $row['product_price'] ?></h4>
                            
                            <!-- Star Rating -->
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            
                            <a class="btn btn-sm w-50 mx-auto mt-auto" href="single_product.php?product_id=<?= $row['product_id'] ?>">Buy Now</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center w-100 p-5">No products found.</div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_no_of_pages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page_no <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page_no=<?= max(1, $page_no - 1) ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_no_of_pages; $i++): ?>
                    <li class="page-item <?= ($page_no == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page_no=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page_no=<?= min($total_no_of_pages, $page_no + 1) ?>">Next</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </section>
</div>

<?php include('layouts/footer.php'); ?>

<!-- Toggle Sidebar Script -->
<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const sidebar = document.querySelector('.shop-sidebar-overlay');
    const shopContainer = document.querySelector('.shop-container');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.add('active');
        shopContainer.classList.add('shifted');
    });

    closeBtn?.addEventListener('click', () => {
        sidebar.classList.remove('active');
        shopContainer.classList.remove('shifted');
    });
</script>

<!-- CSS for Shop and Sidebar -->
<style>
    /* Ensure the filter sidebar is hidden by default on mobile */
    .shop-sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
     /*   width: 250px;*/
        width: 100%;
        height: 100%;
        background: #fff;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        overflow-y: auto;
        padding: 10px;
    }

    /* Show the filter sidebar when active class is added */
    .shop-sidebar-overlay.active {
        display: block;
        
    }

    /* Button styling */
    .filter-toggle-container {
        position: relative;
        
        z-index: 1001;
        background: #fff;
        padding-top: 100px;
    }

    .shop-container {
        display: flex;
        flex-wrap: wrap;
       
        margin-top: 0;
        min-height: 80vh;
        padding-top: 20px;
        transition: margin-left 0.3s ease-in-out;
        
        
    }
.shop-content{
   width: 100%;
   
}

.product img{
   height: 200px;
   object-fit: contain;
}

.product .btn{
    background-color: #fb774b;
    color: #fff;
}
    


    .shop-container.shifted {
        margin-left: 250px;
        
    }

    @media (max-width: 991px) {
        .shop-container {
            
            margin-left: 0;
           
        }
        



    }






</style>
