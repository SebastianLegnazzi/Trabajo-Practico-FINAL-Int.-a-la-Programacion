<?php

include_once("tateti.php");


/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/


/* LEGNAZZI. SEBASTIAN. FAI-3152. TUDW. sebastian.legnazzi@est.fi.uncoma.edu.ar. SebastianLegnazzi */
/* STEFANO. FRANCO. FAI-2750. TUDW. franco.stefano@est.fi.uncoma.edu.ar. francoDanteStefano */
/* TIZZANO. AGOSTINA. FAI-3579. TUDW. agostina.tizzano@est.fi.uncoma.edu.ar. agostita */


/**************************************/
/*****  FUNCIONES PRINCIPALES  ********/
/**************************************/


/**
 * Este módulo muestra por pantalla el menú y retorna la opción elegida por el usuario
 * @return int 
 */
function seleccionarOpcion()
{
    // int $menu
    echo "\n"."MENU DE OPCIONES"."\n";
    echo "1) Jugar al tateti"."\n";
    echo "2) Mostrar un juego"."\n";
    echo "3) Mostrar el primer juego ganado del jugador"."\n";
    echo "4) Mostrar porcentaje de juegos ganados"."\n";
    echo "5) Mostrar resumen del jugador"."\n";
    echo "6) Mostrar listado de juegos ordenado por el jugador O"."\n";
    echo "7) Salir"."\n";
    echo "Opcion: ";
    $menu = trim(fgets(STDIN));
    echo "\n";
    return $menu;
}


/**
 * Este módulo solicita un número y muestra por pantalla los datos del juego
 * @param array $datos
 */
function mostrarJuego($datos)                       //Punto 2 del menu
{
    // int $numJuego, $max, $min, $numJuego
    $max = count($datos);
    $min = 1;
    echo "Ingrese el número del juego que desea visualizar: ";
    $numJuego = solicitarNumeroEntre($min, $max);
    estadisticasPartida ($datos, $numJuego);
}


/**
 * Éste módulo muestra la primer victoria del jugador que lo solicita. Si no tiene muestra que no ganó
 * @param array $partidasGuardadas
 */
function primerVictoriaJugador($partidasGuardadas)  //Punto 3 del menu
{
//int $i, $dimension
    //string $nombre, int $ganador
    $i=0;
    $dimension = count($partidasGuardadas);
    echo "Ingrese el nombre del jugador: ";
    $nombre = strtoupper(trim(fgets(STDIN)));
    $ganador = retornaIndiceGanador($nombre, $partidasGuardadas);
    if($ganador > -1) {
    estadisticasPartida ($partidasGuardadas, $ganador);
    }else{
        echo "\n"."El jugador ". strtolower($nombre). " no ganó ningún juego"."\n";
    }
}


/**
 * El jugador elige el símbolo y muestra el porcentaje de juegos ganados
 * @param array $historialJuegos
 */
function ganadoSimboloElegido($historialJuegos)     //Punto 4 del menú
{
    //int $acumVicTot , $victorias, $datos, float $porcentaje, array $partidaGuard, $totVictorias, string $clave, $simboloElegido
    $simboloElegido = eligeSimbolo ();
    $totVictorias = partidasGanadas ($historialJuegos);
    if ($simboloElegido == CRUZ) { 
        $victorias = ganadoSimbolo($historialJuegos, $simboloElegido);
        $porcentaje = ($victorias * 100) /$totVictorias;
        echo "\n"."El porcentaje de victorias del símbolo ".$simboloElegido. " es ".$porcentaje."%". "\n";
    }else {
        $victorias = ganadoSimbolo($historialJuegos, $simboloElegido);
        $porcentaje = ($victorias * 100) /$totVictorias;
        echo "\n"."El porcentaje de victorias del símbolo ".$simboloElegido. " es ".$porcentaje."%". "\n";
    }
}


/**
 * Este modulo tiene como entrada la lista de juegos y le solicita un nombre de usuario para usarlo en la invocacion al modulo
 * @param array $listaJuegos
 */
function resumenJugador($listaJuegos)               //Punto 5 del menú
{
    /* */
    echo "Ingrese su nombre: "."\n";
    $nombre = trim(fgets(STDIN));
    buscarJugador($listaJuegos, $nombre);
}


/**
 * Muestra por pantalla la lista de juegos ordenadas por el jugador O
 * @param array $listaJuegos
 */
