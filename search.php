<?php
require_once ("main.php");
if(isset($_GET['q'])){
    $products = search($_GET['q']);
    $title = $_GET['q'];
}
else{
    if(empty($_GET['category'])){
        header("Location: index.php");
    }
    $products = select_by_category($_GET['category']);
    $title = $_GET['category'];
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/main.js"></script>
    <?php require_once ("head.php"); ?>
    <title><?php echo "Wyniki dla: ".$title; ?></title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article class="products_show">
        <?php
            if($products->num_rows < 1){
                if(isset($_GET['q'])){
                    echo '<h1 class="center">Brak wyników dla: "'.$_GET['q'].'"</h1>';
                }
            }
            else{
                while($product = $products->fetch_assoc()){
                    $img = $connect->query("SELECT name FROM images WHERE product_id='".$product['id']."' ORDER BY date LIMIT 1");
                    if($img->num_rows == 0){
                        $img = "default.png";
                    }
                    else{
                        $img = $img->fetch_assoc()['name'];
                    }
                    $product['price'] = number_format($product['price'],"2", ".", "");
                    $path = "'img/products/".$img."'";
                    echo '<a class="div_a" href="product.php?id='.$product['id'].'"><div class="product"><div class="img" style="background-image: url('.$path.');" alt="'.$product['title'].'"></div><h1>'.add_dots($product['title'], 20).'</h1><span>'.$product['price'].' zł</span></div></a>'    ;

                };
            }

        ?>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once("messages.php");
?>
</body>
</html>