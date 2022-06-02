<?php
session_start();
$_GLOBALS['url'] = "http://localhost/shop";
if(empty($_SESSION['messages'])){
    $_SESSION['messages'] = array();
}

$connect = new mysqli("localhost", "root", "", "shop");
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}
function is_set(...$fields){
    foreach ($fields as $field){
        if(empty($_POST[$field])){
            return false;
        }
    }
    return true;
}
function validate_field(...$items){
    foreach ($items as $item){
        if(strlen($item) == 0){
            return false;
        }
    }
    return true;
}

function get_product($id){
    global $connect;
    $result = $connect->query("SELECT products.*, categories.name FROM products JOIN categories ON products.category=categories.id WHERE products.id = '$id' LIMIT 1")->fetch_assoc();
    return $result;
}

function login($login, $password){
    global $connect;
    $result = $connect->query("SELECT username, password FROM users WHERE username = '$login' LIMIT 1;");
    $user = $result->fetch_assoc();
    if($result->num_rows == 1){
        if(md5($password) == $user['password']){
            $_SESSION['username'] = $login;
            $_SESSION['messages'][] = "Zalogowano;green";
            return true;
        }
        $_SESSION['messages'][] = "Błąd logowania;red";
        return false;
    }
    else{
        $_SESSION['messages'][] = "Błąd logowania;red";
        return false;
    }
}

function registration($first, $last, $email, $login, $password, $password2){
    global $connect;
    $errors = 0;
    if($password != $password2){
        $_SESSION['messages'][] = "Hasła powinny być takie same;red";
        $errors++;
    }
    if(validate_field($first, $last, $email, $login, $password) == false){
        $_SESSION['messages'][] = "Wypełnij wszystkie pola;red";
        $errors++;
    }
    $result = $connect->query("SELECT username FROM users WHERE username = '$login' LIMIT 1;");
    if($result->num_rows == 1){
        $_SESSION['messages'][] = "Login jest już zajęty;red";
        $errors++;
    }
    $result = $connect->query("SELECT email FROM users WHERE email = '$email' LIMIT 1;");
    if($result->num_rows == 1){
        $_SESSION['messages'][] = "E-mail jest już zajęty;red";
        $errors++;
    }
    if($errors == 0){
        $password = md5($password);
        $connect->query("INSERT INTO users (first_name, last_name, password, username, email) VALUES ('$first', '$last', '$password', '$login', '$email');");
        $_SESSION['messages'][] = "Zarejestrowano nowego użytkownika;green";
    }
    print_r($_SESSION['messages']);
    return $errors == 0;
}

function get_cart(){
    $cart = array();
    if(isset($_SESSION['cart']) && $_SESSION['cart'] > 0){
        for($i = 0; $i < count($_SESSION['cart']); $i++){
            $cart[] = $_SESSION['cart'][$i];
        }
    }
    else{
        return false;
    }
    return $cart;
}

function search($q){
    global $connect;
    return $connect->query("SELECT * FROM products WHERE title LIKE '%".$q."%' OR description LIKE '%".$q."%';");
}

