<?php
require_once ("main.php");
$mine = false;
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    $_SESSION['messages'][] = "Zaloguj się;red";
    exit();
}
if(isset($_GET['id'])){
    $product = get_product($_GET['id']);
    if(!$product){
        header("Location: index.php");
        $_SESSION['messages'][] = "Produkt nie istnieje;red";
        exit();
    }
    else{
        $mine = is_mine($product['id_seller']) || get_user('username', $_SESSION['username'])['admin'];
    }
    if(!$mine){
        header("Location: product.php?id=".$_GET['id']);
        $_SESSION['messages'][] = "Brak uprawnień;red";
        exit();
    }
}
else{
    header("Location: 404.php");
    exit();
}
if(isset($_POST['id']) && isset($_FILES['img']) && $mine){
    add_image($_POST['id'], $_FILES['img']);
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
    <title>Dodawanie obrazu</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<?php
require_once ("layout/nav.php");
if(isset($_SESSION['username']) && $mine){
    require_once("layout/admin_menu.php");
}
?>
<section>
    <article>
        <form action="" method="post" enctype="multipart/form-data">
            <h2>Dodawanie zdjęcia</h2>
            <label for="img"></label>
            <input id="img" name="img" type="file">
            <br><br>
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <button type="submit">Dodaj</button>
        </form>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once("messages.php");
?>
</body>
</html>