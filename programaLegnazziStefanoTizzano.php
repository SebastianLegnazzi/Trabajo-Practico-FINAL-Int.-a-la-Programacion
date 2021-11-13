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
    $dimension = count($partidasGuardadas);
    echo "Ingrese el nombre del jugador: ";
    $nombre = strtoupper(trim(fgets(STDIN)));
    $ganador = retornaIndiceGanador($nombre, $partidasGuardadas);
    if($ganador > -1) {
    estadisticasPartida ($partidasGuardadas, $ganador);
    }else{
        echo "\n"."El jugador ". strtolower($nombre). " no ganó ningun juego"."\n"."\n";
    }
}

/**
 * Retorna el indice de la primer victoria segun el nombre ingresado
 * @param string $jugador
 * @param array $coleccion
 */
function retornaIndiceGanador($jugador, $coleccion)
{
//int $i, $dimension
    //int $indiceGanador
    $i=0;
    $jugadorEncontrado = false;
    $indiceGanador = -1;
    $dimension = count($coleccion);
    while (!$jugadorEncontrado && $dimension > $i ) {
      if ($jugador == strtoupper($coleccion[$i]["jugadorCruz"]) && $coleccion[$i]["puntosCruz"] > 1){
        $jugadorEncontrado = true;
        $indiceGanador = $i+1;
      }else if($jugador == strtoupper($coleccion[$i]["jugadorCirculo"]) && $coleccion[$i]["puntosCirculo"] > 1){
        $jugadorEncontrado = true;
        $indiceGanador = $i+1;
      }
      $i = $i + 1;
    }
    return $indiceGanador;
}

/**
 * Verifica si el símbolo ingresado es X ó O.
 * @return string $simbolo
 */
function eligeSimbolo()
{
//string $simbolo
echo "Ingrese un símbolo X ó O"."\n";
$simbolo = strtoupper(trim(fgets(STDIN)));
    while ($simbolo <> CRUZ && $simbolo <> CIRCULO){
        echo "El símbolo ".$simbolo. " no está permitido, por favor ingrese X ó O"."\n";
        $simbolo = strtoupper(trim(fgets(STDIN)));
    } 
    return $simbolo;  
}

/**
 * Toma el array de juegos y le agrega los nuevos juegos
 * @param array $coleccionJuegos
 * @param array $nuevoJuego
 * @return array $coleccionJuegos
 */
function agregarJuego($coleccionJuegos, $nuevoJuego)
{
    // int $dimension
    $dimension = count($coleccionJuegos);
    $coleccionJuegos[$dimension]=$nuevoJuego;
    return $coleccionJuegos;
}


/**
 * El jugador elige el símbolo y muestra el porcentaje de juegos ganados
 * @param array $historialJuegos
 */
function ganadoSimboloElegido($historialJuegos)
{
    //int $acumVicTot , $victorias, $datos, float $porcentaje, array $partidaGuard, string $clave, $simboloElegido
    $acumVicTot = 0;
    $simboloElegido = eligeSimbolo ();
    foreach ($historialJuegos as $partidaGuard){
        foreach ($partidaGuard as $clave => $datos){
            if (("puntosCruz" == $clave || "puntosCirculo" == $clave)&&($datos > 1)){
                $acumVicTot = $acumVicTot +1;
            }
        }
    }
    if ($simboloElegido == CRUZ) { 
        $victorias = ganadoSimbolo($historialJuegos, $simboloElegido);
        $porcentaje = ($victorias * 100) /$acumVicTot;
        echo "\n"."El porcentaje de victorias del símbolo ".$simboloElegido. " es ".$porcentaje."%". "\n"."\n";
    }else {
        $victorias = ganadoSimbolo($historialJuegos, $simboloElegido);
        $porcentaje = ($victorias * 100) /$acumVicTot;
        echo "\n"."El porcentaje de victorias del símbolo ".$simboloElegido. " es ".$porcentaje."%". "\n"."\n";
    }
}


/**
 * El jugador elige el símbolo y retorna la cantidad de victorias del mismo
 * @param array $totPartidas
 * @param string $simbolo
 * @return int $acumVictorias
 */
function ganadoSimbolo ($totPartidas, $simbolo)
{   
    // String $ptoSimbolos, $clave, int $datos, $acumVictorias, array $partidaGuard
    $acumVictorias = 0;
    if ($simbolo == CRUZ){
        $ptoSimbolos = "puntosCruz";
    }else {
        $ptoSimbolos = "puntosCirculo";
    }
    foreach ($totPartidas as $partidaGuard){
        foreach ($partidaGuard as $clave => $datos)
        if ($ptoSimbolos == $clave && $datos > 1){
            $acumVictorias = $acumVictorias +1;            
        }
    } 
    return $acumVictorias;    
}


/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/


//Inicialización de variables:
$partidaNueva = [];
$datosJuego = [];
//Proceso:
$datosJuego = cargarJuego($datosJuego);
$menu = seleccionarOpcion();
do {
switch ($menu) { //según lo visto en clase, switch es una instrucción de estructura de control alternativa, ya que, es similar a la instrucción IF
    
    case 1: 
        $partidaNueva = jugar();
        imprimirResultado($partidaNueva);
        $datosJuego = agregarJuego($datosJuego, $partidaNueva);
        $menu = seleccionarOpcion();
        break;


    case 2: 
        mostrarJuego($datosJuego);
        $menu = seleccionarOpcion();
        break;


    case 3: 
        primerVictoriaJugador($datosJuego);
        $menu = seleccionarOpcion();
        break;

        
    case 4: 
        ganadoSimboloElegido($datosJuego);
        $menu = seleccionarOpcion();
        break;
       
        
    case 5: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
        

    case 6: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
        

    default: 
        echo "El número que ingreso no es valido, por favor ingrese un número del 1 al 7"."\n"."\n";
        $menu = seleccionarOpcion();
    break;
    }
} while ($menu < 7);
exit();

//print_r($juego);
//imprimirResultado($juego);