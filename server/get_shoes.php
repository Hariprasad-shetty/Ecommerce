<?php

  include('connection.php');

  $stmt=$conn->prepare("SELECT * from products where product_category='shoe' LIMIT 3");

  $stmt->execute();

  $shoes=$stmt->get_result();

?>
