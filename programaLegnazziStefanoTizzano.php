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
 * @return int $menu
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
function ganadoSimboloElegido($historialJuegos)     //Punto 4 del menu
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
 * Muestra el resumen de las partidas del jugador ingresado
 * @param array $listaJuegos
 */
function resumenJugador($listaJuegos)               //Punto 5 del menu
{
    //int $acumGanados, $acumPerdidos, $acumEmpatados, $acumPtos, $datos
    //bool $encontro, array $infoJugador, $partida, string $simbolo, $cruzOCirculo, $nombre, $clave, $separador
    $acumGanados = 0;
    $acumPerdidos = 0;
    $acumEmpatados = 0;
    $acumPtos = 0;
    $cruzOCirculo = "";
    $encontro = false;
    echo "Ingrese su nombre: "."\n";
    $nombre = trim(fgets(STDIN));
    $infoJugador = ["nombre"=>" ",
                    "juegosGanados"=> 0,
                    "juegosPerdidos"=> 0,
                    "juegosEmpatados"=> 0,
                    "puntosAcumulados"=>0];
    do{
        foreach ($listaJuegos as $partida){         //En listaJuegos busca el indice cero y guarda todos los datos de la partida
            foreach ($partida as $clave => $datos){ //Por cada clave guarda el nombre de esa clave y el dato que esta asociado 
                if (strtoupper($nombre) == strtoupper($datos)){ //Revisa si el nombre de la partida coincide al ingresado
                    $cruzOCirculo = $clave;         //Guarda si es X ó O
                    $encontro = true;               //Guarda si encontro al menos 1 partida
                }            
                if ($cruzOCirculo == "jugadorCruz" && $clave == "puntosCruz" && $datos > 1){            //Consulta si jugo como X ó O, y si gano
                    $acumGanados= $acumGanados +1;
                    $acumPtos = $acumPtos + $datos;
                    }else if ($cruzOCirculo == "jugadorCruz" && $clave == "puntosCruz" && $datos == 1){ //Consulta si jugo como X ó O, y si empato
                        $acumEmpatados = $acumEmpatados +1;
                        $acumPtos = $acumPtos + $datos;
                    }else if ($cruzOCirculo == "jugadorCruz" && $clave == "puntosCruz" && $datos == 0){ //Consulta si jugo como X ó O, y si perdió
                        $acumPerdidos = $acumPerdidos +1;
                    }
                if ($cruzOCirculo == "jugadorCirculo" && $clave == "puntosCirculo" && $datos > 1){      //Consulta si jugo como X ó O, y si gano
                    $acumGanados= $acumGanados +1;
                    $acumPtos = $acumPtos + $datos;
                    }else if ($cruzOCirculo == "jugadorCirculo" && $clave == "puntosCirculo" && $datos == 1){   //Consulta si jugo como X ó O, y si empato
                        $acumEmpatados = $acumEmpatados +1;
                        $acumPtos = $acumPtos + $datos;
                    }else if ($cruzOCirculo == "jugadorCirculo" && $clave == "puntosCirculo" && $datos == 0){   //Consulta si jugo como X ó O, y si perdió
                        $acumPerdidos = $acumPerdidos +1;
                }
            }
            $cruzOCirculo = "";     //Borra si fue cruz o circulo para seguir buscando en la siguiente partida y que no se genere un bucle
        }
    if(!$encontro){                 //Si no encuentra el jugador, vuelve a pedir otro nombre
        echo "\n"."El jugador ingresado no jugó nunca, por favor ingrese otro nombre"."\n";
        $nombre = trim(fgets(STDIN));
    }
    }while(!$encontro);               //Si encontró el jugador, devuelve el resultado por pantalla
        $infoJugador["nombre"] = strtolower($nombre);
        $infoJugador["juegosGanados"] = $acumGanados;
        $infoJugador["juegosPerdidos"] = $acumPerdidos;
        $infoJugador["juegosEmpatados"] = $acumEmpatados;
        $infoJugador["puntosAcumulados"] = $acumPtos;
        $separador = "**********************";
        echo "\n".$separador."\n";
        echo "Jugador: ".$infoJugador["nombre"]."\n";
        echo "Ganó: ".$infoJugador["juegosGanados"]."\n";
        echo "Perdió: ".$infoJugador["juegosPerdidos"]."\n";
        echo "Empató: ".$infoJugador["juegosEmpatados"]."\n";
        echo "Total de puntos acumulados: ".$infoJugador["puntosAcumulados"]." puntos"."\n";
        echo $separador."\n";
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
 * @param array $arrayPartida
 * @param int $numeroPartida
 * @return string $resultado
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
 * @return int $indiceGanador
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
 * @return string $simbolo
 */
function eligeSimbolo()
{
    //string $simbolo
    echo "Ingrese un símbolo X ó O"."\n";
    $simbolo = strtoupper(trim(fgets(STDIN))); //Ingresa el simbolo y es forzado a quedar en mayusuculas para comparación
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
    $coleccionJuegos[$dimension] = $nuevoJuego;
    return $coleccionJuegos;
}


/**
 * Le ingresa el array de las partidas guardadas y retorna la cantidad de victorias
 * @param array $partidasGral
 * @return int $acumPartGanadas 
 */
function partidasGanadas($partidasGral)
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
 * @return int $acumVictorias
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
 * Ordena el array por nombre de jugador cuyo simbolo es O
 * @param array $a
 * @param array $b
 * @return array strcmp($a["jugadorCruz"], $b["jugadorCruz"])
 */
function ordenarJugador($a, $b)
{
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
        echo "El número que ingreso no es valido, por favor ingrese un número del 1 al 7"."\n"."\n";
        $menu = seleccionarOpcion();
    break;
    }
} while ($menu < 7 || $menu > 7);
exit();