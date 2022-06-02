<?php
require_once("main.php");
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if(isset($_GET['d1']) && isset($_GET['d2']) && $_GET['d1'] != "" && $_GET['d2'] != ""){
    $products = select_top_products($_GET['d1']." 00:00:00", $_GET['d2']." 23:59:59");
}
else{
    $products = select_top_products();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js'></script>
    <script src="js/main.js"></script>
    <?php require_once("head.php"); ?>
    <title>Nowości</title>
</head>

<body>
    <?php
    require_once("layout/nav.php");
    ?>
    <section>
        <article>
            <form action="" method="GET">
                Od: <input min="0001-01-01" max="9999-12-31" type="date" name="d1" value="<?php if(isset($_GET['d1'])){echo $_GET['d1']; } ?>">
                Do: <input min="0001-01-01" max="9999-12-31" type="date" name="d2" value="<?php if(isset($_GET['d2'])){echo $_GET['d2']; } ?>">
                <button type="submit">Szukaj</button>
                <br><br>
                <a href="statistics.php">Wyczyść</a>
            </form>
            
            <script>
                <?php
                
                echo 'const products = {';
                $i = 0;
                while ($product = $products->fetch_assoc()) {
                    $i++;
                    echo $i . ': {"id":"'.$product['id'].'", "title": "' . $product['title'] . '", "num": "' . $product['num'] . '"},';
                }
                echo '}';
                ?>
                
            </script>
            <canvas id="graph">

            </canvas>
            
            <script>
                const myChart = document.getElementById('graph');
                const ctx = document.getElementById('graph').getContext("2d");
                const values = [];
                const titles = [];
                const ids = [];
                const myDatapoints = [];
                for(let i = 0; i < 5; i++) {
                    if (typeof products[i+1] !== "undefined") {
                        values.push(products[i+1]['num']);
                        titles.push(products[i+1]['title']);
                        ids.push(products[i+1]['id']);
                        myDatapoints.push({label: products[i+1]['title'], x:products[i+1]['num'], link:"product.php?id"+products[i+1]['id']});
                    }
                }
                const data = {
                    labels: titles,
                    datasets: [{
                        label: 'Ilość kupionych sztuk',
                        data: values,
                        backgroundColor: [
                            'rgba(123, 93, 248, 0.6)',
                        ],
                        borderColor: [
                            'rgb(123, 93, 248)',
                        ],
                        borderWidth: 5,
                        borderRadius: 10,
                        hoverOffset: 4
                    }],
                    dataPoints: myDatapoints
                };
                const myGraph = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                       
                    }
                })
            </script>
        </article>
    </section>
    <?php
    require_once("layout/footer.php");
    require_once("messages.php");
    ?>
</body>

</html>