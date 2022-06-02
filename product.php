<?php
require_once("main.php");
if(isset($_GET['id'])){
    $product = get_product($_GET['id']);
}
else{
    header("Location: index.php");
    $_SESSION['message'][] = "Produkt nie istnieje;red";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once ("head.php"); ?>
    <title><?php echo $product['title']; ?></title>
</head>
<body>
    <?php
        require_once ("layout/nav.php");
        if(isset($_SESSION['username']) && (is_mine($product['id_seller']) || get_user('username', $_SESSION['username'])['admin'] == true)){
            require_once("layout/admin_menu.php");
        }
    ?>
    <section>
        <article class="product">
            <div class="slider_div">
                <div class="slider_buttons">
                    <button onclick="change_image(-1);"><i class="fa-solid fa-arrow-left"></i></button>
                    <button onclick="change_image(1);"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
                <div class="img">

                    <?php
                    $image_counter = 0;
                    foreach (get_images($product['id']) as $image){
                        echo '<img id="image_slider_'.$image_counter.'" src="img/products/'.$image['name'].'" alt="'.$product['title'].'">';
                        $image_counter+=1;
                    }
                    ?>

                </div>
            </div>


            <div class="right">
                <h2><?php echo $product['title']; ?></h2>
                <div class="user">
                    <img src="img/user.png" alt="">
                    <?php echo get_user('id', $product['id_seller'])['first_name']; ?>
                    <br>
                   
                </div>
                <h1><?php echo $product['pieces']; ?> szt.</h1>
                <h1><?php echo $product['name']; ?></h1>
                <h1 class="price"><?php echo $product['price']; ?> PLN</h1>
                <form action="cart.php" method="get">
                    <input type="hidden" name="todo" value="add">
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <button type="submit">DODAJ DO KOSZYKA</button>
                    <br><br>
                    <a href="buy.php?id=<?php echo $product['id']; ?>" class="button_a buy_button">KUP</a>
                </form>
                
            </div>
            <section class="description">
                <p><?php echo $product['description']; ?></p>
            </section>
        </article>
    </section>
    <?php
        require_once("layout/footer.php");
        require_once("messages.php");
    ?>
    <script src="js/main.js"></script>
    <script src="js/slider.js"></script>
    <?php
        if(isset($_SESSION['add_successful'])){
            if($_SESSION['add_successful'] == "done"){
                echo '<script>message("Dodano do koszyka!", "green");</script>';
                $_SESSION['add_successful'] = "";
            }
            else if($_SESSION['add_successful'] == "error"){
                echo '<script>message("Nie dodano do koszyka!", "red");</script>';
                $_SESSION['add_successful'] = "";
            }
        }

    ?>
</body>
</html>