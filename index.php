<?php
require_once ("main.php");
$products = get_last_products(30);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <script src="js/main.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once ("head.php"); ?>
    <title>Strona główna</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article class="index">
        <div class="categories">
            <a href="search.php?category=elektronika" style="--color-of-i: #cc57fa"><i class="fa-solid fa-mobile-screen-button"></i>Elektronika</a>
            <a href="search.php?category=motoryzacja" style="--color-of-i: #ffea00"><i class="fa-solid fa-car"></i>Motoryzacja</a>
            <a href="search.php?category=ogrod" style="--color-of-i: #236900"><i class="fa-solid fa-tree"></i>Ogród</a>
            <a href="search.php?category=zdrowie" style="--color-of-i: #0080ff"><i class="fa-solid fa-briefcase-medical"></i>Zdrowie</a>
            <a href="search.php?category=moda" style="--color-of-i: #ee5353"><i class="fa-solid fa-shirt"></i>Moda</a>
            <a href="search.php?category=sport" style="--color-of-i: #098f09"><i class="fa-solid fa-futbol"></i>Sport</a>
            <a href="search.php?category=edukacja" style="--color-of-i: #50211b"><i class="fa-solid fa-graduation-cap"></i>Edukacja</a>
            <a href="search.php?category=dzieci" style="--color-of-i: #ff6a00"><i class="fa-solid fa-child"></i>Dla dzieci</a>
            <a href="search.php?category=literatura" style="--color-of-i: #ee5353"><i class="fa-solid fa-book"></i></i>Literatura</a>

        </div>

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
require_once ("messages.php");
?>
</body>
</html>