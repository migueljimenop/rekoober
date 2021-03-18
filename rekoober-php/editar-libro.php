<?php
ob_start();
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: home.php");
    exit;
}else{
    // Incluyendo el archivo de configuración de base de datos.
    require_once "config.php";
    
    // Definción en inicialización de variables.
    $tit_lib  = $sin_lib = $idi_lib = "";
    $isbn_lib = $ano_lib = $pag_lib = ""; 
    $cat_lib  = $edi_lib = $aut_lib = "";

    $tit_err  = $sin_err = $idi_err = "";
    $isbn_err = $ano_err = $pag_err = "";
    $cat_err  = $edi_err = $aut_err = "";
    // Definción en inicialización de variables.
  
    // Procesamientos de valores entregados en el formulario.
    if (isset($_POST['update'])) {

        // Verificamos si el isbn está vacía.
        /*if (empty(trim($_POST["isbn"]))) {
            $isbn_err = "Por favor ingrese el ISBN del libro.";
        } else {
            $isbn_lib = trim($_POST["isbn"]);
        }*/

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
        
        $id_lib = intval($_GET['id']);
        
        // Verificación de errores antes de actualizar base de datos.
        if (empty($tit_err) && empty($sin_err) && empty($idi_err) &&
            empty($ano_err)  && empty($pag_err)) {
        
            $sql = "UPDATE libros SET `tit_lib` = ?, `sin_lib` = ?, `idi_lib` = ?, `ano_lib` = ?, `pag_lib` = ? WHERE `id_lib` = $id_lib";

            if ($stmt = mysqli_prepare($link, $sql)) {
                
                // Vincula las variables a la declaración preparada como parámetros.
                mysqli_stmt_bind_param($stmt, "sssii",$param_tit, $param_sin, $param_idi, $param_ano, $param_pag);

                // Seteamos parametros
                $param_tit = $tit_lib;    
                $param_sin = $sin_lib;
                $param_idi = $idi_lib;    
                $param_ano = $ano_lib;                
                $param_pag = $pag_lib;    
                
                // Ejecución de sentencia.
                if (mysqli_stmt_execute($stmt)) {
                    // Redireccion a la pagina de inicio.
                    header("location: ver-libro.php");
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
    <title>Editar Libro - Rekoober</title>    
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
            <h2>Editar Libro - Rekoober</h2>
            <p>Por favor, complete la edición de un libro.</p>
            <form role="form" method="post">

                <?php 
                require_once "config.php";
                $id = intval($_GET['id']);
                $sql = "SELECT * from libros where id_lib=$id";
                $result = mysqli_query($link,$sql);


                if($result->num_rows>0){
                    //iterating only if the table is not empty
                    while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                        //Here you are iterating each row of the database
                        foreach($row as $libros){ ?>                                                  
                            <div class="form-row">
                            <div class="form-group col-md-6 <?php echo (!empty($isbn_err))?'has-error':'';?>">
                                <label>ISBN del libro</label>
                                <input type="text" id="isbn" name="isbn" class="form-control" value="<?php echo htmlentities($libros["isbn_lib"]);?>"  disabled>    
                                <span class="form-text text-danger"><?php echo $isbn_err;?></span>
                            </div>

                            <div class="form-group col-md-6 <?php echo (!empty($tit_err))?'has-error':'';?>">
                                <label>Título del libro</label>
                                <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo htmlentities($libros["tit_lib"]);?>" >    
                                <span class="form-text text-danger"><?php echo $tit_err;?></span>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="sinopsis">Sinopsis del libro</label>
                                <textarea id="sinopsis" name="sinopsis" class="form-control" rows="2"><?php echo htmlentities($libros["sin_lib"]);?></textarea>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-6 <?php echo (!empty($idi_err))?'has-error':'';?>">
                                <label>Idioma del libro</label>
                                <input type="text" id="idioma" name="idioma" class="form-control" value="<?php echo htmlentities($libros["idi_lib"]);?>" >    
                                <span class="form-text text-danger"><?php echo $idi_err;?></span>
                            </div>               

                            <div class="form-group col-md-3 <?php echo (!empty($ano_err))?'has-error':'';?>">
                                <label>Año del libro</label>
                                <input type="number" id="ano" name="ano" class="form-control" min="1" max="3000" value="<?php echo htmlentities($libros["ano_lib"]);?>" >    
                                <span class="form-text text-danger"><?php echo $ano_err;?></span>
                            </div>

                            <div class="form-group col-md-3 <?php echo (!empty($pag_err))?'has-error':'';?>">
                                <label>Nº Páginas del libro</label>
                                <input type="number" id="paginas" name="paginas" class="form-control" min="1" max="9999" value="<?php echo htmlentities($libros["pag_lib"]);?>" >    
                                <span class="form-text text-danger"><?php echo $pag_err;?></span>
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-4">
                            <label> Editorial del libro</label>
                            <select class="form-control" name="editorial" disabled>                
                            <?php 
                            require_once "config.php";
                            $edi = $libros["edi_lib"];
                            $sql_edi = "SELECT id_edi, nom_edi from editoriales where id_edi=$edi";
                            $result_edi = mysqli_query($link,$sql_edi);
                            if($result_edi->num_rows>0){
                                //iterating only if the table is not empty
                                while ($row=$result_edi->fetch_all(MYSQLI_ASSOC)) {
                                    //Here you are iterating each row of the database
                                    foreach($row as $editoriales){ ?>                                                  
                                        <option value="<?php echo htmlentities($editoriales["id_edi"]);?>"><?php echo htmlentities($editoriales["id_edi"] ." - ".$editoriales["nom_edi"]);?></option>
                            <?php }}} ?>
                            </select>
                            </div>
                
                            <div class="form-group col-md-4">
                            <label> Autor del libro</label>
                            <select class="form-control" name="autor" disabled>                
                            <?php 
                            require_once "config.php";
                            $aut = $libros["aut_lib"];
                            $sql_aut = "SELECT id_aut, nom_aut, ape_aut from autores where id_aut=$aut";
                            $result_aut = mysqli_query($link,$sql_aut);
                            if($result_aut->num_rows>0){
                                //iterating only if the table is not empty
                                while ($row=$result_aut->fetch_all(MYSQLI_ASSOC)) {
                                    //Here you are iterating each row of the database
                                    foreach($row as $autores){ ?>                                                  
                                        <option value="<?php echo htmlentities($autores["id_aut"]);?>"><?php echo htmlentities($autores["id_aut"] ." - " . $autores["nom_aut"]. " ". $autores["ape_aut"] );?></option>
                            <?php }}} ?>
                            </select>
                            </div>
                
                            <div class="form-group col-md-4">
                            <label> Categoria del libro</label>
                            <select class="form-control" name="categoria" disabled>                
                            <?php 
                            require_once "config.php";
                            $cat = $libros["cat_lib"];
                            $sql_cat = "SELECT id_cat, nom_cat from categorias where id_cat=$cat";
                            $result_cat = mysqli_query($link,$sql_cat);
                            if($result_cat->num_rows>0){
                                //iterating only if the table is not empty
                                while ($row=$result_cat->fetch_all(MYSQLI_ASSOC)) {
                                    //Here you are iterating each row of the database
                                    foreach($row as $categorias){ ?>                                                  
                                        <option value="<?php echo htmlentities($categorias["id_cat"]);?>"><?php echo htmlentities($categorias["id_cat"] ." - " . $categorias["nom_cat"] );?></option>
                            <?php }}} ?>
                            </select>
                            </div>
                            </div>
                <?php }}}else{
                        header("location: ver-libro.php");
                        exit;       
                    } ?>    
                
                <div class="form-group">
                    <button type="submit" name="update" class="btn btn-primary btn-block">Modificar Libro </button>
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
