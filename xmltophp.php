<?php
/*
function getXmltoJSON($url){
$i = 0;
$rss = simplexml_load_file($url);
foreach ($rss->channel->item as $item) {
    $link = $item->link;
    $title = $item->title;
    $date = $item->pubDate;
    echo '<div class="cuadros1"><h4>
    <a href="'.$link.'" target="_blank">'.$title.'</a></h4>
    <br><br><br><div class="time">'.$date.'</div></div>';
    $i++;
    if ($i > 5) {
        exit;
    
    }

}


}

 // $res = getXmltoJSON("https://e00-marca.uecdn.es/rss/futbol/primera-division.xml"); 

 $res = getXmltoJSON("https://www.thesportsdb.com/api/v1/json/3/search_all_seasons.php?id=4370");
 //$res = getXmltoJSON("https://www.thesportsdb.com/league/4370-Formula-134157147");

 https://www.thesportsdb.com/api/v1/json/{APIKEY}/searchplayers.php?t={135126}&p={34157142}

 */
/*
echo "<label for='buscador'>Lista de equipos de la Formula 1</label>";
echo "<select id='buscador' name='buscador'>";
$url = "https://www.thesportsdb.com/api/v1/json/3/lookupplayer.php?id=34157142";

// Hacer la solicitud HTTP y obtener la respuesta
$response = file_get_contents($url);

// Decodificar la respuesta JSON
$res = json_decode($response, true);

// Verificar si la decodificación fue exitosa
if ($res !== null) {
    // Iterar sobre los elementos en el array decodificado
    foreach ($res["players"] as $elemento) {
        echo $elemento["idPlayer"];
        echo $elemento["strPlayer"];
        echo $elemento["strTeam"];
        echo "<br/>"; // Solo para salto de línea
    }
} else {
    echo "Error al decodificar la respuesta JSON.";
}
function crearTablaDatosFormula1(){
    $url = "https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201";
    $response = file_get_contents($url);
    $res = json_decode($response, true);
    echo "<table>";

    echo "</table>";
}
function mostrarEquiposFormula1(){
    $url = "https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201";
    $response = file_get_contents($url);
    $res = json_decode($response, true);
    if ($res !== null) {
        echo "<label for='escuderia'>Lista de equipos de la Formula 1</label>";
        echo "<select name='escuderia' id='escuderia'>";
        // Iterar sobre los elementos en el array decodificado
        foreach ($res["teams"] as $elemento) {
            $nameTeam = $elemento["strTeam"];
            echo "<option value = '$nameTeam'>$nameTeam</option>";
            echo "<br/>"; // Solo para salto de línea
        }
    } else {
        echo "Error al decodificar la respuesta JSON.";
    }
}

$res = mostrarEquiposFormula1();

echo "</select>";
echo "<button type='submit'>Enviar</button>";


?>
*/
function obtenerJugadoresEquipo($equipoId) {
    $url = "https://www.thesportsdb.com/api/v1/json/1/lookup_all_players.php?id=" . urlencode($equipoId);
    $response = file_get_contents($url);
    $res = json_decode($response, true);

    if ($res !== null && isset($res["player"])) {
        return $res["player"];
    } else {
        return null;
    }
}

function mostrarEscuderias() {
    $url = "https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201";
    $response = file_get_contents($url);
    $res = json_decode($response, true);

    if ($res !== null) {
        echo "<form method='post' action=''>";
        echo "<label for='escuderia'>Lista de equipos de la Formula 1</label>";
        echo "<select name='escuderia' id='escuderia'>";
        // Iterar sobre los elementos en el array decodificado
        foreach ($res["teams"] as $elemento) {
            $nameTeam = $elemento["strTeam"];
            echo "<option value='$nameTeam'>$nameTeam</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Enviar</button>";
        echo "</form>";
}
}
/*
if (isset($_POST["escuderia"])) {
    $equipoSeleccionado = $_POST["escuderia"];
    $equipoId = obtenerIdEquipo($equipoSeleccionado);
    $pilotos = obtenerPilotos($equipoId);
    if ($jugadores !== null) {
        echo "<h2>Jugadores de $equipoSeleccionado</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre del Jugador</th><th>Equipo</th></tr>";

        foreach ($jugadores as $jugador) {
            echo "<tr>";
            echo "<td>{$jugador['idPlayer']}</td>";
            echo "<td>{$jugador['strPlayer']}</td>";
            echo "<td>{$jugador['strTeam']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Error al obtener la información de los jugadores.";
    }
}
}
*/


function  obtenerIdEquipo($equipoSeleccionado) {
    $url = "https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201";
    // https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201
    $response = file_get_contents($url);
    $res = json_decode($response, true);
    foreach ($res["teams"] as  $elemento) {
        if ($equipoSeleccionado == $elemento["strTeam"]) {
            $escuderiaId = $elemento["idTeam"];
            return $escuderiaId;
        }
    }
}




function obtenerPilotos($idEscuderia) {
    $url = "https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201";

    $arrayPilotos = array("135126" => 34157142,
    "134806" => 34157147, 
    "134812" => 34157136);
    // https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Formula%201
    $response = file_get_contents($url);
    $res = json_decode($response, true);
    foreach ($res["teams"] as $elemento) {
        if ($idEscuderia == $elemento["idTeam"]) {
            $pilotos = $arrayPilotos[$idEscuderia];
        }
    }
}

$res = mostrarEscuderias();


if (isset($_POST["escuderia"])) {
    $equipoSeleccionado = $_POST["escuderia"];
    $equipoId = obtenerIdEquipo($equipoSeleccionado);
    $pilotos = obtenerPilotos($equipoId);
    if ($jugadores !== null) {
        echo "<h2>Jugadores de $equipoSeleccionado</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre del Jugador</th><th>Equipo</th></tr>";

        foreach ($jugadores as $jugador) {
            echo "<tr>";
            echo "<td>{$jugador['idPlayer']}</td>";
            echo "<td>{$jugador['strPlayer']}</td>";
            echo "<td>{$jugador['strTeam']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Error al obtener la información de los jugadores.";
    }
}
/*
function obtenerIdEquipo($nombreEquipo) {
    // Implementa esta función para obtener el ID del equipo utilizando el nombre del equipo.
    // Puedes hacer otra solicitud a la API para obtener detalles específicos del equipo seleccionado.
    return ""; // Aquí deberías retornar el ID del equipo.
}

*/
?>


