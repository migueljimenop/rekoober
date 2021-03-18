<?php
ob_start();
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: home.php");
    exit;
}else{
    // Incluyendo el archivo de configuración de base de datos.
    require_once "config.php";
    
    $nom_edi    = "";
    $nom_err    = "";
    // Definción en inicialización de variables.
  
    // Procesamientos de valores entregados en el formulario.
    if (isset($_POST['update'])) {

        // Verificamos si el rut está vacía.
        if (empty(trim($_POST["nom_edi"]))) {
            $nom_err = "Por favor ingrese el nombre de una editorial.";
        } else {
            $nom_edi = trim($_POST["nom_edi"]);
        }     
        
        $id_edi = intval($_GET['id']);
        
        if (empty($nom_err)) {
        
            $sql = "UPDATE editoriales SET `nom_edi` = ? WHERE `id_edi` = $id_edi";

            if ($stmt = mysqli_prepare($link, $sql)) {
                
                // Vincula las variables a la declaración preparada como parámetros.
                mysqli_stmt_bind_param($stmt, "s", $param_nom);

                // Seteamos parametros
                $param_nom = $nom_edi;    
                
                // Ejecución de sentencia.
                if (mysqli_stmt_execute($stmt)) {
                    // Redireccion a la pagina de inicio.
                    header("location: ver-editorial.php");
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
    <title>Editar Editorial - Rekoober</title>    
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
            <h2>Editar Editorial - Rekoober</h2>
            <p>Por favor, complete la edición de la editorial.</p>
            <form role="form" method="post">

                <?php 
                require_once "config.php";
                $id = intval($_GET['id']);
                $sql = "SELECT * from editoriales where id_edi=$id";
                $result = mysqli_query($link,$sql);
                $cnt=1;

                if($result->num_rows>0){
                    //iterating only if the table is not empty
                    while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                        //Here you are iterating each row of the database
                        foreach($row as $editoriales){ ?>                                                  

                        <div class="form-group <?php echo (!empty($nom_err))?'has-error':'';?>">
                            <label>Nombre de la Editorial</label>
                            <input type="text" id="nom_edi" name="nom_edi" class="form-control" value="<?php echo htmlentities($editoriales["nom_edi"]); ?>" >    
                            <span class="form-text"><?php echo $nom_err;?></span>
                        </div>

                <?php $cnt=$cnt+1;}}} else{
                        header("location: ver-editorial.php");
                        exit;       
                    } ?>    
                
                <div class="form-group">
                    <button type="submit" name="update" class="btn btn-primary btn-block">Modificar Editorial </button>
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