<?php
    $cart_value = cart_counter();
    $cart_value = number_format($cart_value,"2", ".", "");
?>
<header>
    <div class="left">
        <a href="index.php">OXO</a>
    </div>
    <div class="center">

    </div>
    <div class="right">
        <?php
        if(isset($_SESSION['username'])){
            echo '<a class="button_a add_product" href="add_product.php">Dodaj produkt</a><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i> ('.$cart_value.' zł)</a><a href="logout.php">Wyloguj</a><a href="account.php"><i class="fa-solid fa-user"></i></a>';  
        }else{
            echo '<a href="login.php">Zaloguj się</a>';
        }
        ?>
    </div>
</header>
<nav>
    <div class="left">
        <button class="mobilemenu_btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    <div class="center">
        <a href="index.php">Home</a>
        <a href="new.php">Nowości</a>
        <a href="statistics.php">Statystyki</a>
    </div>
    <div class="right">
        <input type="text" class="search_input">
        <button class="search_btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    <div class="mobilemenu">
        <a href="index.php">Strona główna</a>
        <a href="new.php">Nowości</a>
        <a href="statistics.php">Statystyki</a>
    </div>
</nav>
