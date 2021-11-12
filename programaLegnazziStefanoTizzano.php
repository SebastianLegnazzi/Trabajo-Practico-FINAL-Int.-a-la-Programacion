<?php

include_once("tateti.php");


/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/


/* LEGNAZZI. SEBASTIAN. FAI-3152. TUDW. sebastian.legnazzi@est.fi.uncoma.edu.ar. SebastianLegnazzi */
/* STEFANO. FRANCO. FAI-2750. TUDW. franco.stefano@est.fi.uncoma.edu.ar. francoDanteStefano */
/* TIZZANO. AGOSTINA. FAI-3579. TUDW. agostina.tizzano@est.fi.uncoma.edu.ar. agostita */


/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/


/**
 * Esta función carga ejemplos de juegos 
 * @return array $partidasCargadas
 */
function cargarJuego($partidasCargadas)
{
    $partidasCargadas[0] = [
        "jugadorCruz" => "Jose",
        "jugadorCirculo" => "Enrike",
        "puntosCruz" => 4,
        "puntosCirculo" => 0
    ];
    $partidasCargadas[1] = [
        "jugadorCruz" => "Fran",
        "jugadorCirculo" => "Seba",
        "puntosCruz" => 6,
        "puntosCirculo" => 0
    ];
    $partidasCargadas[2] = [
        "jugadorCruz" => "Tita",
        "jugadorCirculo" => "Jose",
        "puntosCruz" => 1,
        "puntosCirculo" => 1
    ];
    $partidasCargadas[3] = [
        "jugadorCruz" => "Andrea",
        "jugadorCirculo" => "Roberto",
        "puntosCruz" => 0,
        "puntosCirculo" => 2
    ];
    $partidasCargadas[4] = [
        "jugadorCruz" => "Jose",
        "jugadorCirculo" => "Seba",
        "puntosCruz" => 0,
        "puntosCirculo" => 5
    ];
    $partidasCargadas[5] = [
        "jugadorCruz" => "Fran",
        "jugadorCirculo" => "Enrike",
        "puntosCruz" => 1,
        "puntosCirculo" => 1
    ];
    $partidasCargadas[6] = [
        "jugadorCruz" => "Tita",
        "jugadorCirculo" => "Roberto",
        "puntosCruz" => 0,
        "puntosCirculo" => 6
    ];
    $partidasCargadas[7] = [
        "jugadorCruz" => "Seba",
        "jugadorCirculo" => "Enrike",
        "puntosCruz" => 0,
        "puntosCirculo" => 2
    ];
    $partidasCargadas[8] = [
        "jugadorCruz" => "Fran",
        "jugadorCirculo" => "Jose",
        "puntosCruz" => 0,
        "puntosCirculo" => 2
    ];
    $partidasCargadas[9] = [
        "jugadorCruz" => "Andrea",
        "jugadorCirculo" => "Tita",
        "puntosCruz" => 0,
        "puntosCirculo" => 4
    ];
    return $partidasCargadas;
}


/**
 * Este módulo muestra por pantalla el menú y retorna la opción elegida por el usuario
 * @return int $menu
 */
function seleccionarOpcion()
{
    // int $menu
    echo "MENU DE OPCIONES"."\n";
    echo "1) Jugar al tateti"."\n";
    echo "2) Mostrar un juego"."\n";
    echo "3) Mostrar el primer juego ganado del jugador"."\n";
    echo "4) Mostrar porcentaje de juegos ganados"."\n";
    echo "5) Mostrar resumen del jugador"."\n";
    echo "6) Mostrar listado de juegos ordenado por el jugador O"."\n";
    echo "7) Salir"."\n";
    $menu = trim(fgets(STDIN));
    return $menu;
}

/**
 * @param array $arrayPartida
 * @param int $numPartida
 */
function resultadoJuego($arrayPartida, $numeroPartida)
{
    $numeroPartida = $numeroPartida - 1; 
    if ($arrayPartida[$numeroPartida]["puntosCruz"] < $arrayPartida[$numeroPartida]["puntosCirculo"]){
        $resultado = "Ganó: " . CIRCULO;
    } elseif ($arrayPartida[$numeroPartida]["puntosCruz"] > $arrayPartida[$numeroPartida]["puntosCirculo"]){
        $resultado = "Ganó: " . CRUZ;
    } else {
        $resultado = "Empate";
    }
return $resultado;
}
     

