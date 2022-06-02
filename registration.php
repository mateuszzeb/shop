<?php
require_once ("main.php");
if(isset($_SESSION['username'])){
    header("Location: index.php");
}
if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['last_name']) && isset($_POST['first_name']) && isset($_POST['email'])){
    $result = registration($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['login'], $_POST['password'], $_POST['password2']);
    if($result){
        go_to("login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once ("head.php"); ?>
    <title>Rejestracja</title>
    <script src="js/main.js"></script>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article>
        <form action="" method="post">
            <h2>Rejestracja</h2>
            <label for="first_name"></label>
            <input id="first_name" name="first_name" type="text" placeholder="Imię" pattern="^[a-zA-ZąćęśłóńżźĄĆĘÓŚŁŻŹŃ]{0,20}$">
            <br><br>
            <label for="last_name"></label>
            <input id="last_name" name="last_name" type="text" placeholder="Nazwisko" pattern="^[a-zA-ZąćęśłóńżźĄĆĘÓŚŁŻŹŃ]{0,20}$">
            <br><br>
            <label for="email"></label>
            <input id="email" name="email" type="email" placeholder="E-mail">
            <br><br>
            <label for="login"></label>
            <input id="login" name="login" type="text" placeholder="Login" pattern="^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{0,19}$">
            <br><br>
            <label for="password"></label>
            <input id="password" name="password" type="password" placeholder="Hasło" pattern="^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{0,19}$">
            <br><br>
            <label for="password2"></label>
            <input id="password2" name="password2" type="password" placeholder="Powtórz hasło" pattern="^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{0,19}$">
            <br><br>
            <button type="submit">OK</button>
            <br><br>
            <a href="login.php">ZALOGUJ SIĘ</a>
            <br>
        </form>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once ("messages.php");
?>
</body>
</html>