function listaOrdCirc($listaJuegos)                 //Punto 6 del menu
{
    uasort($listaJuegos, "ordenarJugador");
    print_r($listaJuegos);
}


/**************************************/
/*****  FUNCIONES SECUNDARIAS  ********/
/**************************************/


/**
 * Esta función carga ejemplos de juegos 
 * @param array $partidasCargadas
 * @return array 
 */
function cargarJuego($coleccionJuegos)
{
    //array $partidasCargadas
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
 * Este módulo recibe como entrada las partidas guardadas y el número de partida y retorna si ganó CÍRCULO/CRUZ o si empataron.
 * @param array $arrayPartida
 * @param int $numeroPartida
 * @return string
 */
function resultadoJuego($arrayPartida, $numeroPartida)
{
    //string $resultado, array $arrayPartida
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
    // string $separador, $resultado
    $resultado = resultadoJuego($partida, $numPartida);
    $separador = "**************************************";
    $numPartida = $numPartida -1; 
    echo "\n".$separador."\n";
    echo "Juego TATETI: ".($numPartida+1)."($resultado)"."\n";
    echo "Jugador X: ".$partida[$numPartida]["jugadorCruz"]." obtuvo ".$partida[$numPartida]["puntosCruz"]." puntos"."\n";
    echo "Jugador O: ".$partida[$numPartida]["jugadorCirculo"]." obtuvo ".$partida[$numPartida]["puntosCirculo"]." puntos"."\n";
    echo $separador."\n"; 
}


/**
 * Retorna el índice de la primer victoria según el nombre ingresado
 * @param string $jugador
 * @param array $coleccion
 * @return int
 */
function retornaIndiceGanador($jugador, $coleccion)
{
    //int $i, $dimension, $indiceGanador, bool $jugadorEncontrado, array $coleccion
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
 * @return string
 */
function eligeSimbolo()
{
    //string $simbolo
    echo "Ingrese un símbolo X ó O"."\n";
    $simbolo = strtoupper(trim(fgets(STDIN))); //Ingresa el símbolo y es forzado a quedar en mayúsuculas para comparación
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
 * @return array
 */
function agregarJuego($coleccionJuegos, $nuevoJuego)
{
    // int $dimension, array $coleccionJuegos
    array_push($coleccionJuegos, $nuevoJuego);
    return $coleccionJuegos;
}


/**
 * Le ingresa el array de las partidas guardadas y retorna la cantidad de victorias
 * @param array $partidasGral
 * @return int 
 */
function partidasGanadas($coleccionJuegos)
{
    //int $acumPartGanadas, $datos, array $partidaGuard, string $clave
    $acumPartGanadas = 0;
    foreach ($partidasGral as $partidaGuard){
        foreach ($partidaGuard as $clave => $datos){
            if (("puntosCruz" == $clave || "puntosCirculo" == $clave)&&($datos > 1)){
                $acumPartGanadas = $acumPartGanadas +1;
            }
        }
    }
    return $acumPartGanadas;
}


/**
 * El jugador elige el símbolo y retorna la cantidad de victorias del mismo
 * @param array $totPartidas
 * @param string $simbolo
 * @return int
 */
function ganadoSimbolo ($totPartidas, $simbolo)
{   
    //string $ptoSimbolos, $clave, int $datos, $acumVictorias, array $partidaGuard
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


/**
 * Este modulo recorre la coleccion de juegos y guarda los indice de las partidas encontradas en un array
 * @param array $historialJuegos
 * @param string $jugador
 */
function buscarJugador($historialJuegos, $jugador)
{
    /* 
    */
    $encontro = false;
    $partidasJugador = [];
    $i = 0;
    foreach ($historialJuegos as $partida){         
        foreach ($partida as $clave => $datos){ 
            if (strtoupper($jugador) == strtoupper($datos)){
                array_push($partidasJugador, $i);
                $encontro = true;
                }
            }
            $i = $i + 1;
        }
        if($encontro){
            acumEstadisticas($historialJuegos, $jugador, $partidasJugador);
        }else{
            echo "\n"."El jugador ".$jugador." no existe."."\n";
        }
}

/**
 * Este modulo acumula las estadisticas del jugador
 * @param array $listaJuegos
 * @param string $nombre
 * @param array $partidasJugadas
 */
function acumEstadisticas($listaJuegos, $nombre, $partidasJugadas)
{
    /* 
    */
    $estadisticaJugador = ["nombre"=> $nombre,
                    "juegosGanados"=> 0,
                    "juegosPerdidos"=> 0,
                    "juegosEmpatados"=> 0,
                    "puntosAcumulados"=>0];
    $ptos = 0;
    for($i = 0; $i < count($partidasJugadas); $i = $i+1){
        $simboloCruz = cruzOCirculo($listaJuegos, $partidasJugadas[$i], $nombre);
        $ptos = ganaPierdeEmp($listaJuegos, $partidasJugadas[$i], $simboloCruz);
        if($ptos > 1){
            $estadisticaJugador["juegosGanados"] = $estadisticaJugador["juegosGanados"] + 1;
            $estadisticaJugador["puntosAcumulados"] = $estadisticaJugador["puntosAcumulados"] + $ptos;
        }elseif($ptos == 1){
            $estadisticaJugador["juegosEmpatados"] = $estadisticaJugador["juegosEmpatados"] + 1;
            $estadisticaJugador["puntosAcumulados"] = $estadisticaJugador["puntosAcumulados"] + 1;
        }else{
            $estadisticaJugador["juegosPerdidos"] = $estadisticaJugador["juegosPerdidos"] + 1;
        }
    }
    pantallaResumen($estadisticaJugador);
}


/**
 * Este modulo determina si es cruz o circulo
 * @param array $historialJuegos
 * @param int $indice
 * @param string $jugador
 * @return boolean
 */
function cruzOCirculo($historialJuegos, $indice, $jugador) 
{
    if(strtoupper($historialJuegos[$indice]["jugadorCruz"]) == strtoupper($jugador)){
        $esCruz = true;
    }else {
        $esCruz = false;
    }
    return $esCruz;
}


/**
 * Este modulo determina si gana, empata, pierde
 * @param array $historialJuegos
 * @param int $indice
 * @param boolean $esX
 * @return int 
 */
function ganaPierdeEmp($historialJuegos, $indice, $esX)
{
    $puntos = 0;
    if($esX == true){
            if($historialJuegos[$indice]["puntosCruz"] > 1){
                $puntos = $historialJuegos[$indice]["puntosCruz"];
            }elseif ($historialJuegos[$indice]["puntosCruz"] == 1){
                $puntos = 1;
            } elseif($historialJuegos[$indice]["puntosCruz"] == 0){
                $puntos = 0;
            }
    }else{
        if($historialJuegos[$indice]["puntosCirculo"] > 1){
            $puntos = $historialJuegos[$indice]["puntosCirculo"];
        }elseif ($historialJuegos[$indice]["puntosCirculo"] == 1){
            $puntos = 1;
        } elseif($historialJuegos[$indice]["puntosCirculo"] == 0){
            $puntos = 0;
        }
}
    return $puntos;
}

/**
 * Muestra por pantalla las estadísticas del jugador
 * @param array $histJugador
 */
function pantallaResumen($histJugador)
{
        $separador = "**********************";
        echo "\n".$separador."\n";
        echo "Jugador: ".$histJugador["nombre"]."\n";
        echo "Ganó: ".$histJugador["juegosGanados"]."\n";
        echo "Perdió: ".$histJugador["juegosPerdidos"]."\n";
        echo "Empató: ".$histJugador["juegosEmpatados"]."\n";
        echo "Total de puntos acumulados: ".$histJugador["puntosAcumulados"]." puntos"."\n";
        echo $separador."\n";
}


/**
 * Ordena el array por nombre de jugador cuyo símbolo es O
 * @param array $a
 * @param array $b
 * @return array 
 */
function ordenarJugador($a, $b)
{
    //array strcmp($a["jugadorCruz"], $b["jugadorCruz"])
    return strcmp($a["jugadorCirculo"], $b["jugadorCirculo"]);
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
        resumenJugador($datosJuego);
        $menu = seleccionarOpcion();
        break;
        

    case 6: 
        listaOrdCirc($datosJuego);
        $menu = seleccionarOpcion();
        break;
        

    default: 
        echo "El número que ingreso no es válido, por favor ingrese un número del 1 al 7"."\n"."\n";
        $menu = seleccionarOpcion();
    break;
    }
} while ($menu < 7 || $menu > 7);
exit();