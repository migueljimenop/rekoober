<?php

// Iniciar la sesion.
session_start();
// Se verifica si está iniciada la sesión del usuario.

// Verificamos si está el usuario logueado, en caso que no se redirige al login.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: home.php");
    exit;
}

// Incluyendo el archivo de configuración de base de datos.
require_once "config.php";

// Definción en inicialización de variables.
$nom_aut    = $ape_aut  = "";
$nom_err    = $ape_err  = "";

// Procesamientos de valores entregados en el formulario.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificamos si el rut está vacía.
    if (empty(trim($_POST["nom_autor"]))) {
        $nom_err = "Por favor ingrese el nombre del autor.";
    } else {
        $nom_aut = trim($_POST["nom_autor"]);
    }

    // Verificamos si la contraseña está vacía.
    if (empty(trim($_POST["ape_autor"]))) {
        $ape_err = "Por favor ingrese el apellido del autor.";
    } else {
        $ape_aut = trim($_POST["ape_autor"]);
    }
          
    // Verificación de errores antes de actualizar base de datos.
    if (empty($nom_err) && empty($ape_err)) {

        // Preparación de datos a insertar.
        $sql = "INSERT INTO autores (nom_aut, ape_aut) VALUES (?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Vincula las variables a la declaración preparada como parámetros.
                mysqli_stmt_bind_param($stmt, "ss", $param_nom, $param_ape);

                // Seteamos parametros
                $param_nom      = $nom_aut;
                $param_ape      = $ape_aut;       

                // Ejecución de sentencia.
                if (mysqli_stmt_execute($stmt)) {
                    // Redireccion a la pagina de inicio.
                    header("location: ver-autor.php");
                } else {
                    echo "Algo salió mal, por favor inténtalo de nuevo.";
                }
            }

            // Cierra sentencia.
            mysqli_stmt_close($stmt);
    }

	// Cierra conexión.
	mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Autor - Rekoober</title>    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <?php include('header.php');?>
    <div class="container">
        <div class="col-sm-12" style="padding: 20px;">
            <h2>Agregar Autor - Rekoober</h2>
            <p>Por favor, complete el registro de autor.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="form-group <?php echo (!empty($nom_err))?'has-error':'';?>">
                    <label>Nombre del autor</label>
                    <input type="text" id="nom_autor" name="nom_autor" class="form-control" value="<?php echo $nom_aut;?>" >    
                    <span class="form-text text-danger"><?php echo $nom_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($ape_err))?'has-error':'';?>">
                    <label>Apellido del autor</label>
                    <input type="text" name="ape_autor" class="form-control">
                    <span class="form-text text-danger"><?php echo $ape_err;?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="Agregar Autor">
                </div>
            </form>
            <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        </div>
    </div>
    <?php include('footer.php');?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
</body>
</html>