/** 
 * Función que muestra las estadísticas de cada juego
 * @param array $partida 
 * @param int $numPartida
 */
function estadisticasPartida($partida, $numPartida)
{
    // string $ganador, $separador
    $resultado = resultadoJuego($partida, $numPartida);
    $separador = "**************************************";
    $numPartida = $numPartida -1; 
    echo "\n".$separador."\n";
    echo "Juego TATETI: ".($numPartida+1)."($resultado)"."\n";
    echo "Jugador X: ".$partida[$numPartida]["jugadorCruz"]." obtuvo ".$partida[$numPartida]["puntosCruz"]." puntos"."\n";
    echo "Jugador O: ".$partida[$numPartida]["jugadorCirculo"]." obtuvo ".$partida[$numPartida]["puntosCirculo"]." puntos"."\n";
    echo $separador."\n"."\n"; 
}


/**
 * Este módulo solicita un numero y muestra por pantalla los datos del juego
 * @param array $datos
 */
function mostrarJuego($datos)
{
    // int $numJuego, $max, $min, $numJuego
    $max = count($datos);
    $min = 1;
    echo "Ingrese el numero del juego que desesa visualizar: ";
    $numJuego = solicitarNumeroEntre($min, $max);
    estadisticasPartida ($datos, $numJuego);
}


/**
 * Este módulo muestra la primer victoria del jugador que lo solicita. Si no tiene muestra que no ganó
 * @param array $partidasGuardadas
 */
function primerVictoriaJugador($partidasGuardadas)
{
//int $i, $dimension
    //string $nombre
    $i=0;
    $jugadorEncontrado = false;
    $dimension = count($partidasGuardadas);
    echo "Ingrese el nombre del jugador: ";
    $nombre = strtoupper(trim(fgets(STDIN)));
    while (!$jugadorEncontrado && $dimension > $i ) {
      if ($nombre == strtoupper($partidasGuardadas[$i]["jugadorCruz"]) && $partidasGuardadas[$i]["puntosCruz"] > 1){
        $jugadorEncontrado = true;
      }else if($nombre == strtoupper($partidasGuardadas[$i]["jugadorCirculo"]) && $partidasGuardadas[$i]["puntosCirculo"] > 1){
        $jugadorEncontrado = true;
      }
      $i = $i + 1;
    }
    if($jugadorEncontrado) {
    estadisticasPartida ($partidasGuardadas, $i);
    }else{
        echo "\n"."El jugador ". $nombre. " no ganó ningun juego"."\n"."\n";
    }
}

/**
 * Toma el array de juegos y le agrega los nuevos juegos
 * @param array $coleccionJuegos
 * @param array $nuevoJuego
 * @return array $coleccionJuegos
 */
function agregarJuego ($coleccionJuegos, $nuevoJuego)
{
    // int $dimension
    $dimension = count($coleccionJuegos);
    $coleccionJuegos[$dimension]=$nuevoJuego;
    return $coleccionJuegos;
}


function ganadosSimboloElegido($datosJuego)
{

}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/


//Inicialización de variables:
$partidasActualizadas = [];
$partidaNueva = [];
$datosJuego = [];
//Proceso:
$datosJuego = cargarJuego($datosJuego);
$menu = seleccionarOpcion();
do {
switch ($menu) {
    
    case 1: 
        $partidaNueva = jugar();
        imprimirResultado($partidaNueva);
        $partidasActualizadas = agregarJuego($datosJuego, $partidaNueva);
        $menu = seleccionarOpcion();
        break;


    case 2: 
        mostrarJuego($partidasActualizadas);
        $menu = seleccionarOpcion();
        break;


    case 3: 
        primerVictoriaJugador($partidasActualizadas);
        $menu = seleccionarOpcion();
        break;

        
    case 4: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        ganadosSimboloElegido($partidasActualizadas);
        $menu = seleccionarOpcion();
        break;
       
        
    case 5: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
        

    case 6: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
        

    default: 
        echo "El numero que ingreso no es valido, por favor ingrese un numero del 1 al 7"."\n"."\n";
        $menu = seleccionarOpcion();
    break;
    }
} while ($menu < 7);
exit();

//print_r($juego);
//imprimirResultado($juego);