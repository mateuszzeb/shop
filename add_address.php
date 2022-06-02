<?php
    require_once ("main.php");
    if(!isset($_SESSION['username'])){
        $_SESSION['messages'][] = "Zaloguj się;red";
        go_to("login.php");
    }
    if(is_set("country", "city", "postal_code", "address")) {
        add_address($_POST['country'], $_POST['city'], $_POST['postal_code'], $_POST['address']);
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
    <title>Dodawanie adresu</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article>
        <form action="" method="post">
            <h2>Dodaj adres</h2>
            <label for="city"></label>
            <input id="city" name="city" type="city" placeholder="Miasto" step="0.01" value="">
            <br><br>
            <label for="postal_code"></label>
            <input id="postal_code" name="postal_code" type="text" placeholder="Kod pocztowy" pattern="[0-9]{2}-?[0-9]{3}" value="">
            <br><br>
            <label for="address"></label>
            <input id="address" autofocus name="address" type="text" placeholder="Adres" pattern="^.{0,120}$" value="">
            <br><br>
            <label for="country"></label>
            <select name="country" id="country">

                <?php
                    foreach(get_countries() as $country){
                            echo '<option value="'.$country['name'].'">'.$country['name'].' - '.$country['continent'].'</option>';
                    }
                ?>
            </select>
            <script>
                document.querySelector("#country").value = "Polska";
            </script>
            <br><br>
            <button type="submit">Dodaj</button>
        </form>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once ("messages.php");
if(isset($result)){
    if(gettype($result) == "array"){
        foreach ($result as $error) {
            echo '<script>message("'.$error.'", "red");</script>';
        }
    }
    else{
        echo '<script>message("'.$result.'", "green");</script>';
    }
}
?>
</body>
</html>