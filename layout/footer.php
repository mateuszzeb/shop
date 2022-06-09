<footer>
    <div>
        <a href="index.php">Strona główna</a>
        <a href="new.php">Nowości</a>
        <a href="statistics.php">Statystyki</a>
    </div>
    <div>
        <?php
        if(isset($_SESSION['username'])){
            echo '<a href="add_product.php">Dodaj produkt</a><a href="cart.php">Koszyk - '.$cart_value.' zł</a><a href="logout.php">Wyloguj</a>';
        }
        else{
            echo '<a href="login.php">Zaloguj się</a>';
        }
        ?>
    </div>
    <div>
        Mateusz Zębala<br><br>matizeb2@gmail.com<br><br>github.com/mateuszzeb
    </div>
</footer>
