<?php
include('../connect/connect.php');
if(isset($_POST['remove-cart'])) {
    global $connect;
    $id = $_POST['product_id'];
    $delete_query = "delete from cart where product_id='$id'";
    $result_query = mysqli_query($connect, $delete_query);
    if($result_query){  
        echo "<script>window.location.href='http://localhost/ecommerce/product/list_product.php';</script>";
    }else echo"$id";
}


?>