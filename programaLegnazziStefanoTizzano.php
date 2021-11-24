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
 * Este módulo solicita un número de partida al usuario y envía los datos a la función que muestra por pantalla las estadísticas
 * @param array $listaJuegos
 */
function mostrarJuego($listaJuegos)                  //Punto 2 del menu
{
    // int $numJuego, $maximo, $minimo, $numJuego
    $maximo = count($listaJuegos);
    $minimo = 1;
    echo "Ingrese el número del juego que desea visualizar: ";
    $numJuego = solicitarNumeroEntre($minimo, $maximo);
    estadisticasPartida ($listaJuegos, $numJuego);
}


/**
 * Éste módulo muestra la primer victoria del jugador que lo solicita. Si no tiene muestra que no ganó
 * @param array $listaJuegos
 */
function primerVictoriaJugador($listaJuegos)        //Punto 3 del menu
{
//int $ganador, string $nombre
    echo "Ingrese el nombre del jugador: ";
    $nombre = strtoupper(trim(fgets(STDIN)));
    $ganador = retornaIndiceGanador($nombre, $listaJuegos);
    if($ganador > -1) {
    estadisticasPartida ($listaJuegos, $ganador);
    }else{
        echo "\n"."El jugador ". strtolower($nombre). " no ganó ningún juego"."\n";
    }
}


/**
 * El jugador elige el símbolo y muestra el porcentaje de juegos ganados
 * @param array $listaJuegos
 */
function ganadoSimboloElegido($listaJuegos)         //Punto 4 del menú
{
    //int $acumVicTot , $victorias, $datos, float $porcentaje, array $partidaGuard, $totVictorias, string $clave, $simboloElegido
    $simboloElegido = eligeSimbolo ();
    $totVictorias = partidasGanadas ($listaJuegos);
    if ($simboloElegido == CRUZ) { 
        $victorias = ganadoSimbolo($listaJuegos, $simboloElegido);
        $porcentaje = ($victorias * 100) /$totVictorias;
        echo "\n"."El porcentaje de victorias del símbolo ".$simboloElegido. " es ".$porcentaje."%". "\n";
    }else {
        $victorias = ganadoSimbolo($listaJuegos, $simboloElegido);
        $porcentaje = ($victorias * 100) /$totVictorias;
        echo "\n"."El porcentaje de victorias del símbolo ".$simboloElegido. " es ".$porcentaje."%". "\n";
    }
}


/**
 * Este modulo tiene como entrada la lista de juegos y le solicita un nombre de usuario para usarlo en la invocación al modulo
 * @param array $listaJuegos
 */
function resumenJugador($listaJuegos)               //Punto 5 del menú
{
    //string $nombre
    echo "Ingrese su nombre: "."\n";
    $nombre = trim(fgets(STDIN));
    buscarJugador($listaJuegos, $nombre);
}


/**
 * Muestra por pantalla la lista de juegos ordenada alfabéticamente por el jugador CÍRCULO
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
 * Función que contiene un array con las partidas de ejemplo
 * @return array 
 */
function cargarJuego()
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
 * @param array $listaJuegos
 * @param int $numeroPartida
 * @return string
 */
function resultadoJuego($listaJuegos, $numeroPartida)
{
    //string $resultado, array $arrayPartida 
    if ($listaJuegos[$numeroPartida]["puntosCruz"] < $listaJuegos[$numeroPartida]["puntosCirculo"]){
        $resultado = "Ganó: " . CIRCULO;
    } elseif ($listaJuegos[$numeroPartida]["puntosCruz"] > $listaJuegos[$numeroPartida]["puntosCirculo"]){
        $resultado = "Ganó: " . CRUZ;
    } else {
        $resultado = "Empate";
    }
    return $resultado;
}
 

/** 
 * Función que muestra por pantalla las estadísticas juego que ingresa el usuario
 * @param array $coleccionJuegos 
 * @param int $numPartida
 */
function estadisticasPartida($coleccionJuegos, $numPartida)
{
    // string $separador, $resultado
    $numPartida = $numPartida -1; 
    $resultado = resultadoJuego($coleccionJuegos, $numPartida);
    $separador = "**************************************";
    echo "\n".$separador."\n";
    echo "Juego TATETI: ".($numPartida+1)."($resultado)"."\n";
    echo "Jugador X: ".$coleccionJuegos[$numPartida]["jugadorCruz"]." obtuvo ".$coleccionJuegos[$numPartida]["puntosCruz"]." puntos"."\n";
    echo "Jugador O: ".$coleccionJuegos[$numPartida]["jugadorCirculo"]." obtuvo ".$coleccionJuegos[$numPartida]["puntosCirculo"]." puntos"."\n";
    echo $separador."\n"; 
}


/**
 * Retorna el índice de la primer victoria según el nombre ingresado
 * @param string $jugador
 * @param array $coleccionJuegos
 * @return int
 */
