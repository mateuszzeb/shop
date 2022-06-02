<?php
    require_once("main.php");
    if(isset($_GET['id'])){
        if(isset($_SESSION['username'])){
            if(delete_address($_GET['id'])){
                
            }
            $_SESSION['messages'][] = "Usunięto adres;green";
        }
        else{
            $_SESSION['messeges'][] = "Zaloguj się;red";
            header('Location: login.php');
            exit();
        }
    }
    if(empty($_SERVER['HTTP_REFERER'])){
        header('Location: '.$_GLOBALS['url']);
    }
    else{
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
  
    exit();
?>