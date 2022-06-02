<?php
require_once("main.php");
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    $_SESSION['messages'][] = "Zaloguj się;red";
    exit();
    
}
$product = get_product(intval($_GET['id']));
if(isset($_GET['sure']) && $_GET['sure'] == "true"){
    if(isset($_GET['id'])){
        $product = get_product(intval($_GET['id']));
        if(is_mine($product['id_seller']) || get_user('username', $_SESSION['username'])['admin'] == true){
            delete_product($_GET['id']);
            header("Location: index.php");
            $_SESSION['messages'][] = "Usunięto produkt;red";
            exit();
        }
        else{
            $_SESSION['messages'][] = "Nie możesz usunąć produktu;red";

            header("Location: product.php?id=".$_GET['id']."&j=".sizeof($_SESSION['messages']));
            exit();
        }
    }
    else{
        header("Location: index.php");
    }
}
else{

}
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
    <title>Usuń produkt</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<?php
require_once ("layout/nav.php");
if(isset($_SESSION['username']) && (is_mine($product['id_seller']) || get_user('username', $_SESSION['username'])['admin'] == true)){
    require_once("layout/admin_menu.php");
}
?>
<section>
    <article>
        <form>
            <h2>Napewno chcesz usunąć ten produkt?</h2>
            <p><?php echo $product['title']; ?></p>
            <br>
            <a class="button_a" href="delete_product.php?sure=true&id=<?php echo $_GET['id']; ?>">TAK</a>
            <a class="button_a" href="product.php?id=<?php echo $_GET['id']; ?>">NIE</a>
            
        </form>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once ("messages.php");
?>
</body>
</html>