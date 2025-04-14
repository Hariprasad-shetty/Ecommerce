<?php

  include('connection.php');

 /* $stmt=$conn->prepare("SELECT * from products where product_category='Watch' LIMIT 4");
*/

$stmt = $conn->prepare("SELECT * FROM products WHERE LOWER(product_category) LIKE '%watch%' LIMIT 3");

  $stmt->execute();

  $watches=$stmt->get_result();

?>
