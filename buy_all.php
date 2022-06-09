<h1>s</h1>
<?php
require_once("main.php");
if (!isset($_SESSION['username'])) {
    $_SESSION['messages'][] = "Zaloguj się;red";
    go_to("login.php");
}
if(sizeof(get_cart()) == 0){
    header("Location: cart.php");exit();
}
if (isset($_POST['true'])) {
    $_SESSION['messages'][] = ';red';
    $ok = true;
    foreach(get_cart() as $item){
        if(!buy($item, 1, $_POST['address'])){
            $ok = false;
        }
    }
    if($ok){
        $_SESSION['messages'] = array();
        $_SESSION['messages'][] = 'Zakupiono wszystkie produkty;green';
    }
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
    <?php require_once("head.php"); ?>
    <title>Kup wszystko</title>
</head>

<body>
    <?php
    require_once("layout/nav.php");
    ?>

    <section>
        <article>
            <h2 class="center_content">Czy napewno chcesz kupić te produkty?</h2>
            <ul class="center_content">
                <?php
                    $cart  = get_cart();
                    foreach ($cart as $item) {
                        echo "<li>" . get_product($item)['title'] . "</li>";
                    }
                ?>
            </ul>
            <form action="" method="post">
                <input type="hidden" name="true">
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
    require_once("messages.php");
    ?>
</body>

</html>