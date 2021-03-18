<?php
// Incluyendo el archivo de configuración de base de datos.
require_once "config.php";

// Definición de variables e inicializandolas en vacío.
$rut     = $password     = $confirm_password     = "";
$rut_err = $password_err = $confirm_password_err = "";
$nombre  = $email = $telefono = "";
$nombre_err  = $email_err = $telefono_err = "";

// Procesamientos de valores entregados en el formulario.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validar ingreso de rut.
        if (empty(trim($_POST["rut"]))) {
            $rut_err = "Por favor ingrese un rut.";
        } else {
            // Preparar la consulta a la base de datos.
            $sql = "SELECT id_acc FROM cuentas WHERE rut_acc = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {           
                // Vincula las variables a la declaración preparada como parámetros.
                mysqli_stmt_bind_param($stmt, "s", $param_rut);

                // Seteo parametros
                $param_rut = trim($_POST["rut"]);

                // Ejecucuión de sentencia.
                if (mysqli_stmt_execute($stmt)) {
                    // Guardo resultado.
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $rut_err = "Este rut ya tiene cuenta.";
                    } else {
                        $rut = trim($_POST["rut"]);
                    }
                } else {
                        echo "Al parecer algo salió mal.";
                }
            }
            // Cerramos la sentencia.
            mysqli_stmt_close($stmt);
        }
        
        // Validar ingreso de nombre.
	if (empty(trim($_POST["nombre"]))) {
            $nombre_err = "Por favor ingrese un nombre.";
        }else{
            $nombre = trim($_POST["nombre"]);
        }
        
        // Validar ingreso de email.
	if (empty(trim($_POST["email"]))) {
            $email_err = "Por favor ingrese un email.";
        }else{
            $email = trim($_POST["email"]);
        }

	// Validar contraseña
	if (empty(trim($_POST["password"]))) {
		$password_err = "Por favor ingresa una contraseña.";
	} elseif (strlen(trim($_POST["password"])) < 6) {
		$password_err = "La contraseña al menos debe tener 6 caracteres.";
	} else {
            $password = trim($_POST["password"]);
	}

	// Validar confirmación de contraseña.
	if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Confirma tu contraseña.";
	} else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "No coincide la contraseña.";
            }
	}
        
        // Validar ingreso de telefono.
	if (empty(trim($_POST["telefono"]))) {
            $telefono_err = "Por favor ingrese un telefono.";
        }else{
            $telefono = trim($_POST["telefono"]);
        }
        
	// Verificación de errores antes de actualizar base de datos.
	if (empty($rut_err) && empty($password_err) && empty($confirm_password_err) &&
            empty($nombre_err) && empty($email_err) && empty($telefono_err)) {

            // Preparación de datos a insertar.
            $sql = "INSERT INTO cuentas (rut_acc, nom_acc, ema_acc, pss_acc, tel_acc) VALUES (?, ?, ?, ?, ?)";

		if ($stmt = mysqli_prepare($link, $sql)) {
                    // Vincula las variables a la declaración preparada como parámetros.
                    mysqli_stmt_bind_param($stmt, "ssssi", $param_rut, $param_nom, $param_ema , $param_pss, $param_tel);

                    // Seteamos parametros
                    $param_rut      = $rut;
                    $param_nom      = $nombre;
                    $param_ema      = $email;
                    $param_pss      = $password;
                    $param_tel      = $telefono;        

                    // Ejecución de sentencia.
                    if (mysqli_stmt_execute($stmt)) {
                        // Redireccion a la pagina de inicio.
                        header("location: login.php");
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
    <title>Registro - Rekoober</title>
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">  
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Registro - Rekoober</h2>
        <p>Por favor complete este formulario para crear una cuenta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group <?php echo (!empty($rut_err))?'has-error':'';?>">
                <label>RUT</label>
                <input type="text" id="rut" name="rut" class="form-control" value="<?php echo $rut;?>">
                <span class="form-text text-danger"><?php echo $rut_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($nombre_err))?'has-error':'';?>">
                <label>Nombre completo</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo $nombre;?>">
                <span class="form-text text-danger"><?php echo $nombre_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err))?'has-error':'';?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email;?>">
                <span class="form-text text-danger"><?php echo $email_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($telefono_err))?'has-error':'';?>">
                <label>Teléfono</label>
                <input type="number" name="telefono" class="form-control" minlength="9" maxlength="9" value="<?php echo $telefono;?>">
                <span class="form-text text-danger"><?php echo $telefono_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err))?'has-error':'';?>">
                <label>Contraseña</label>
                <input type="password" name="password" minlength="6" maxlength="12" class="form-control" value="<?php echo $password;?>">
                <span class="form-text text-danger"><?php echo $password_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err))?'has-error':'';?>">
                <label>Confirmar Contraseña</label>
                <input type="password" name="confirm_password" minlength="6" maxlength="12" class="form-control" value="<?php echo $confirm_password;?>">
                <span class="form-text text-danger"><?php echo $confirm_password_err;?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Registrarme">
                <input type="reset" class="btn btn-secondary btn-block" value="Borrar">
            </div>
            <p>¿Ya tienes una cuenta? <a href="login.php">Ingresa aquí</a>.</p>
        </form>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="./js/jquery.mask.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#rut').mask('00.000.000-A');
            });
        </script>
    </div>
    <?php include('footer.php');?>
</body>
</html>