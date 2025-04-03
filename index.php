<?php

function getPokemonData($randID)
{
    $apicontentfromjson = file_get_contents("https://pokeapi.co/api/v2/pokemon/$randID");
    $arrayapicontent = json_decode($apicontentfromjson, true);
    $pokemonData = [
        'name' => $arrayapicontent['name'],
        'id' => $arrayapicontent['id'],
        'image' => $arrayapicontent['sprites']['front_default'],
        'types' => array_map(function ($type) {
            return $type['type']['name'];
        }, $arrayapicontent['types']),
        'abilities' => array_map(function ($ability) {
            return $ability['ability']['name'];
        }, $arrayapicontent['abilities'])
    ];
    return $pokemonData;
}

function renderCards() {
    $randID = [rand(1, 151), rand(1, 151), rand(1, 151), rand(1, 151)];
    echo "<div class='caja'>";
    foreach ($randID as $id) {
        $pokeArray = getPokemonData($id);
        echo "<div class='carta'>";
        echo "<div class='img-container'>";
        echo "<img src='" . $pokeArray['image'] . "' alt='" . $pokeArray['name'] . "'>";
        echo "</div>";
        echo "<div class='datos'>";
        echo "<h3>" . $pokeArray['name'] . "</h3>";
        echo "<h4>ID Pokemon " . $pokeArray['id'] . "</h4>";
        echo "<div class='tipos-pokemon'>";
        foreach ($pokeArray['types'] as $type) {
            echo "<span>" . $type . "</span>";
        }
        echo "</div>";
        echo "<ul class='habilidades'>";
        foreach ($pokeArray['abilities'] as $ability) {
            echo "<li>" . $ability . "</li>";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeWeb</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>PokeCartas</h1>
    <?php renderCards(); ?>
</body>

</html>
