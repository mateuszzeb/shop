<?php
    require_once ("main.php");
    if(!isset($_SESSION['username'])){
        $_SESSION['messages'][] = "Zaloguj się;red";
        go_to("login.php");
    }
    if(isset($_GET['id'])){
        $product = get_product($_GET['id']);
    }
    if(isset($_POST['id']) && isset($_POST['pieces']) && isset($_POST['address'])){
        buy($_POST['id'], $_POST['pieces'], $_POST['address']);
        
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
    <title><?php echo$product['title']; ?></title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>

<section>
    <article>
        <form action="" method="post">
            <h2><?php echo $product['title']; ?></h2>
            <input type="hidden" name='id' value='<?php echo $_GET['id']; ?>'>
            <label for="pieces"></label>
            <input id="pieces" name="pieces" type="hidden" value="1">
            <div class="pieces_counter">
                <h1>Ilość sztuk</h1>
                <span class="button_span" add='-1'><i class="fa-solid fa-minus"></i></span>
                <span class="counter">1</span>
                <span class="button_span" add='+1'><i class="fa-solid fa-plus"></i></sp>
            </div>
            <br><br>
            <label for="address"></label>
            <select name="address" id="address">
                <option>--- Wybierz adres ---</option>
                <?php
                    foreach(get_my_addresses() as $address){
                            echo '<option value="'.$address['id'].'">'.$address['city'].' | '.$address['address'].' | '.$address['postal_code'].'</option>';
                    }
                ?>
            </select>
            <br><br>
            <button type="submit">KUP</button>
        </form>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once ("messages.php");
?>
</body>
</html>