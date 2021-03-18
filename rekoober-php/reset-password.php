<?php
// Inicializamos la sesión.
session_start();

// Verificamos si está el usuario logueado, en caso que no se redirige al login.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Incluyendo el archivo de configuración de base de datos.
require_once "config.php";

// Definición e inicialización de variables.
$new_password     = $confirm_password     = "";
$new_password_err = $confirm_password_err = "";
$act_password = $act_password_err = "";

// Procesamientos de valores entregados en el formulario.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validar nueva constraseña.
	if (empty(trim($_POST["act_password"]))) {
            $act_password_err = "Por favor ingrese su contraseña actual.";
	} elseif (strlen(trim($_POST["act_password"])) < 6) {
            $act_password_err = "La contraseña al menos debe tener 6 caracteres.";
	} else {
            $act_password = trim($_POST["act_password"]);
	}
        
        // Validar nueva constraseña.
	if (empty(trim($_POST["new_password"]))) {
            $new_password_err = "Por favor ingrese una nueva contraseña.";
	} elseif (strlen(trim($_POST["new_password"])) < 6) {
            $new_password_err = "La contraseña al menos debe tener 6 caracteres.";
	} else {
            $new_password = trim($_POST["new_password"]);
	}

	// Validar confirmación de contraseña.
	if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Por favor confirme la contraseña.";
	} else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($new_password_err) && ($new_password != $confirm_password)) {
                $confirm_password_err = "Las contraseñas no coinciden.";
            }
	}
/*
        if (empty($act_password_err)){
            $sql_pss = "SELECT pss_acc FROM cuentas WHERE id_acc = ?";

            if ($stmt = mysqli_prepare($link, $sql_pss)) {
                // Vincula las variables a la declaración preparada como parámetros.
                mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

                    // Definicion de parametros.
                    $param_password = $act_password;
                    $param_id       = $_SESSION["id"];

                    // Ejecución de sentencia.
                    if (mysqli_stmt_execute($stmt)) {
                        // Contraseña actualizada. Vuelve a el login para iniciar sesión.
                        session_destroy();
                        header("location: login.php");
                        exit();
                    } else {
                        echo "Algo salió mal, por favor vuelva a intentarlo.";
                    }
            }            
        }
 */       
        
	// Verificación de errores antes de actualizar base de datos.
	if (empty($new_password_err) && empty($confirm_password_err) && empty($act_password_err)) {
		// Preparación de datos actualizados.
		$sql = "UPDATE cuentas SET `pss_acc` = ? WHERE `id_acc` = ? AND `pss_acc` = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
                    // Vincula las variables a la declaración preparada como parámetros.
                    mysqli_stmt_bind_param($stmt, "sis", $param_password, $param_id, $param_act);

			// Definicion de parametros.
			$param_password = $new_password;
			$param_id       = $_SESSION["id"];
                        $param_act      = $act_password;

			// Ejecución de sentencia.
			if (mysqli_stmt_execute($stmt)) {
                            // Contraseña actualizada. Vuelve a el login para iniciar sesión.
                            session_destroy();
                            header("location: login.php");
                            exit();
			} else {
                            echo "Algo salió mal, por favor vuelva a intentarlo.";
			}
		
                        		// Cerrar sentencia.
		mysqli_stmt_close($stmt);
                        }

	}

	// Cerrar conexión.
	mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambia tu contraseña acá</title>
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Cambia tu contraseña acá</h2>
        <p>Complete este formulario para restablecer su contraseña.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group <?php echo (!empty($act_password_err))?'has-error':'';?>">
                <label>Contraseña actual</label>
                <input type="password" name="act_password" class="form-control" value="<?php echo $act_password;?>">
                <span class="form-text text-danger"><?php echo $act_password_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_password_err))?'has-error':'';?>">
                <label>Nueva contraseña</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password;?>">
                <span class="form-text text-danger"><?php echo $new_password_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err))?'has-error':'';?>">
                <label>Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="form-text text-danger"><?php echo $confirm_password_err;?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-block btn-primary" value="Enviar">
                <a class="btn btn-block btn-secondary" href="home.php">Cancelar</a>
            </div>
        </form>
    </div>
    <?php include('footer.php');?>
</body>
</html>