<?php



$dsn = 'mysql:dbname=pokemon;host=127.0.0.1:8889';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);

$sql = "SELECT * FROM `pokemon`";
$statement = $dbh->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();

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
<body class="bg-dark text-light with-padding-top">
    <nav class="navbar fixed-top navbar-dark bg-danger px-3">
        <a class="navbar-brand" href="#">Pokedex</a>
    </nav>
    <main class="container d-flex flex-wrap">
        <?php foreach($result as $pokemon): ?>
            <article class="col-6 col-md-4 col-lg-3 p-1 pokemon">
                <div class="card shadow type-grass text-light">
                    <img src="<?= $pokemon['image'] ?>" class="card-img-top p-3">
                    <div class="card-body px-0">
                        <h2 class="card-title h6 text-center m-0">
                            <a href="detail.php?id=<?=$pokemon ['number']?>" class="link-light text-decoration-none stretched-link"><?= $pokemon['number'] ?> <?= $pokemon['name'] ?></a>    
                        </h2>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>