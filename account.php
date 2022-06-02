<?php
require_once ("main.php");
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
else if(isset($_POST['last_name']) && isset($_POST['first_name']) && isset($_POST['email'])){
    update_user($_POST['last_name'], $_POST['first_name'], $_POST['email']);
}
if (isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['password3'])){
    change_password($_POST['password1'], $_POST['password2'], $_POST['password3']);
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
    <title>Twoje konto</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article>
        <?php
            $user  = get_user('username', $_SESSION['username']);
        ?>
         <div class="drop-down">
            <div class="top">
                <span class="title">Zakupy</span>
                <span class="arrow"><i class="fa-solid fa-angle-down"></i></span>
            </div>
            <div class="content">
                <?php
                    $orders = get_my_orders();
                    if($orders->num_rows == 0){
                        echo "<div class='maxwcenter'>Brak histori zakupów</div>";
                    }
                    else{
                        while($order = $orders->fetch_assoc()){
                            $product = get_product($order['product_id']);
                            echo "<div class='order'>".$product['title']." <br> ".$order['date']." <br> Cena: ".$product['price']." zł <br> Status: ".$order['status']."</div>";
                        }
                    }
                ?>
            </div>
        </div>
        <div class="drop-down">
            <div class="top">
                <span class="title">Edytuj profil</span>
                <span class="arrow"><i class="fa-solid fa-angle-down"></i></span>
            </div>
            <div class="content">
                <form action="" method="POST">
                    <h2>Edytuj profil</h2>
                    <label for="first_name"></label>
                    <input id="first_name" name="first_name" type="text" placeholder="Imię" pattern="^[a-zA-ZąćęśłóńżźĄĆĘÓŚŁŻŹŃ]{0,20}$" value="<?php echo $user['first_name']; ?>">
                    <br><br>
                    <label for="last_name"></label>
                    <input id="last_name" name="last_name" type="text" placeholder="Nazwisko" pattern="^[a-zA-ZąćęśłóńżźĄĆĘÓŚŁŻŹŃ]{0,20}$" value="<?php echo $user['last_name']; ?>">
                    <br><br>
                    <label for="email"></label>
                    <input id="email" name="email" type="email" placeholder="E-mail" value="<?php echo $user['email']; ?>">
                    <br><br>
                    <button type="submit">Zapisz</button>
                </form>
            </div>
        </div>
        <div class="drop-down">
            <div class="top">
                <span class="title">Zmień hasło</span>
                <span class="arrow"><i class="fa-solid fa-angle-down"></i></span>
            </div>
            <div class="content">
                <form action='' method="POST">
                    <h2>Zmień hasło</h2>
                    <label for="password1"></label>
                    <input id="password1" name="password1" type="password" placeholder="Stare hasło">
                    <br><br>
                    <label for="password2"></label>
                    <input id="password2" name="password2" type="password" placeholder="Nowe hasło">
                    <br><br>
                    <label for="password3"></label>
                    <input id="password3" name="password3" type="password" placeholder="Powtórz nowe hasło">
                    <br><br>
                    <button type="submit">Zmień</button>
                </form>
            </div>
        </div>
        <div class="drop-down">
                <div class="top">
                    <span class="title">Twoje adresy</span>
                    <span class="arrow"><i class="fa-solid fa-angle-down"></i></span>
                </div>
                <div class="content">
                    <br><br><br>
                    <?php
                        $addresses = get_my_addresses();
                        if($addresses->num_rows == 0){
                            echo "<div class='maxwcenter'>Brak adresów</div>";
                        }
                        else{
                            while($address = $addresses->fetch_assoc()){
                                echo "<div class='address'>".$address['country']." | ".$address['city']." | ".$address['address']." | ".$address['postal_code']." <a href='delete_address.php?id=".$address['id']."'>Usuń</a></div>";
                            }
                        }
                       
                    ?>
                    <br><br><br><br>
                    <a href="add_address.php">Dodaj adres</a>
                </div>
            </div>
       
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once ("messages.php");
?>

</body>
</html>