<?php
$pokemonNumber = $_GET['id'];   


$dsn = 'mysql:dbname=pokemon;host=127.0.0.1:8889';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);

$sql = "SELECT
    `pokemon`.`number`,
    `pokemon`.`weight`,
    `pokemon`.`height`,
    `pokemon`.`image`,
    `pokemon`.`name`,
    `t1`.`name` AS `type1`,
    `t2`.`name` AS `type2`
    FROM `pokemon`
    INNER JOIN `type` as `t1` ON `pokemon`.`type1` = `t1`.`id`
    LEFT JOIN `type` as `t2` ON `pokemon`.`type2` = `t2`.`id`
    WHERE `number` = :number
";
$statement = $dbh->prepare($sql);
$statement->bindParam(':number', $pokemonNumber);
$statement->execute();
$result = $statement->fetch();
?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokedex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
</head>
<body class="bg-dark text-light">
    <nav class="navbar fixed-top navbar-dark type-grass px-3">
        <a class="navbar-brand" href="#">Pokedex</a>
    </nav>
    <main>
        <section class="col-12 shadow card type-grass with-padding-top rounded-container">
            <div class="pokemon card type-grass border-0 text-light col-8 col-sm-6 col-md-4 mx-auto">
                <img src= <?= $result['image'] ?> class="card-img-top p-3">
                <div class="card-body px-0">
                </div>
            </div>
        </section>
        <section class="pt-3">
            <h1 class="text-center">
                #<?= $result['number'] ?> <?=$result['name']?> 
            </h1>
            <div class="d-flex justify-content-center mb-4">
                <span class="badge rounded-pill type-grass mx-1"><?=$result['type1']?> </span>
                <span class="badge rounded-pill type-grass mx-1"><?=$result['type2']?></span>
            </div>
            <div class="d-flex justify-content-center mb-2">
                <div class="d-flex flex-column px-2 text-center">
                    <span class="h3"><?=$result['weight']?></span>
                    <span>Weight</span>
                </div>
                <div class="d-flex flex-column px-2 text-center">
                    <span class="h3"><?=$result['height']?></span>
                    <span>Height</span>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>