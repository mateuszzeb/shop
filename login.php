<?php
require_once ("main.php");
if(isset($_SESSION['username'])){
    header("Location: index.php");
    $_SESSION['messages'][] = "Zaloguj się;red";
    exit();
}
if(isset($_POST['login']) && isset($_POST['password'])){
    if(login($_POST['login'], $_POST['password'])){
        header("Location: index.php");
        exit();
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
    <script src="js/main.js"></script>
    <?php require_once ("head.php"); ?>
    <title>Logowanie</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article>
        <form action="" method="post">
            <h2>Logowanie</h2>
            <label for="login"></label>
            <input id="login" name="login" type="text" placeholder="Login" pattern="^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{0,19}$">
            <br><br>
            <label for="password"></label>
            <input id="password" name="password" type="password" placeholder="Hasło" pattern="^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{0,19}$">
            <br><br>
            <button type="submit">OK</button>
            <br><br>
            <a href="registration.php">ZAREJESTRUJ SIĘ</a>
        </form>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once ("messages.php");
?>
</body>
</html>