<div class="admin_menu">
    <div class="left">
        <a href="<?php echo "product.php?id=".$product['id']; ?>">Produkt</a>
        <a href="<?php echo "edit_product.php?id=".$product['id']; ?>">Edytuj dane</a>
        <a href="<?php echo "delete_image.php?id=".$product['id']; ?>">Usuń zdjęcie</a>
        <a href="<?php echo "add_image.php?id=".$product['id']; ?>">Dodaj zdjęcie</a>
        <a href="<?php echo "delete_product.php?id=".$product['id']."&sure=false"; ?>">Usuń produkt</a>
    </div>
    <div class="right"><button>Edytuj</button></div>
</div>