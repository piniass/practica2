<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Pelicula</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            gap:10px;
        }

        form {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h2{
            text-align:center;
        }

        #volver{
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            padding: .75rem 1.25rem;
        }

        #volver:hover{
            background-color: #0056b3;
        }

        .insertada{
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: .25rem;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php
        SESSION_START();

        if(!isset($_SESSION['nombre'])){
            header('location: login.php');
        }
    
        include_once 'claseConexionBD.php';
    
        $Id = $_GET['Id'];

        $BD = new ConectarBD();
            $conn = $BD->getConexion(); 
            $stmt = $conn->prepare('SELECT * FROM peliculas where codigo = :codigo');
            $stmt->execute(array(':codigo' => $Id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ( $peliculas = $stmt->fetch() ){           
    ?>
<form action="" method="post">
    <h2>Modificar Película</h2>
    Titulo
        <input type="text" name="titulo" value="<?php echo $peliculas['titulo'] ?>" id="titulo">
    Director
        <input type="text" name="director" value="<?php echo $peliculas['director'] ?>" id="director">
    Genero
        <input type="text" name="genero" value="<?php echo $peliculas['genero'] ?>" id="genero">   
    Año
        <input type="number" name="anio" value="<?php echo $peliculas['anio'] ?>" id="anio">
    <!-- <?php
         
            }
            
    ?> -->
    <input type="submit" value="Modificar" name="enviar">
    <?php
    if(isset($_POST['enviar'])){
        $stmt = $conn->prepare('UPDATE peliculas SET titulo=:titulo, director=:director, genero=:genero, anio=:anio WHERE codigo=:codigo');
        $stmt->execute(array(
            ':codigo' => $Id,
            ':titulo' => $_POST['titulo'],
            ':director' =>$_POST['director'],
            ':genero' => $_POST['genero'],
            ':anio' => $_POST['anio']
        ));
        // header('location:gestor.php');
        if ($stmt->rowCount() > 0) {
            echo 'Modificadas ' . $stmt->rowCount() . ' filas';
        } else {
            echo 'No se han modificado filas';
        }
    }
?>

    </form>
    <a href="gestor.php" id="volver">Volver</a>

</body>
</html>