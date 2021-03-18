<?php

// Iniciar la sesion.
session_start();

// Se verifica si está iniciada la sesión del usuario.
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

// Incluyendo el archivo de configuración de base de datos.
require_once "config.php";

// Definción en inicialización de variables.
$rut     = $password     = "";
$rut_err = $password_err = "";

// Procesamientos de valores entregados en el formulario.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificamos si el rut está vacía.
    if (empty(trim($_POST["rut"]))) {
        $rut_err = "Por favor ingrese su rut.";
    } else {
        $rut = trim($_POST["rut"]);
    }

    // Verificamos si la contraseña está vacía.
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor ingrese su contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validamos credenciales
    if (empty($rut_err) && empty($password_err)) {
        // Preparar la consulta a la base de datos.
        $sql = "SELECT id_acc, rut_acc, nom_acc, pss_acc FROM cuentas WHERE rut_acc = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Vincula las variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_rut);

            // Seteo parametros.
            $param_rut = $rut;

            // Ejecición de sentencia.
            if (mysqli_stmt_execute($stmt)) {
                // Alamceno resultados.
                mysqli_stmt_store_result($stmt);

                    // Verifica si existe el rut, si existe verifica contraseña.
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Vincula las variables.
                        mysqli_stmt_bind_result($stmt, $id, $rut, $nom, $pass);
                        if (mysqli_stmt_fetch($stmt)) {
                            if ($password == $pass) {
                                // Contraseña correcta, inicia nueva sesión.
                                session_start();

                                // Almacena información de sesión.
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"]       = $id;
                                $_SESSION["nombre"]   = $nom;                                
                                $_SESSION["rut"]      = $rut;

                                // Redirecciona a sitio home.
                                header("location: home.php");
                            } else {
                                // Mensaje de error con la contraseña.
                                $password_err = "La contraseña que has ingresado no es válida.";
                            }
                        }
                    } else {
                        // Error en caso de que no existe rut registrado.
                        $rut_err = "No existe cuenta registrada con ese rut.";
                    }
            } else {
                echo "Algo salió mal, por favor vuelve a intentarlo.";
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
    <title>Login - Rekoober</title>
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login - Rekoober</h2>
        <p>Por favor, complete sus credenciales para iniciar sesión.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group <?php echo (!empty($rut_err))?'has-error':'';?>">
                <label>RUT</label>
                <!-- pattern="[0-9]{7,8}-[0-9Kk]{1}" placeholder="11111111-A" -->
                <input type="text" id="rut" name="rut" class="form-control" value="<?php echo $rut;?>" >    
                <span class="form-text text-danger"><?php echo $rut_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err))?'has-error':'';?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" id="password">
                <span class="form-text text-danger"><?php echo $password_err;?></span>
            </div>
            <div class="form-group">
                <input type="checkbox" onclick="mostrarContraseña()"> Ver contraseña
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Iniciar sesión">
            </div>
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate ahora</a>.</p>
        </form>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="./js/jquery.mask.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#rut').mask('00.000.000-A');
            });
        </script>
        <script type="text/javascript">
            function mostrarContraseña() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                  x.type = "text";
                } else {
                  x.type = "password";
                }
            }
        </script>      

    </div>
    <?php include('footer.php');?>
</body>
</html>