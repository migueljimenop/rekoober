<?php
ob_start();
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
$tit_lib  = $sin_lib = $idi_lib = "";
$isbn_lib = $ano_lib = $pag_lib = ""; 
$cat_lib  = $edi_lib = $aut_lib = "";
$cue_lib  = $img_lib = "";

$tit_err  = $sin_err = $idi_err = "";
$isbn_err = $ano_err = $pag_err = "";
$cat_err  = $edi_err = $aut_err = "";
$cue_err  = $img_err = "";


// Procesamientos de valores entregados en el formulario.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificamos si el isbn está vacía.
    if (empty(trim($_POST["isbn"]))) {
        $isbn_err = "Por favor ingrese el ISBN del libro.";
    } else {
        $isbn_lib = trim($_POST["isbn"]);
    }
    
    // Verificamos si el titulo está vacía.
    if (empty(trim($_POST["titulo"]))) {
        $tit_err = "Por favor ingrese el título del libro.";
    } else {
        $tit_lib = trim($_POST["titulo"]);
    }

    // Verificamos si el sinopsis está vacía.
    if (empty(trim($_POST["sinopsis"]))) {
        $sin_err = "Por favor ingrese una sinopsis del libro.";
    } else {
        $sin_lib = trim($_POST["sinopsis"]);
    }
    
    // Verificamos si el idioma está vacía.
    if (empty(trim($_POST["idioma"]))) {
        $idi_err = "Por favor ingrese el idioma del libro.";
    } else {
        $idi_lib = trim($_POST["idioma"]);
    }

    // Verificamos si el sinopsis está vacía.
    if (empty(trim($_POST["ano"]))) {
        $ano_err = "Por favor ingrese un año del libro.";
    } else {
        $ano_lib = trim($_POST["ano"]);
    }
    
    // Verificamos si el nº de páginas está vacía.
    if (empty(trim($_POST["paginas"]))) {
        $pag_err = "Por favor ingrese un nº de páginas del libro.";
    } else {
        $pag_lib = trim($_POST["paginas"]);
    }
    
    $edi_lib=$_POST['editorial'];
    $aut_lib=$_POST['autor'];
    $cat_lib=$_POST['categoria'];
    
    $cue_lib=$_POST['owner'];
    /*
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) {
            $img_err = "Error: Please select a valid file format.";
        }
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize){
            $img_err = "Error: File size is larger than the allowed limit.";
        } 
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("images/" . $filename)){
                $img_err = $filename . " is already exists.";
            } else{
                move_uploaded_file($_FILES["photo"]["tmp_name"], "images/" . $filename);
                $img_lib = "images/" . $filename;
                //echo "Your file was uploaded successfully.";
            } 
        } else{
            $img_err = "Error: Hubo un error al subir la imagen."; 
        }
    } else{
        $img_err =  "Error: " . $_FILES["photo"]["error"];
    } */
             
    // Verificación de errores antes de actualizar base de datos.
    if (empty($isbn_err) && empty($tit_err) && empty($sin_err) && empty($idi_err) &&
        empty($ano_err)  && empty($pag_err) && empty($img_err)) {

        // Preparación de datos a insertar.
        $sql = "INSERT INTO libros (isbn_lib, tit_lib, sin_lib, idi_lib, ano_lib, pag_lib, edi_lib, aut_lib, cat_lib, cue_lib) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        ////$sql = "INSERT INTO libros (isbn_lib, tit_lib, sin_lib, idi_lib, ano_lib, pag_lib, edi_lib, aut_lib, cat_lib) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //$sql_owner = "SELECT id_acc FROM cuentas WHERE rut_acc = ?";
            
            //if ($stmt = mysqli_prepare($link, $sql) && $stmt = mysqli_prepare($link, $sql_owner)) {
            if ($stmt = mysqli_prepare($link, $sql)) {
                // Vincula las variables a la declaración preparada como parámetros.
                //mysqli_stmt_bind_param($stmt, "isssiiiiii", $param_isbn, $param_tit, $param_sin, $param_idi, $param_ano, $param_pag, $param_edi, $param_aut, $param_cat);
                mysqli_stmt_bind_param($stmt, "isssiiiiii", $param_isbn, $param_tit, $param_sin, $param_idi, $param_ano, $param_pag, $param_edi, $param_aut, $param_cat, $param_cue);
                
                $param_isbn = $isbn_lib;
                $param_tit = $tit_lib;
                $param_sin = $sin_lib;
                $param_idi = $idi_lib;
                $param_ano = $ano_lib;
                $param_pag = $pag_lib;
                $param_edi = $edi_lib;
                $param_aut = $aut_lib;
                $param_cat = $cat_lib;
                $param_cue = $cue_lib;
                
                // Ejecución de sentencia.
                if (mysqli_stmt_execute($stmt)) {
                    // Redireccion a la pagina de inicio.
                    header("location: ver-libro.php");
                } else {
                    //header('location: '.$_SERVER['REQUEST_URI']);
                    header("location: agregar-libro.php");
                    //echo "Algo salió mal, por favor inténtalo de nuevo.";
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Libro - Rekoober</title>    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <?php include('header.php');?>
    <div class="container">
        <div style="padding: 20px;">
            <h2>Agregar Libro - Rekoober</h2>
            <p>Por favor, complete el registro de un libro.</p>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6 <?php echo (!empty($isbn_err))?'has-error':'';?>">
                    <label>ISBN del libro</label>
                    <input type="text" id="isbn" name="isbn" class="form-control" value="<?php echo $isbn_lib;?>" >    
                    <span class="form-text text-danger"><?php echo $isbn_err;?></span>
                </div>

                <div class="form-group col-md-6 <?php echo (!empty($tit_err))?'has-error':'';?>">
                    <label>Título del libro</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo $tit_lib;?>" >    
                    <span class="form-text text-danger"><?php echo $tit_err;?></span>
                </div>
                
                <!--<div class="form-group col-md-4 <?php echo (!empty($img_err))?'has-error':'';?>">
                    <label>Portada del libro</label>
                    <div class="custom-file">                       
                        <input type="file" name="photo" id="photo">
                        <span class="form-text text-danger"><?php echo $img_err;?></span>
                    </div>
                </div>-->
                
            </div>
                
                <div class="form-group">
                    <label for="sinopsis">Sinopsis del libro</label>
                    <textarea id="sinopsis" name="sinopsis" class="form-control" rows="2"></textarea>
                </div>
                
            <div class="form-row">
                <div class="form-group col-md-6 <?php echo (!empty($idi_err))?'has-error':'';?>">
                    <label>Idioma del libro</label>
                    <input type="text" id="idioma" name="idioma" class="form-control" value="<?php echo $idi_lib;?>" >    
                    <span class="form-text text-danger"><?php echo $idi_err;?></span>
                </div>

                <div class="form-group col-md-3 <?php echo (!empty($ano_err))?'has-error':'';?>">
                    <label>Año del libro</label>
                    <input type="number" id="ano" name="ano" class="form-control" min="1" max="3000" value="<?php echo $ano_lib;?>" >    
                    <span class="form-text text-danger"><?php echo $ano_err;?></span>
                </div>

                <div class="form-group col-md-3 <?php echo (!empty($pag_err))?'has-error':'';?>">
                    <label>Nº Páginas del libro</label>
                    <input type="number" id="paginas" name="paginas" class="form-control" min="1" max="9999" value="<?php echo $pag_lib;?>" >    
                    <span class="form-text text-danger"><?php echo $pag_err;?></span>
                    </div>
            </div>
            
            <div class="form-row">
                
                <div class="form-group col-md-4">
                <label>Editorial del libro</label>
                <select class="form-control" name="editorial" id="editorial" required="required">
                <option value="">Seleccionar editorial</option>
                <?php 
                
                require_once "config.php";
                $sql = "SELECT * from editoriales";
                $result = mysqli_query($link,$sql);

                if($result->num_rows>0){
                    //iterating only if the table is not empty
                    while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                        //Here you are iterating each row of the database
                        foreach($row as $editoriales){ ?>                                                  

                            <option value="<?php echo htmlentities($editoriales["id_edi"]);?>"><?php echo htmlentities($editoriales["nom_edi"]);?></option>

                <?php }}} ?>    
                </select>
                </div>
                
                <div class="form-group col-md-4">
                <label>Autor del libro</label>
                <select class="form-control" name="autor" id="autor" required="required">
                <option value="">Seleccionar autor</option>
                <?php 
                
                require_once "config.php";
                $sql = "SELECT * from autores";
                $result = mysqli_query($link,$sql);

                if($result->num_rows>0){
                    //iterating only if the table is not empty
                    while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                        //Here you are iterating each row of the database
                        foreach($row as $autores){ ?>                                                  

                            <option value="<?php echo htmlentities($autores["id_aut"]);?>"><?php echo htmlentities($autores["nom_aut"] . " " . $autores["ape_aut"]);?></option>

                <?php }}} ?>    
                </select>
                </div>
                
                <div class="form-group col-md-4">
                <label>Categoría del libro</label>
                <select class="form-control" name="categoria" id="categoria" required="required">
                <option value="">Seleccionar categoría</option>
                <?php 
                
                require_once "config.php";
                $estado=1;
                $sql = "SELECT * from categorias where est_cat=$estado";
                $result = mysqli_query($link,$sql);

                if($result->num_rows>0){
                    //iterating only if the table is not empty
                    while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                        //Here you are iterating each row of the database
                        foreach($row as $categorias){ ?>                                                  

                            <option value="<?php echo htmlentities($categorias["id_cat"]);?>"><?php echo htmlentities($categorias["nom_cat"]);?></option>

                <?php }}} ?>    
                </select>
                </div>                
        </div> 
                <div class="form-group">
                <?php 
                
                require_once "config.php";
                $user = $_SESSION["rut"];
                $sql_owner = "SELECT * FROM cuentas WHERE rut_acc='".$user."' ";
                //$sql_owner = "SELECT * FROM cuentas WHERE rut_acc=$user";
                $resultado = mysqli_query($link,$sql_owner);
                
                if (!$resultado) {
                    //header("location: ver-libro.php");
                    //exit;
                    echo "<script>
                    window.location.href='agregar-libro.php';
                    </script>";
                }
                
                if($resultado->num_rows>0){
                    //iterating only if the table is not empty
                    while ($filas=$resultado->fetch_all(MYSQLI_ASSOC)) {
                        //Here you are iterating each row of the database
                        foreach($filas as $cuentas){ ?>                                                  
                            <input type="hidden" id="owner" name="owner" class="form-control" value="<?php echo $cuentas["id_acc"];?>" >    
                <?php }}}?>  
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="submit" class="btn btn-primary btn-block" value="Agregar Libro">
                    </div>  
                </div>
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
<?php 
ob_end_flush();
?>
