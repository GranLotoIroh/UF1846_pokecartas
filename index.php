<?php

function getPokemonData($randID)
{
    $randshiny=rand(1,20);
    $randshiny2=rand(1,20);
   /*  $randshiny=5;
    $randshiny2=5; */
    if($randshiny == $randshiny2){
            $apicontentfromjson = file_get_contents("https://pokeapi.co/api/v2/pokemon/$randID");
            $arrayapicontent = json_decode($apicontentfromjson, true);
            $pokemonData = [
            'name' => ucwords($arrayapicontent['name']),
            'id' => $arrayapicontent['id'],
            'image' => $arrayapicontent['sprites']['front_shiny'],
            'types' => array_map(function ($type) {
                return ucwords($type['type']['name']);
            }, $arrayapicontent['types']),
            'abilities' => array_map(function ($ability) {
                return ucwords($ability['ability']['name']);
            }, $arrayapicontent['abilities']),
            'esshiny' => true
        ];
        }else{
        $apicontentfromjson = file_get_contents("https://pokeapi.co/api/v2/pokemon/$randID");
        $arrayapicontent = json_decode($apicontentfromjson, true);
        $pokemonData = [
            'name' => ucwords($arrayapicontent['name']),
            'id' => $arrayapicontent['id'],
            'image' => $arrayapicontent['sprites']['front_default'],
            'types' => array_map(function ($type) {
                return ucwords($type['type']['name']);
            }, $arrayapicontent['types']),
            'abilities' => array_map(function ($ability) {
                return ucwords($ability['ability']['name']);
            }, $arrayapicontent['abilities']),
            'esshiny' => false  
        ];
    }
    return $pokemonData;
}

function renderCards() {
    $randID = [rand(1, 151), rand(1, 151), rand(1, 151), rand(1, 151)];
    echo "<div class='caja'>";
    foreach ($randID as $id) {
        $pokeArray = getPokemonData($id);
        $bordershiny = $pokeArray["esshiny"] ? "esshiny" : "";
        $types = $pokeArray['types'];
        $typeClass = strtolower($types[0]);
        echo "<div class='carta $bordershiny $typeClass' >";
        echo "<div class='img-container'>";
        echo "<img src='" . $pokeArray['image'] . "' alt='" . $pokeArray['name'] . "'>";
        echo "</div>";
        echo "<div class='datos'>";
        echo "<h3>" . $pokeArray['name'] . "</h3>";
        echo "<h4>Pokedex Nº: " . $pokeArray['id'] . "</h4>";
        echo "<div class='tipos-pokemon'>";
        foreach ($pokeArray['types'] as $type) {
            echo "<span class='$type'>" . ucwords($type) . "</span>";
        }
        echo "</div>";
        echo "<ul class='habilidades'>";
        foreach ($pokeArray['abilities'] as $ability) {
            echo "<li>" . $ability . "</li>";
        }
        echo "</ul>";
        if ($pokeArray["esshiny"]) {
            echo "<div class='shinyimg'>";
            echo "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/Shiny_hex_logo.svg/512px-Shiny_hex_logo.svg.png' alt='Shiny'>";
            echo "</div>";
        }
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
    <link href="https://fonts.googleapis.com/css2?family=Pokemon+Solid&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>POKECARTAS</h1>
    <?php renderCards(); ?>
    <div class="boton">
    <a href="index.php" class="botongenerar">Generar nuevos pokemon</a>
    </div>
</body>

</html>
