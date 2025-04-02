<?php


function getPokemonData()
{
    // 1) genera número aleatorio
    $randID = rand(1,151);
    // 2) lee el contenido de la api 
    $apicontenttojson= file_get_contents("https://pokeapi.co/api/v2/pokemon/$randID");
    // 3) lo decodifica
    $arrayapicontent= json_decode($apicontenttojson,true);
    // 4) Creo un objeto pokemon (me quedo sólo con los datos que necesito):
    // nombre (name)
    // imagen (sprites[front_default])
    // tipos (types[]-> dentro de cada elemento [type][name])
    $pokemonData = [
        'name' => $arrayapicontent['name'],
        'id' => $arrayapicontent['game_indices']["id"], 
        'image' => $arrayapicontent['sprites']['front_default'],
        'types' => array_map(function($type) {return $type['type']['name'];},
        $arrayapicontent['types']),
        'abilities'=> //seguir aqui
    ];
    return $pokemonData;
}

$pokemon = getPokemonData();


function renderCards($pokeArray)
{
    // recibe datos y genera el html
    echo "<div class='carta'>";
        echo "<div class='img-container'>";
            echo "<img src='" . $pokeArray['image'] . "' alt='" . $pokeArray['name'] . "'>";
        echo "</div>";
        echo "<div class='datos'>";
            echo "<h3>" . $pokeArray['name'] . "</h3>";
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

    <section id="pokecartas">
        <div class="carta">
            <div class="img-container">
                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png" alt="pikachu">
            </div>
            <div class="datos">
                <h3>Pikachu</h3>
                <div class="tipos-pokemon">
                    <span>eléctrico</span>
                    <span>otro más</span>
                </div>
                <ul class="habilidades">
                    <li>impactrueno</li>
                    <li>chispitas</li>
                </ul>
            </div>
        </div>

    </section>
    <?php renderCards($pokemon) ?>
</body>

</html>