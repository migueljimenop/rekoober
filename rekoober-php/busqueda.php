<?php 
// Inicializa la sesión.
session_start();

// Verificamos si está el usuario logueado, en caso que no se redirige al login.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";
$salida = '';

if(isset($_POST['buscar'])){
    $buscar = $_POST['buscar'];
    $buscar = preg_replace("#[^0-9a-z]#i","", $buscar);

    $sql = "SELECT * FROM libros WHERE tit_lib LIKE '%$buscar%' OR idi_lib LIKE '%$buscar%'";
    $result = mysqli_query($link,$sql);
    $count = mysqli_num_rows($result); 
    if ($count == 0) {
         $salida = "No hay elementos para buscar."; 
    }else{
        while ($row = mysqli_fetch_array($result)) {     
            //var_dump($row);
            $id = $row['id_lib'];
            $titulo = $row['tit_lib'];
            $salida .= '<div>' . $id . ' ' . $titulo . '</div>';
        }       
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head> 
   <meta charset="UTF-8">
    <title>Home - Rekoober</title>
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/product.css" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .koob{ font-weight: bold; font-size: 1.5em; color:#3aa935; }
        .re .er { font-weight: bold; font-size: 1.4em; color:#2a9df4; } 
    </style>
</head>
<body>
    <?php include('header.php');?>    
    
    <div class="container">   

    <hr>
    
    <?php 
        require_once "config.php";
        //$sql = "SELECT * FROM libros, cuentas, prestamos WHERE libros.cue_lib = cuentas.id_acc AND libros.cue_lib = prestamos.lib_pre AND cuentas.id_acc = prestamos.cue_pre";
        $sql = "SELECT * FROM libros A INNER JOIN cuentas B ON A.cue_lib = B.id_acc WHERE tit_lib LIKE '%$buscar%' OR idi_lib LIKE '%$buscar%'";
        //$sql = "SELECT * from libros";
        $result = mysqli_query($link,$sql);
        $cont = 0;            
        $index = 0;
        if($result->num_rows>0){
            //iterating only if the table is not empty
            while ($row=$result->fetch_all(MYSQLI_ASSOC)) {           
            foreach($row as $libros){
                if ($index%3 == 0) {
                    if ($index > 0) {
                        echo "</div>"; //col 
                        echo "</div>"; //container
                        echo "</br>";
                    }else{
                        echo "";
                    }
                    echo "<div class='container'>";
                    echo "<div class='card-deck'>";   
                } 
                ?>     
                    <div class="card"> 
                        <img class="card-img-top" src="images/portada<?php echo $cont+1;?>.jpg">
                        <div class="card-body">
                            <!--<h4 class="card-title"><?php echo htmlentities($libros["id_lib"]); ?></h4> -->
                            <h4 class="card-title"><?php echo htmlentities($libros["tit_lib"]); ?></h4>
                            <p class="card-text"><?php echo htmlentities($libros["sin_lib"]);?></p>
                            <p class="card-text">Año - <?php echo htmlentities($libros["ano_lib"]);?> | Nº Pag - <?php echo htmlentities($libros["pag_lib"]);?> </p>
                        </div>
                        <div class="bottom-wrap">
                            <a href="detalle-libro.php?id=<?php echo $libros["id_lib"]; ?>&due=<?php echo $libros["id_acc"]; ?>" class="btn btn-sm btn-primary btn-block float-right">¡Lo quiero! &#x1F49A;</a>	
                        </div> 
                        <div class="card-footer">
                            <small class="text-muted">Agregado por <?php echo htmlspecialchars($libros["nom_acc"]);?> </small>
                        </div>                        
                    </div>
                <?php $cont++; $index++; }}}else{?>
                    <div style="display: table; margin-right: auto; margin-left: auto;">
                    <div class="card" style="width: 25rem;">
                        <img class="card-img-top" src="images/sad.jpg" alt="Card image cap">
                      <div class="card-body">
                        <h4 class="card-title" style="text-align: center;">No encontramos el libro :(</h4>
                        <p class="card-text" style="text-align: center;" >Vuelve a intentarlo, pronto estará el libro que buscas :D</p>
                        <div>
                            <a href="home.php" class="btn btn-warning btn-block btn-sm">Volver</a>
                        </div>  
                      </div>
                    </div>
                    </div>
                <?php } ?>
    <hr>
    </div>            

    
    <?php include('footer.php');?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>