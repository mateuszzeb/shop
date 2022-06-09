<?php
    require_once('main.php');
    header("Access-Control-Allow-Origin: *");
    echo "{";
    $products = search_products($_GET['q']);
    while($product = $products->fetch_assoc()){
        echo "'".$product['title']."',";
    }
    echo "}";
?>