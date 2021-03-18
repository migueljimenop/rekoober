<?php
ob_start();
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: home.php");
    exit;
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalle Libro - Rekoober</title>    
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/product.css" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <?php include('header.php');?>

    <?php 
    require_once "config.php";
    $id = intval($_GET['id']);
    $due = intval($_GET['due']);
    //$sql = "select l.*, c.id_acc, c.nom_acc, cat.nom_cat, a.*, e.nom_edi "
    //        . "from libros l, autores a, cuentas c, categorias cat, editoriales e "
    //        . "where (l.cue_lib=".$due.") and (c.id_acc = ".$due.") and (l.id_lib=".$id.")";   
     
    $sql = "SELECT * FROM libros L JOIN cuentas C ON L.cue_lib = C.id_acc JOIN autores A ON L.aut_lib = A.id_aut JOIN editoriales E ON E.id_edi = L.edi_lib JOIN categorias K ON K.id_cat = L.cat_lib WHERE C.id_acc = ".$due." AND L.id_lib = ".$id." AND C.id_acc = L.cue_lib";
    //$sql =  "select l.*, c.id_acc, c.nom_acc, cat.nom_cat, a.*, e.nom_edi "
    //        . "from libros l, autores a, cuentas c, categorias cat, editoriales e "
    //        . "where (c.id_acc = ".$due.") and (l.id_lib=".$id.")";
    
    
    $result = mysqli_query($link,$sql);
    
    if($result->num_rows>0){
        while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
            foreach($row as $libros){ ?>         
                <div class="container">
                <hr>
                <div class="row">
                <div class="col-4">
                <div class="card-deck">
                    <div class="card">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-75" style="margin: auto;" src="images/portada<?php echo htmlentities($libros["id_lib"]);?>.jpg" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-75" style="margin: auto;" src="images/portada<?php echo htmlentities($libros["id_lib"]);?>.jpg" alt="Second slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" style="background-color: #b9bbbe;" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" style="background-color: #b9bbbe;" aria-hidden="true"></span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </div>                           
                        <div class="card-footer">
                            <small class="text-muted">Agregado por <?php echo htmlspecialchars($libros["nom_acc"]);?> </small>
                        </div> 
                    </div>  
                </div>
                </div>
                <div class="col-8">
                <div class="card-deck">
                    <div class="card"> 
                       <div class="card-body">
                           <h4 class="card-title"><?php echo htmlentities($libros["tit_lib"]);?></h4>
                           <small class="card-text"><?php echo htmlentities("ISBN: " . $libros["isbn_lib"]);?></small>
                           <hr>
                           <h6 class="card-title"><?php echo htmlentities("Sinopsis: " . $libros["sin_lib"]);?></h6>
                           <hr>
                           <p class="card-text"><?php echo htmlentities("Idioma: " . $libros["idi_lib"]);?></p>
                           <p class="card-text"><?php echo htmlentities("Año: " . $libros["ano_lib"]);?></p>
                           <p class="card-text"><?php echo htmlentities("Nº Páginas: " . $libros["pag_lib"]);?></p>
                           <p class="card-text"><?php echo htmlentities("Editorial: " . $libros["nom_edi"]);?></p>
                           <p class="card-text"><?php echo htmlentities("Autor: " . $libros["nom_aut"] ." ". $libros["ape_aut"]);?></p>
                           <p class="card-text"><?php echo htmlentities("Categoría: " . $libros["nom_cat"]);?></p>
                       </div>
                       <div class="bottom-wrap">                          
                           <a href="solicitud-libro.php?id=<?php echo $libros["id_lib"]; ?>&due=<?php echo $libros["id_acc"]; ?>" class="btn btn-sm btn-primary btn-block float-right">¡Solicitar! &#x1F49A;</a>	
                       </div>                       
                   </div>           
                </div>            
                </div>
                </div>
                </div>
    <?php }}}else{
            header("location: home.php");
            exit;       
        } ?> 
    <?php include('footer.php');?> 
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
</body>
</html>
<?php 
ob_end_flush();
?>
