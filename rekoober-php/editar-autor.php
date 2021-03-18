<?php
ob_start();
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: home.php");
    exit;
}else{
    // Incluyendo el archivo de configuración de base de datos.
    require_once "config.php";
    
    $nom_aut     = $ape_aut    = "";
    $nom_err = $ape_err = "";
    // Definción en inicialización de variables.
  
    // Procesamientos de valores entregados en el formulario.
    if (isset($_POST['update'])) {

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
        
        $id_aut = intval($_GET['id']);
        
        if (empty($nom_err) && empty($ape_err)) {
        
            $sql = "UPDATE autores SET `nom_aut` = ?, `ape_aut` = ? WHERE `id_aut` = $id_aut";

            if ($stmt = mysqli_prepare($link, $sql)) {
                
                // Vincula las variables a la declaración preparada como parámetros.
                mysqli_stmt_bind_param($stmt, "ss",$param_nom, $param_ape);

                // Seteamos parametros
                $param_nom = $nom_aut;    
                $param_ape = $ape_aut;
                
                // Ejecución de sentencia.
                if (mysqli_stmt_execute($stmt)) {
                    // Redireccion a la pagina de inicio.
                    header("location: ver-autor.php");
                } else {
                    echo "Algo salió mal, por favor inténtalo de nuevo.";
                }
                // Cierra sentencia.
                mysqli_stmt_close($stmt);
            }
            // Cierra conexión.
            mysqli_close($link);
        }
    }
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Autor - Rekoober</title>    
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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
            <h2>Editar Autor - Rekoober</h2>
            <p>Por favor, complete la edición del autor.</p>
            <form role="form" method="post">

                <?php 
                require_once "config.php";
                $id = intval($_GET['id']);
                $sql = "SELECT * from autores where id_aut=$id";
                //$sql = "SELECT * from autores";
                $result = mysqli_query($link,$sql);
                $cnt=1;

                if($result->num_rows>0){
                    //iterating only if the table is not empty
                    while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                        //Here you are iterating each row of the database
                        foreach($row as $autores){ ?>                                                  

                        <div class="form-group <?php echo (!empty($nom_err))?'has-error':'';?>">
                            <label>Nombre del autor</label>
                            <input type="text" id="nom_autor" name="nom_autor" class="form-control" value="<?php echo htmlentities($autores["nom_aut"]); ?>" >    
                            <span class="form-text"><?php echo $nom_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ape_err))?'has-error':'';?>">
                            <label>Apellido del autor</label>
                            <input type="text" id="ape_autor" name="ape_autor" class="form-control" value="<?php echo htmlentities($autores["ape_aut"]); ?>" >
                            <span class="form-text"><?php echo $ape_err;?></span>
                        </div>

                <?php $cnt=$cnt+1;}}} else{
                        header("location: ver-autor.php");
                        exit;       
                    } ?>   
                
                <div class="form-group">
                    <button type="submit" name="update" class="btn btn-primary btn-block">Modificar Autor </button>
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
<?php } ?>
<?php 
ob_end_flush();
?>
