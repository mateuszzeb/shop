<?php
require_once ("main.php");
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    $_SESSION['messages'][] = "Zaloguj się;red";
    exit();
}
if(isset($_GET['id'])){
    $product = get_product($_GET['id']);
    if(get_user('id', $product['id_seller'])['username'] == $_SESSION['username'] || get_user('username', $_SESSION['username'])['admin'] == true){
        if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['category']) && isset($_POST['pieces'])){
            $title = $_POST['title'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $id = $_GET['id'];
            $pieces = $_POST['pieces'];
            $category = $_POST['category'];
            if(edit_product($id, $title, $price, $description, $category, $pieces)){
                $result = "Zmieniono dane";
            }
            $product = get_product($_GET['id']);
        }
    }
    else{
        header("Location: index.php");
        $_SESSION['messages'] = array("Nie możesz edytować produktu;red");
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
    <script src="js/main.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once ("head.php"); ?>
    <title>Edycja produktu</title>
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
        <form action="" method="post">
            <h2>Edycja produktu</h2>
            <label for="title"></label>
            <input id="title" autofocus name="title" type="text" placeholder="Tytuł" pattern="^.{0,255}$" value="<?php echo $product['title']; ?>">
            <br><br>
            <label for="price"></label>
            <input id="price" name="price" type="number" placeholder="Cena w PLN" step="0.01" value="<?php echo $product['price']; ?>">
            <br><br>
            <label for="pieces"></label>
            <input id="title" name="pieces" type="number" placeholder="Ilość sztuk" pattern="^[0-9]{0,10}$" min="0" value="<?php echo $product['pieces']; ?>">
            <br><br>
            <label for="description"></label>
            <textarea cols="24" id="description" name="description" placeholder="Opis"><?php echo $product['description']; ?></textarea>
            <br><br>
            <select name="category" id="category">
                <?php
                foreach(get_categories() as $category){
                    echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                }
                ?>
            </select>
            <script>
                document.querySelector("article form #category").value = "<?php echo $product['category']; ?>";
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