<?php
    foreach ($_SESSION['messages'] as $message){
        $message = explode(";", $message);
        echo '<script>message("'.$message[0].'", "'.$message[1].'")</script>';
    }
    $_SESSION['messages'] = array();
?>