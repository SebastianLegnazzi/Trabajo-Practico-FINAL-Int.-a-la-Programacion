<?php


/*
La librería tateti posee la definición de constantes y funciones necesarias
para jugar al tateti.
Puede ser utilizada por cualquier programador para incluir en sus programas.
*/

/**************************************/
/***** DEFINICION DE CONSTANTES *******/
/**************************************/
define('LIBRE',  'L');
define('CRUZ',    'X');
define('CIRCULO', 'O');

define('PTOS_PERDEDOR', '0');
define('PTOS_EMPATE',   '1');
define('PTOS_GANADOR',  '2');

/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/
/**
 * Iniciliza una estructura de datos TABLERO para jugar al tateti
 * @return array
 */
function iniciarTablero()
{
    //array $tableroTateti
    $tableroTateti =
        [  //col0  //col1 //col2
            [LIBRE, LIBRE, LIBRE], //fila 0
            [LIBRE, LIBRE, LIBRE], //fila 1
            [LIBRE, LIBRE, LIBRE]  //fila 2
        ];
    return $tableroTateti;
}

/**
 * Determina si un casillero del tablero está libre
 * @param array $tableroTateti
 * @param int $fila
 * @param int $columna
 * @return boolean
 */
function esCasilleroLibre($tableroTateti, $fila, $columna)
{
    //string $casillero
    $casillero = $tableroTateti[$fila][$columna];
    return $casillero == LIBRE;
}

/**
 * Reemplaza el simbolo de un casillero. 
 * El casillero (fila,columna) ingresado debe ser válido.
 * @param array $tableroTateti
 * @param int $fila
 * @param int $columna
 * @param string $nuevoSimbolo
 * @return array tablero con el casillero cambiado.
 */
function reemplazarSimboloCasillero($tableroTateti, $fila, $columna, $nuevoSimbolo)
{
    $tableroTateti[$fila][$columna] = $nuevoSimbolo;
    return $tableroTateti;
}

/**
 * Solicita al usuario un número en el rango [$min,$max]
 * @param int $min
 * @param int $max
 * @return int 
 */
function solicitarNumeroEntre($min, $max)
{
    //int $numero
    $numero = trim(fgets(STDIN));
    while (!is_int($numero) && !($numero >= $min && $numero <= $max)) {
        echo "Debe ingresar un número entre " . $min . " y " . $max . ": ";
        $numero = trim(fgets(STDIN));
    }
    return $numero;
}

/**
 * Retorna una arreglo asociativo ["fila"=>nro de fila, "columna"=>nro de col] que representa el lugar libre.
 * @param array $tableroTateti
 * @return array 
 */
function solicitarCasilleroLibre($tableroTateti)
{
    //int $dimension, $nroFila, $nroColumna, boolean $esLibre, array $casillerolibre
    $dimension = count($tableroTateti);
    do {
        echo "Ingrese el número de FILA: ";
        $nroFila = solicitarNumeroEntre(1, $dimension);
        $nroFila = $nroFila - 1;
        echo "Ingrese el número de COLUMNA: ";
        $nroColumna = solicitarNumeroEntre(1, $dimension);
        $nroColumna = $nroColumna - 1;
        $esLibre = esCasilleroLibre($tableroTateti, $nroFila, $nroColumna);
        if (!$esLibre) {
            echo "El casillero ingresado se encuentra ocupado! Ingrese un casillero libre.\n";
        }
    } while (!$esLibre);
    $casillerolibre = ["fila" => $nroFila, "columna" => $nroColumna];
    return $casillerolibre;
}


/**
 * Retorna el número de fila que ganó el simbolo enviado por parámetro. 
 * Si el símbolo no ganó, retorna -1
 * @param array $tableroTateti
 * @param string $simbolo Debe ser distinto de LIBRE
 * @return int nro de fila ganadora. -1 si el simbolo no ganó por fila.
 */
function obtenerFilaGanadora($tableroTateti, $simbolo)
{
    //int $fila, $columna, $dimension, $filaGanadora, boolean $existeGanador
    $fila = 0;
    $dimension = count($tableroTateti);
    $existeGanador = false;
    $filaGanadora = -1;
    while ($fila < $dimension && !$existeGanador) {
        $columna = 0;
        while ($columna < $dimension && $tableroTateti[$fila][$columna] == $simbolo) {
            $columna++;
        }
        if ($columna == $dimension) {
            $existeGanador = true;
            $filaGanadora = $fila;
        } else {
            $fila++;
        }
    }
    return $filaGanadora;
}

/**
 * Retorna el número de columna que ganó el simbolo enviado por parámetro.
 * Si el símbolo no ganó, retorna -1
 * @param array $tableroTateti
 * @param string $simbolo Debe ser distinto de LIBRE
 * @return int nro de columna ganadora. -1 si el simbolo no ganó por columna.
 */
