<?php
    require_once ("main.php");
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit();
    }
    if(isset($_GET['id']) && isset($_GET['todo']) && $_GET['todo']=='add'){
        $_SESSION['cart'][] = $_GET['id'];
        $done = "done";
        $_SESSION['add_successful'] = $done;
        header('Location: product.php?id='.$_GET['id']);
        exit();
    }
    if(isset($_GET['id']) && isset($_GET['todo']) && $_GET['todo']=='delete'){
        $new_cart = array();
        for($i = 0; $i < count($_SESSION['cart']); $i++){
            if($i != intval($_GET['id'])){
                $new_cart[] = $_SESSION['cart'][$i];
            }
        }
        $_SESSION['cart'] = $new_cart;
        header("Location: cart.php");
        exit();
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
    <title>Koszyk</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article>

        <?php
            $cart = get_cart();
            if(sizeof($cart) != 0){
                echo '<div class="center_content w100"><a href="buy_all.php" class="button_a">Kup wszystko</a></div>';
            }
            if($cart){
                for ($i = 0; $i < count($cart); $i++){
                    $product = get_product($cart[$i]);
                    $image = get_images($product['id'])->fetch_assoc()['name'];
                    echo '<div class="cart_product"><img class="cart_img" height="120" src="img/products/'.$image.'" alt=""><h1>'.add_dots($product['title'],25).'</h1><span>'.$product['price'].' zł</span><a class="delete_a" href="cart.php?todo=delete&id='.$i.'">Usuń</a><a class="button_a" href="buy.php?id='.$product['id'].'">ZAMÓW</a></div>';
                }
            }
            else{
                echo "<div class='maxwcenter'><h1 class='center'>Koszyk jest pusty</h1></div>";
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