function retornaIndiceGanador($jugador, $coleccionJuegos)
{
    //int $i, $dimension, $indiceGanador, bool $jugadorEncontrado
    $i=0;
    $jugadorEncontrado = false;
    $indiceGanador = -1;
    $dimension = count($coleccionJuegos);
    while (!$jugadorEncontrado && $dimension > $i ) {
      if ($jugador == strtoupper($coleccionJuegos[$i]["jugadorCruz"]) && $coleccionJuegos[$i]["puntosCruz"] > 1){
        $jugadorEncontrado = true;
        $indiceGanador = $i+1;
      }else if($jugador == strtoupper($coleccionJuegos[$i]["jugadorCirculo"]) && $coleccionJuegos[$i]["puntosCirculo"] > 1){
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
 * Toma el array de juegos y le agrega los juegos nuevos
 * @param array $listaJuegos
 * @param array $nuevoJuego
 * @return array
 */
function agregarJuego($listaJuegos, $nuevoJuego)
{
    // int $dimension, array $coleccionJuegos
    array_push($listaJuegos, $nuevoJuego);
    return $listaJuegos;
}


/**
 * Le ingresa el array de las partidas guardadas y retorna la cantidad de victorias
 * @param array $coleccionJuegos
 * @return int 
 */
function partidasGanadas($coleccionJuegos)
{
    //int $acumPartGanadas, $datos, array $partidaGuard, string $clave
    $acumPartGanadas = 0;
    foreach ($coleccionJuegos as $partidaGuard){
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
 * @param array $coleccionJuegos
 * @param string $simbolo
 * @return int
 */
function ganadoSimbolo ($coleccionJuegos, $simbolo)
{   
    //string $ptoSimbolos, $clave, int $datos, $acumVictorias, array $partidaGuard
    $acumVictorias = 0;
    if ($simbolo == CRUZ){
        $ptoSimbolos = "puntosCruz";
    }else {
        $ptoSimbolos = "puntosCirculo";
    }
    foreach ($coleccionJuegos as $partidaGuard){
        foreach ($partidaGuard as $clave => $datos)
        if ($ptoSimbolos == $clave && $datos > 1){
            $acumVictorias = $acumVictorias +1;            
        }
    } 
    return $acumVictorias;    
}


/**
 * Este módulo recorre la colección de juegos y guarda los índices de las partidas encontradas en un array
 * @param array $coleccionJuegos
 * @param string $jugador
 */
function buscarJugador($coleccionJuegos, $jugador)
{
    //boolean $encontro, array $partidasJugador, int $i, string $datos
    $encontro = false;
    $partidasJugador = [];
    $i = 0;
    foreach ($coleccionJuegos as $partida){         
        foreach ($partida as $clave => $datos){ 
            if (strtoupper($jugador) == strtoupper($datos)){
                array_push($partidasJugador, $i);
                $encontro = true;
                }
            }
            $i = $i + 1;
        }
        if($encontro){
            acumEstadisticas($coleccionJuegos, $jugador, $partidasJugador);
        }else{
            echo "\n"."El jugador ".$jugador." no existe."."\n";
        }
}


/**
 * Este módulo acumula las estadísticas del jugador
 * @param array $listaJuegos
 * @param string $nombre
 * @param array $partidasJugadas
 */
function acumEstadisticas($listaJuegos, $nombre, $partidasJugadas)
{
    //array $estadisticaJugador, int $ptos, $i, boolean $simboloCruz 
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
 * Este módulo determina si es cruz o círculo
 * @param array $coleccionJuegos
 * @param int $indice
 * @param string $jugador
 * @return boolean
 */
function cruzOCirculo($coleccionJuegos, $indice, $jugador) 
{
    //boolean $esCruz
    if(strtoupper($coleccionJuegos[$indice]["jugadorCruz"]) == strtoupper($jugador)){
        $esCruz = true;
    }else {
        $esCruz = false;
    }
    return $esCruz;
}


/**
 * Este módulo determina si gana, empata o pierde
 * @param array $coleccionJuegos
 * @param int $indice
 * @param boolean $esX
 * @return int 
 */
function ganaPierdeEmp($coleccionJuegos, $indice, $esX)
{
    //int $puntos,
    $puntos = 0;
    if($esX == true){
            if($coleccionJuegos[$indice]["puntosCruz"] > 1){
                $puntos = $coleccionJuegos[$indice]["puntosCruz"];
            }elseif ($coleccionJuegos[$indice]["puntosCruz"] == 1){
                $puntos = 1;
            } elseif($coleccionJuegos[$indice]["puntosCruz"] == 0){
                $puntos = 0;
            }
    }else{
        if($coleccionJuegos[$indice]["puntosCirculo"] > 1){
            $puntos = $coleccionJuegos[$indice]["puntosCirculo"];
        }elseif ($coleccionJuegos[$indice]["puntosCirculo"] == 1){
            $puntos = 1;
        } elseif($coleccionJuegos[$indice]["puntosCirculo"] == 0){
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
    //string $separador
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
 * @return array //Retorna la lista de todos los juegos ordenada alfabeticamente por los nombres del jugador circulo
 */
function ordenarJugador($a, $b)
{
    //array strcmp($a["jugadorCruz"], $b["jugadorCruz"])
    return strcmp($a["jugadorCirculo"], $b["jugadorCirculo"]);
}


/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/


//array $partidaNueva, $datosJuego, int $menu
$partidaNueva = [];
$datosJuego = [];
$datosJuego = cargarJuego();
$menu = seleccionarOpcion();
do {
switch ($menu) { //Según lo visto en clase, switch es una instrucción de estructura de control alternativa, ya que, es similar a la instrucción IF
    
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
        echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 7"."\n"."\n";
        $menu = seleccionarOpcion();
    break;
    }
} while ($menu < 7 || $menu > 7);
exit();