function obtenerColumnaGanadora($tableroTateti, $simbolo)
{
    //int $columna, $fila, $dimension, $columnaGanadora, boolean $existeGanador
    $columna = 0;
    $dimension = count($tableroTateti);
    $existeGanador = false;
    $columnaGanadora = -1;
    while ($columna < $dimension && !$existeGanador) {
        $fila = 0;
        while ($fila < $dimension && $tableroTateti[$fila][$columna] == $simbolo) {
            $fila++;
        }
        if ($fila == $dimension) {
            $existeGanador = true;
            $columnaGanadora = $columna;
        } else {
            $columna++;
        }
    }
    return $columnaGanadora;
}

/**
 * Determina si el simbolo enviado por parámetro ganó la primer diagonal. False caso contrario
 * @param array $tableroTateti
 * @param string $simbolo Debe ser distinto de LIBRE
 * @return boolean 
 */
function esPrimerDiagonalGanadora($tableroTateti, $simbolo)
{
    //int $fila, $dimension, boolean $ganadora
    $fila = 0;
    $dimension = count($tableroTateti);
    $ganadora = true;
    while ($fila < $dimension && $ganadora) {
        $ganadora = $tableroTateti[$fila][$fila] == $simbolo;
        $fila++;
    }
    return $ganadora;
}

/**
 * Determina si el simbolo enviado por parámetro ganó la segunda diagonal. False caso contrario
 * @param array $tableroTateti
 * @param string $simbolo Debe ser distinto de LIBRE
 * @return boolean 
 */
function esSegundaDiagonalGanadora($tableroTateti, $simbolo)
{
    //int $fila, $columna, $dimension, boolean $ganadora
    $dimension = count($tableroTateti);
    $fila = 0;
    $columna = $dimension - 1;
    $ganadora = true;
    while ($fila < $dimension && $ganadora) {
        $ganadora = $tableroTateti[$fila][$columna] == $simbolo;
        $fila++;
        $columna--;
    }
    return $ganadora;
}

/**
 * Determina si un símbolo determinado ganó. Retona true si ganó, false caso contrario
 * @param array $tableroTateti
 * @param string $simbolo Debe que ser distinto de LIBRE
 * @return boolean
 */
function determinarSiGano($tableroTateti, $simbolo)
{
    //boolean $gano, int $filaGanadora, $columnaGanadora

    //determino si ganó una fila:
    $filaGanadora = obtenerFilaGanadora($tableroTateti, $simbolo);
    $gano = $filaGanadora >= 0;
    if (!$gano) {
        //como no ganó una fila, determino si ganó una columna:
        $columnaGanadora = obtenerColumnaGanadora($tableroTateti, $simbolo);
        $gano = $columnaGanadora >= 0;
        if (!$gano) {
            //como no ganó ni fila, ni columna, determino si ganó la 1er diagonal:
            $gano = esPrimerDiagonalGanadora($tableroTateti, $simbolo);
            if (!$gano) {
                //como no ganó ni fila, ni columna, ni 1er diagonal, determino si ganó la 2da diagonal:
                $gano = esSegundaDiagonalGanadora($tableroTateti, $simbolo);
            }
        }
    }
    return $gano;
}

/**
 * Cuenta la cantidad de casilleros que contienen al simbolo ingresado por parámetro
 * @param array $tableroTateti
 * @param string $simbolo
 * @return int
 */
function contarSimbolo($tableroTateti, $simboloAContar)
{
    //int $cantidad, array $arregloFila, string $simbolo 
    $cantidad = 0;
    foreach ($tableroTateti as $arregloFila) {
        foreach ($arregloFila as $simbolo) {
            if ($simbolo == $simboloAContar) {
                $cantidad++;
            }
        }
    }
    return $cantidad;
}

/**
 * Cuenta la cantidad de casilleros libres en el tablero
 * @param array $tableroTateti
 * @return int
 */
function contarCantLibres($tableroTateti)
{
    //int cantidadLibres
    $cantidadLibres = contarSimbolo($tableroTateti, LIBRE);
    return $cantidadLibres;
}

/**
 * Determina si el tablero se completó de simbolos, es decir, no hay más espacios libres.
 * @param array $tableroTateti
 * @return boolean
 */
function estaCompleto($tableroTateti)
{
    //boolean $completo, int $fila, $dimension, $columna
    $completo = true;
    $fila = 0;
    $dimension = count($tableroTateti);
    while ($fila < $dimension && $completo) {
        $columna = 0;
        while ($columna < $dimension && $completo) {
            $completo = !esCasilleroLibre($tableroTateti, $fila, $columna);
            $columna++;
        }
        $fila++;
    }
    return $completo;
}


/**
 * Imprirme en pantalla el simbolo
 * @param string $simbolo
 */
function imprimirSimbolo($simbolo)
{
    if ($simbolo == LIBRE) {
        echo " ";
    } else {
        echo $simbolo;
    }
}

/**
 * Imprime en pantalla el tabler del tateti
 *  @param array $tablero
 */
