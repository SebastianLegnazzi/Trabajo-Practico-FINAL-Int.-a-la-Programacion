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
 * @return int $seleccionarOpcion
 */
function menu()
{
    // int $seleccionarOpcion
    echo "MENU DE OPCIONES"."\n";
    echo "1) Jugar al tateti"."\n";
    echo "2) Mostrar un juego"."\n";
    echo "3) Mostrar el primer juego ganado del jugador"."\n";
    echo "4) Mostrar porcentaje de juegos ganados"."\n";
    echo "5) Mostrar resumen del jugador"."\n";
    echo "6) Mostrar listado de juegos ordenado por el jugador O"."\n";
    echo "7) Salir"."\n";
    $seleccionarOpcion = trim(fgets(STDIN));
    return $seleccionarOpcion;
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
function primerVictoriaJugador($partidasGuardadas){
//int $i, $dimension
    //string $nombre
    $i=0;
    $dimension = count($partidasGuardadas);
    echo "Ingrese el nombre del jugador: ";
    $nombre = trim(fgets(STDIN));
    while ($nombre <> $partidasGuardadas[$i]["jugadorCruz"] || $nombre <> $partidasGuardadas[$i]["jugadorCirculo"] && $dimension > $i ) {
        if ($nombre == $partidasGuardadas[$i]["jugadorCruz"]){
            $puntos = $partidasGuardadas [$i]["puntosCruz"];
            if ($puntos < 2){
                $i = $i+1;
                if ($dimension == $i){
                    break;
                }
            } else {
                estadisticasPartida($partidasGuardadas, $i+1);
                break;
            }
        } elseif ($nombre == $partidasGuardadas[$i]["jugadorCirculo"]){
            $puntos = $partidasGuardadas [$i]["puntosCirculo"];
            if ($puntos < 2){
                $i = $i+1;
                if ($dimension == $i){
                    break;
                } 
            } else {
                estadisticasPartida($partidasGuardadas, $i+1);
                break;
            }
        } else {
            $i= $i+1;
        }
    }
    if ($puntos < 2){
        echo "\n"."El jugador ". $nombre. " no ganó ningun juego"."\n"."\n";}
}
    
/*function primerVictoriaJugador($arrayTateti){
    //int $i, $dimension
    //string $nombre
    $i=0;
    $dimension = count($arrayTateti);
    echo "Ingrese el nombre del jugador: ";
    $nombre = trim(fgets(STDIN));
    do {
        $result = resultadoJuego($arrayTateti, ($i+1));
        if ($nombre <> $arrayTateti[$i]["jugadorCruz"] || $nombre <> $arrayTateti[$i]["jugadorCirculo"] && $dimension < $i ){
            $i= $i+1; 
        }
    }while ($result <> "Ganó: " . CIRCULO || $result <> "Ganó: " . CRUZ);
    if ($nombre == $arrayTateti[$i]["jugadorCruz"] || $nombre == $arrayTateti[$i]["jugadorCirculo"]){   
        estadisticasPartida ($arrayTateti, $i);
    } else {
        echo "El jugador ". $nombre. " no ganó ningun juego"."\n"."\n";
    }
} */

       

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/
// Abre un menu de opciones para que el usuario pueda elegir
//Declaración de variables:
/*
* array $datosJuego
* int $seleccionarOpcion
* 
*/

//Inicialización de variables:
$datosJuego = [];
//Proceso:
$datosJuego = cargarJuego($datosJuego);
$seleccionarOpcion = menu();
do {
switch ($seleccionarOpcion) {
    
    case 1: 
        $i = count($datosJuego);
        $datosJuego[$i] = jugar();
        imprimirResultado($datosJuego[$i]);
        $seleccionarOpcion = menu();
        break;


    case 2: 
        mostrarJuego($datosJuego);
        $seleccionarOpcion = menu();
        break;


    case 3: 
        primerVictoriaJugador($datosJuego);
        $seleccionarOpcion = menu();
        break;

        
    case 4: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
       
        
    case 5: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
        

    case 6: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
        

    default: 
        echo "El numero que ingreso no es valido, por favor ingrese un numero del 1 al 7"."\n"."\n";
        $seleccionarOpcion = menu();
    break;
    }
} while ($seleccionarOpcion < 7);
exit();

//print_r($juego);
//imprimirResultado($juego);