<?php

    SESSION_START();

    if(!isset($_SESSION['nombre'])){
        header('location: login.php');
    }

    include_once 'claseConexionBD.php';

    $Id = $_GET['Id'];

    // echo $Id;

    $BD = new ConectarBD();
    $conn = $BD->getConexion();
    $stmt = $conn->prepare('DELETE FROM peliculas where codigo = :codigo');
    $stmt->execute(array(':codigo' => $Id));


    header('location:gestor.php');



?>