function imprimirTableroTateti($tablero)
{
    //string $linea, $separador
    //int $cantFilas,$fila,$cantColumnas,$columna
    $linea     = "       - - - - - -\n";
    $separador = ' | ';

    echo "         COLUMNA \n";
    echo "        1   2   3 \n";
    echo "FILA   - - - - - -\n";

    //echo $linea; //inicio dibujo tablero
    $cantFilas = count($tablero);
    for ($fila = 0; $fila < $cantFilas; $fila++) {
        echo '  ' . ($fila + 1) . '  ';
        echo $separador; //inicio dibujo fila
        $cantColumnas = count($tablero[$fila]);
        for ($columna = 0; $columna < $cantColumnas; $columna++) {
            imprimirSimbolo($tablero[$fila][$columna]);
            echo $separador;
        }
        echo "\n";
        echo $linea; //cierro fila        
    }
}

/**
 * Muestra en pantalla el resultado del juego
 * @param array $juego
 */
function imprimirResultado($juego)
{
    echo "**********************\n";
    if ($juego["puntosCruz"] > $juego["puntosCirculo"]) {
        echo $juego["jugadorCruz"] . " GANASTE " . $juego["puntosCruz"] . " puntos!!!!!\n";
    } elseif ($juego["puntosCruz"] < $juego["puntosCirculo"]) {
        echo $juego["jugadorCirculo"] . " GANASTE " . $juego["puntosCirculo"] . " puntos!!!!!\n";
    } else {
        echo "EMPATE ENTRE " . $juego["jugadorCruz"] . " y " . $juego["jugadorCirculo"] . ". " . $juego["puntosCruz"] . "  puntos para cada uno!!!!!\n";
    }
    echo "**********************\n";
}

/**
 * Permitr completar un casillero libre a un jugador determinado.
 * @param array $tableroTateti
 * @param string $nombreJugador
 * @param string $simbolo
 * @return array tablero modificado
 */
function jugarTurno($tableroTateti, $nombreJugador, $simbolo)
{
    //array $casilleroElegido
    echo "Es el turno de " . $nombreJugador . "\n";
    $casilleroElegido = solicitarCasilleroLibre($tableroTateti);
    $tableroTateti = reemplazarSimboloCasillero($tableroTateti, $casilleroElegido["fila"], $casilleroElegido["columna"], $simbolo);
    imprimirTableroTateti($tableroTateti);
    return $tableroTateti;
}


/**
 * Inicia y finaliza un juego de tateti
 * @return array Juego tateti finalizado
 */
function jugar()
{
    $tablero = iniciarTablero();
    $dimensionTablero = count($tablero);
    $cantMinimaCasillerosLlenosParaGanar = $dimensionTablero + ($dimensionTablero - 1);
    $cantCasilleroCompletos = 0;
    $esGanadorCruz = false;
    $esGanadorCirculo = false;
    $tableroCompleto = false;

    echo "Ingrese el nombre del jugador " . CRUZ . " que inicia el juego de tateti: ";
    $nombreJugadorCruz = strtoupper(trim(fgets(STDIN)));
    echo "Ingrese el nombre del jugador " . CIRCULO . " que juega en segundo lugar: ";
    $nombreJugadorCirculo = strtoupper(trim(fgets(STDIN)));

    //Imprimir el tablero inicial:
    imprimirTableroTateti($tablero);

    $tablero = jugarTurno($tablero, $nombreJugadorCruz, CRUZ);
    $cantCasilleroCompletos = 1;
    do {
        $tablero = jugarTurno($tablero, $nombreJugadorCirculo, CIRCULO);
        $tablero = jugarTurno($tablero, $nombreJugadorCruz, CRUZ);
        $cantCasilleroCompletos = $cantCasilleroCompletos + 2;
    } while ($cantCasilleroCompletos < $cantMinimaCasillerosLlenosParaGanar);

    //CRUZ tiene una jugada más que CIRCULO, determinar si es ganador:
    $esGanadorCruz = determinarSiGano($tablero, CRUZ);

    while (!$tableroCompleto && !$esGanadorCruz && !$esGanadorCirculo) {

        if (!$tableroCompleto && !$esGanadorCruz) {
            $tablero = jugarTurno($tablero, $nombreJugadorCirculo, CIRCULO);
            $esGanadorCirculo = determinarSiGano($tablero, CIRCULO);
            $tableroCompleto = estaCompleto($tablero);
        }

        if (!$tableroCompleto && !$esGanadorCirculo) {
            $tablero = jugarTurno($tablero, $nombreJugadorCruz, CRUZ);
            $esGanadorCruz = determinarSiGano($tablero, CRUZ);
            $tableroCompleto = estaCompleto($tablero);
        }
    }

    //Determinar puntajes:
    $puntosCruz = PTOS_PERDEDOR;
    $puntosCirculo = PTOS_PERDEDOR;
    if ($esGanadorCruz) {
        $puntosCruz = PTOS_GANADOR + contarCantLibres($tablero);
    } else {
        if ($esGanadorCirculo) {
            $puntosCirculo = PTOS_GANADOR + contarCantLibres($tablero);
        } else {
            $puntosCirculo = PTOS_EMPATE;
            $puntosCruz = PTOS_EMPATE;
        }
    }

    //armar estructura del juego
    $juego = [
        "jugadorCruz" => $nombreJugadorCruz,
        "jugadorCirculo" => $nombreJugadorCirculo,
        "puntosCruz" => $puntosCruz,
        "puntosCirculo" => $puntosCirculo
    ];

    return $juego;
}
