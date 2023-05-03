<?php



$dsn = 'mysql:dbname=pokemon;host=127.0.0.1:8889';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);

$types_url = "https://pokebuildapi.fr/api/v1/types";

$json = json_decode(file_get_contents($types_url), true);
// var_dump($json);
$sql = "DELETE FROM `pokemon`; ALTER TABLE `pokemon` AUTO_INCREMENT = 1;";
$dbh->exec($sql);
$sql = "DELETE FROM `type`; ALTER TABLE `type` AUTO_INCREMENT = 1;";
$dbh->exec($sql);

$type_list = [];
foreach($json as $type) {
    // var_dump($type);
    $sql = "INSERT INTO `type` (`id`, `name`, `created_at`) VALUES (:id, :name, NULL);";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':id', $type['id']);
    $statement->bindParam(':name', $type['name']);
    $result = $statement->execute();
    // var_dump(file_get_contents($type['url']));
    $type_list[$type['name']] = $type['id'];
}

$pokemons_url = "https://pokebuildapi.fr/api/v1/pokemon/limit/151";
$json = json_decode(file_get_contents($pokemons_url), true);

foreach($json as $pokemon) {
    $sql = "INSERT INTO `pokemon` (`id`, `name`, `image`, `number`, `type1`, `type2`, `description`, `height`, `weight`, `hp`, `atk`, `def`, `atkspe`, `defspe`, `created_at`) VALUES (NULL, :name, :image, :number, :type1, :type2, NULL, :height, :weight, :hp, :atk, :def, :atkspe, :defspe, NULL);";
    // $sql = "INSERT INTO `type` (`id`, `name`, `created_at`) VALUES (:id, :name, NULL);";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':name', $pokemon['name']);
    $statement->bindParam(':number', $pokemon['pokedexId']);
    $statement->bindParam(':image', $pokemon['image']);
    $statement->bindValue(':type1', $type_list[$pokemon['apiTypes'][0]['name']]);
    $statement->bindValue(':type2', $type_list[$pokemon['apiTypes'][1]['name']] ?? null);
    $statement->bindValue(':height', rand(1,100));
    $statement->bindValue(':weight', rand(1,100));
    $statement->bindParam(':hp', $pokemon['stats']['HP']);
    $statement->bindParam(':atk', $pokemon['stats']['attack']);
    $statement->bindParam(':def', $pokemon['stats']['defense']);
    $statement->bindParam(':atkspe', $pokemon['stats']['special_attack']);
    $statement->bindParam(':defspe', $pokemon['stats']['special_defense']);
    $result = $statement->execute();
    // var_dump(file_get_contents($type['url']));
}