<?php

function mostrarJugadoresEquipo($equipoSeleccionado) {
    $url = "https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201";
    $response = file_get_contents($url);
    $res = json_decode($response, true);

    if ($res !== null) {
        echo "<form method='post' action='procesarEquipos.php'>";
        echo "<label for='escuderia'>Lista de equipos de la Formula 1</label>";
        echo "<select name='escuderia' id='escuderia'>";
        // Iterar sobre los elementos en el array decodificado
        foreach ($res["teams"] as $elemento) {
            $nameTeam = $elemento["strTeam"];
            echo "<option value='$nameTeam'>$nameTeam</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Buscar</button>";
        echo "</form>";

    } else {
        echo "Error al decodificar la respuesta JSON.";
    }
}

if (isset($_POST["escuderia"])) {
    $escuerdia = $_POST["escuderia"];
} else {
    header("Location: xmltophp.php");
}

?>