function cart_counter(){
    $sum = 0;
    foreach($_SESSION['cart'] as $item){
        $sum += get_product($item)['price'];
    }
    return $sum;
}
function add_dots($string, $l){
    if(strlen($string) > $l){
        return substr($string, 0, $l)."...";
    }
    return $string;
}
function create_product($title, $price, $description, $img, $seller, $category, $pieces){
    global $connect;
    $errors = array();
    if($price < 0){
        $_SESSION['messages'][] = "Cena musi być większa niż 0;red";
    }
    $img_name = $img['name'];
    while(file_exists("img/products/".$img_name)){
        $img_name = rand(0, 9).$img_name;
    }
    $img_extension = explode(".", $img_name);
    $img_tmp = $img['tmp_name'];
    $img_extension = strtolower(end($img_extension));
    $allowed_extensions = array('jpg', 'gif', 'png', 'jpeg', 'ico', 'jfif', 'webp', 'avif');
    if(!in_array($img_extension, $allowed_extensions)){
        $errors[] = "Złe rozszerzenie pliku";
    }
    $seller = $connect->query("SELECT id FROM USERS WHERE username = '$seller' LIMIT 1");
    if($seller->num_rows == 0){
        $errors[] = "Zaloguj się";
    }
    else{
        $seller = $seller->fetch_assoc()['id'];
    }
    if(count($errors) == 0){
        $connect->query("INSERT INTO products (id_seller, price, title, description, category, pieces) VALUES ('$seller', '$price', '$title', '$description', '$category', '$pieces');");
        $product_id = $connect->query("SELECT id FROM products ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];
        $connect->query('INSERT INTO images (name, product_id) VALUES ("'.$img_name.'", "'.$product_id.'")');
        if(!move_uploaded_file($img_tmp, 'img/products/'.$img_name))
        {
            $errors[] = "Błąd wysyłania obrazu";
        }
        else{
            return "Dodano nowy product";
        }
    }
    return $errors;
}

function edit_product($id, $title, $price, $description, $category, $pieces){
    global $connect;
    return $connect->query("UPDATE products SET title = '$title', price = '$price', description = '$description', category = '$category', pieces = '$pieces' WHERE id='$id'");
}

function is_mine($id){
    global $connect;
    if(empty($_SESSION['username'])){
        return false;
    }
    $me = $connect->query("SELECT id FROM users WHERE username = '".$_SESSION['username']."' LIMIT 1");
    if($me->num_rows == 0){
        return false;
    }
    $me = $me->fetch_assoc()['id'];
    if($id == $me){
        return true;
    }
    return false;
}

function delete_product($id){
    global $connect;
    return $connect->query("DELETE FROM products WHERE id='$id'");
}

function get_user($column, $value){
    global $connect;
    $result = $connect->query("SELECT * FROM users WHERE ".$column."='".$value."' LIMIT 1;")->fetch_assoc();
    if($result){
        return $result;
    }
    else{
        return false;
    }
}

function get_images($product_id){
    global $connect;
    $img = $connect->query("SELECT * FROM images WHERE product_id='".$product_id."'");
    if($img->num_rows == 0){
        $img = array(array("name"=>"default.png"));
    }
    return $img;
}

function add_image($id, $img){
    global $connect;
    $errors = 0;
    $img_name = $img['name'];
    if($img_name == ""){
        $_SESSION['messages'][] = "Wypełnij formularz;red";
        return false;
    }
    while(file_exists("img/products/".$img_name)){
        $img_name = rand(0, 9).$img_name;
    }
    $img_extension = explode(".", $img_name);
    $img_tmp = $img['tmp_name'];
    $img_extension = strtolower(end($img_extension));
    $allowed_extensions = array('jpg', 'gif', 'png', 'jpeg', 'ico', 'jfif', 'webp', 'avif');
    if(!in_array($img_extension, $allowed_extensions)){
        $_SESSION['messages'][] = "Złe rozszerzenie pliku;red";
        $errors++;
    }
    if($errors == 0){
        $connect->query("INSERT INTO images (product_id, name) VALUES ('$id', '$img_name')");
        if(!move_uploaded_file($img_tmp, 'img/products/'.$img_name))
        {
            $_SESSION['messages'][] = "Błąd wysyłania obrazu;red";
        }
        else{
            $_SESSION['messages'][] = "Dodano nowy obraz;green";
        }
        return true;
    }

    return false;
}

function delete_image($id){
    global $connect;
    $result = $connect->query("DELETE FROM images WHERE id='$id'");
    return $result;
}

function go_to($to){
    header("Location: ".$to);
    exit();
}

function get_countries($column=1, $value=1){
    global $connect;
    $countries = $connect->query("SELECT * FROM countries WHERE '$column'='$value' ORDER BY continent DESC, name ASC;");
    return $countries;
}
function add_address($country, $city, $postal_code, $address){
    global $connect;
    $result = $connect->query("INSERT INTO addresses (user_id, country, city, postal_code, address) VALUES ('".get_user("username", $_SESSION['username'])['id']."', '".$country."', '".$city."', '".$postal_code."', '".$address."')");
    if($result){
        $_SESSION['messages'][] = "Dodano adres;green";
    }
    else{
        $_SESSION['messages'][] = "Błąd dodawania;red";
    }
    return $result;
}

function select_by_category($category, $how_meny=100){
    global $connect;
    $products = $connect->query("SELECT products.id, products.price, products.title, products.category, categories.name, categories.lowercase FROM products LEFT JOIN categories ON products.category = categories.id WHERE categories.lowercase = '$category';");
    return $products;
}

function get_categories(){
    global $connect;
    $categories = $connect->query("SELECT * FROM categories");
    return $categories;
}
function get_last_products($how_meny){
    global $connect;
    $products = $connect->query("SELECT * FROM products ORDER BY date LIMIT $how_meny");
    return $products;
}

function update_user($last_name, $first_name, $email){
    global $connect;
    $user_id = get_user('username', $_SESSION['username'])['id'];
    $_SESSION['messages'][] = "Zmieniono dane;green";
    return $connect->query("UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE id='$user_id'");

}
function change_password($p1, $p2, $p3){
    global $connect;
    $user = get_user('username', $_SESSION['username']);
    $user_id = $user['id'];
    if($p2 != $p3){
        $_SESSION['messages'][] = "Hasła powinny być takie same;red";
    }
    if(md5($p1) != $user['password']){
        $_SESSION['messages'][] = "Błędne hasło;red";
    }
    if(sizeof($_SESSION['messages'])){
        $_SESSION['messages'][] = "Zmieniono hasło;green";   
        return $connect->query("UPDATE users SET password='".md5($p2)."' WHERE id='$user_id'");
    }
}
function get_my_id(){
    return get_user('username', $_SESSION['username'])['id'];
}
function get_my_orders(){
    global $connect;
    $orders = $connect->query("SELECT * FROM orders WHERE user_id = '".get_my_id()."'");
    return $orders;
}
function get_my_addresses(){
    global $connect;
    $address = $connect->query("SELECT * FROM addresses WHERE user_id = '".get_user('username', $_SESSION['username'])['id']."'");
    return $address;
}
function delete_address($id){
    global $connect;
    if($connect->query("SELECT user_id FROM addresses WHERE id='$id' LIMIT 1")->fetch_assoc()['user_id'] == get_user('username', $_SESSION['username'])['id']){
        return $connect->query("DELETE FROM addresses WHERE id='$id'");
    }
    return false;
}

function buy($id, $pieces, $address){
    global $connect;
    $product = $connect->query("SELECT * FROM products WHERE id='".$id."' LIMIT 1")->fetch_assoc();
    $how_meny_pieces = intval($product['pieces']);
    $bought_pieces = intval($product['bought_pieces']);
    if($pieces > $how_meny_pieces){
        $_SESSION['messages'][] = "Ilość sztuk jest za duża;red";
    }
    else{
        if($connect->query("INSERT INTO orders(user_id, product_id, pieces, address, status) VALUES ('".get_my_id()."', '$id', '$pieces', '$address', 'oczekiwanie')")){
            $_SESSION['messages'][] = "Kupiłeś produkt;green";
            $connect->query("UPDATE products SET pieces='".($how_meny_pieces-$pieces)."', bought_pieces='".($bought_pieces+intval($pieces))."' WHERE id='$id'");
            
        }
    }
    $cart = get_cart();
    if($cart){
        $new_cart = array();
        $removed = false;
        foreach($cart as $item){
            if($id != $item && !$removed){
                $new_cart[] = $item;
            }
            else{
                $removed = !$removed;
            }
        }
        $_SESSION['cart'] = $new_cart;
       
    }

}

function select_top_products($date1="0001-01-01 00:00:00", $date2="9999-12-31 23:59:59"){
    global $connect;
    $query = "SELECT products.*, COUNT(orders.id) as num FROM orders INNER JOIN products ON orders.product_id = products.id WHERE orders.date >= '$date1' && orders.date <= '$date2' GROUP BY orders.product_id ORDER BY num DESC";
    $result = $connect->query($query); 
    
    return $result;
}