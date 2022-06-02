<?php
require_once ("main.php");
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
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
    <title>Moje adresy</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article>
        <?php
        $cart = get_cart();

        ?>
    </article>
</section>
<?php
require_once("layout/footer.php");
require_once ("messages.php");
?>

</body>
</html>