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

/*
    $juego = [
        "jugadorCruz" => $nombreJugadorCruz,
        "jugadorCirculo" => $nombreJugadorCirculo,
        "puntosCruz" => $puntosCruz,
        "puntosCirculo" => $puntosCirculo
    ]
*/

/**
 * Esta funcion carga ejemplos de juegos 
 * @return $array
 */
function cargarJuego($datosJuego)
{
    $datosJuego[0] = [
        "jugadorCruz" => "Jose",
        "jugadorCirculo" => "Enrike",
        "puntosCruz" => 4,
        "puntosCirculo" => 0
    ];
    $datosJuego[1] = [
        "jugadorCruz" => "Fran",
        "jugadorCirculo" => "Seba",
        "puntosCruz" => 6,
        "puntosCirculo" => 0
    ];
    $datosJuego[2] = [
        "jugadorCruz" => "Tita",
        "jugadorCirculo" => "Jose",
        "puntosCruz" => 1,
        "puntosCirculo" => 1
    ];
    $datosJuego[3] = [
        "jugadorCruz" => "Andrea",
        "jugadorCirculo" => "Roberto",
        "puntosCruz" => 0,
        "puntosCirculo" => 2
    ];
    $datosJuego[4] = [
        "jugadorCruz" => "Jose",
        "jugadorCirculo" => "Seba",
        "puntosCruz" => 0,
        "puntosCirculo" => 5
    ];
    $datosJuego[5] = [
        "jugadorCruz" => "Fran",
        "jugadorCirculo" => "Enrike",
        "puntosCruz" => 1,
        "puntosCirculo" => 1
    ];
    $datosJuego[6] = [
        "jugadorCruz" => "Tita",
        "jugadorCirculo" => "Roberto",
        "puntosCruz" => 0,
        "puntosCirculo" => 6
    ];
    $datosJuego[7] = [
        "jugadorCruz" => "Seba",
        "jugadorCirculo" => "Enrike",
        "puntosCruz" => 0,
        "puntosCirculo" => 2
    ];
    $datosJuego[8] = [
        "jugadorCruz" => "Fran",
        "jugadorCirculo" => "Jose",
        "puntosCruz" => 0,
        "puntosCirculo" => 2
    ];
    $datosJuego[9] = [
        "jugadorCruz" => "Andrea",
        "jugadorCirculo" => "Tita",
        "puntosCruz" => 0,
        "puntosCirculo" => 4
    ];
    return $datosJuego;
}

/**
 * Este modulo muestra por pantalla el Menu y retorna la opcion elegida por el usuario
 * @return int Opcion elegida
 */

function menu()
{
    // int $opcionElegida
    echo "MENU DE OPCIONES"."\n";
    echo "1) Jugar al tateti"."\n";
    echo "2) Mostrar un juego"."\n";
    echo "3) Mostrar el primer juego ganador"."\n";
    echo "4) Mostrar porcentaje de juegos ganados"."\n";
    echo "5) Mostrar resumen del jugador"."\n";
    echo "6) Mostrar listado de juegos ordenado por el jugador O"."\n";
    echo "7) Salir"."\n";
    $seleccionarOpcion = trim(fgets(STDIN));
    return $seleccionarOpcion;
}

/**
 * Este modulo solicita un numero y muestra por pantalla los datos del juego
 * @param $datosJuego
 */
function mostrarJuego($datosJuego)
{
    // int $numJuego
    $max = count($datosJuego);
    $min = 1;
    echo "Ingrese el numero del juego que desesa visualizar: ";
    $numJuego = solicitarNumeroEntre($min, $max);
    $numJuego = $numJuego - 1;
    $separador = "**************************************";
    echo $separador."\n";
    echo "Juego TATETI: ".($numJuego + 1)."\n";
    echo "Juego X: ".$datosJuego[$numJuego]["jugadorCruz"]." Obtuvo ".$datosJuego[$numJuego]["puntosCruz"]." puntos"."\n";
    echo "Juego O: ".$datosJuego[$numJuego]["jugadorCirculo"]." Obtuvo ".$datosJuego[$numJuego]["puntosCirculo"]." puntos"."\n";
    echo $separador."\n"."\n";
}


/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/
// Abre un menu de opciones para que el usuario pueda elegir
//Declaración de variables:


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
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
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
}while ($seleccionarOpcion < 7);
exit();

//print_r($juego);
//imprimirResultado($juego);



/*
do {
    $opcion = ...;

    
    switch ($opcion) {
        case 1: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 1

            break;
        case 2: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 2

            break;
        case 3: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3

            break;
        
            //...
    }
} while ($opcion != X);
*/