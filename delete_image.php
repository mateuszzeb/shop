<?php
require_once ("main.php");
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    $_SESSION['messages'][] = "Zaloguj się;red";
    exit();
}
if(isset($_GET['id'])){
    $product = get_product($_GET['id']);
    if(!is_mine($product['id_seller'])&&!get_user('username', $_SESSION['username'])['admin'] == true){
        header("Location: index.php");
        $_SESSION['messages'] = array("Brak uprawnień;red");
    }
    else{
        if(isset($_GET['image_id'])){
            if(delete_image($_GET['image_id'])){
                $_SESSION['messages'][] = "Usunięto obraz;green";
            }else{
                $_SESSION['messages'][] = "Błąd usuwania obrazu;red";
            }
            header("Location: delete_image.php?id=".$product['id']);
            exit();
        }
    }
}
if(isset($_POST['id']) && isset($_FILES['img']) && (is_mine($product['id_seller'])||get_user('username', $_SESSION['username'])['admin'] == true)){
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
    <title>Usuwanie obrazów</title>
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
       <div class="delete_images">
           <?php
           foreach (get_images($product['id']) as $image) {
               echo '<div class="image"><img src="img/products/'.$image['name'].'"><br><a href="delete_image.php?image_id='.$image['id'].'&id='.$product['id'].'">Usuń</a></div>';
           }
           ?>
       </div>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once("messages.php");
?>
</body>
</html>