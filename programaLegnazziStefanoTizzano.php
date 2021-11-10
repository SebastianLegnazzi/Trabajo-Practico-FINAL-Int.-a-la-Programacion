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
 * Este modulo muestra por pantalla el Menu y retorna la opcion elegida por el usuario
 * @return int Opcion elegida
 */

function menu()
{
    // int $opcionElegida
    echo "MENU DE OPCIONES";
    echo "1) Jugar al tateti";
    echo "2) Mostrar un juego";
    echo "3) Mostrar el primer juego ganador";
    echo "4) Mostrar porcentaje de juegos ganados";
    echo "5) Mostrar resumen del jugador";
    echo "6) Mostrar listado de juegos ordenado por el jugador O";
    echo "7) Salir";
    $opcionElegida = trim(fgets(STDIN));
    return $opcionElegida;
}

/**
 * Este modulo solicita un numero y muestra por pantalla los datos del juego
 * @param $datosJuego
 */
function mostrarJuego($datosJuego)
{
    
}





/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/
// Abre un menu de opciones para que el usuario pueda elegir
//Declaración de variables:


//Inicialización de variables:
$datosJuego = [];
//Proceso:
$opcionElegida = menu();

switch ($opcionElegida) {
    case 1: 
        
        $datosJuego[] = jugar();
        break;

    case 2: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 2
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
        
    case 7: 
        //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3
        break;
    }
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