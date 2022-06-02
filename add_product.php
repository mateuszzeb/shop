<?php
require_once ("main.php");
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    $_SESSION['messages'][] = "Zaloguj się;red";
    exit();
}
if(isset($_POST['title']) && isset($_FILES['img']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['category']) && isset($_POST['pieces'])){
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $img = $_FILES['img'];
    $seller = $_SESSION['username'];
    $category = $_POST['category'];
    $pieces = $_POST['pieces'];
    $result = create_product($title, $price, $description, $img, $seller, $category, $pieces);
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
    <title>Dodawanie produktu</title>
</head>
<body>
<?php
require_once ("layout/nav.php");
?>
<section>
    <article>
        <form action="" method="post" enctype="multipart/form-data">
            <h2>Dodawanie produktu</h2>
            <label for="title"></label>
            <input id="title" name="title" type="text" placeholder="Tytuł" pattern="^.{0,255}$">
            <br><br>
            <label for="price"></label>
            <input id="price" name="price" type="number" placeholder="Cena w PLN" step="0.01">
            <br><br>
            <label for="description"></label>
            <textarea cols="24" id="description" name="description" placeholder="Opis"></textarea>
            <br><br>
            <label for="pieces"></label>
            <input id="title" name="pieces" type="number" placeholder="Ilość sztuk" pattern="^[0-9]{0,10}$" min="0">
            <br><br>
            <label for="img"></label>
            <input id="img" name="img" type="file">
            <br><br>
            <select name="category" id="category">
                <option value="" style="color: lightgrey">Wybierz kategorie</option>
                <?php
                foreach(get_categories() as $category){
                    echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                }
                ?>
            </select>
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