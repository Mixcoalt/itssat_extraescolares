<?php
    $host = "localhost";
    $us = "root";
    $pw = "123456789";
    $bd = "extraescolares";

    $conex = mysqli_connect($host, $us, $pw, $bd);

    if (!$conex) {
        die("Error conectando a la BD: " . mysqli_connect_error() . " - Usuario: " . $us . " - Host: " . $host);
    } 

    if (!mysqli_set_charset($conex, 'utf8')) {
        echo "Error configurando el conjunto de caracteres: " . mysqli_error($conex);
    }

