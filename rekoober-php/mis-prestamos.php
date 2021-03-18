<?php
ob_start();
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: home.php");
    exit;
}else{
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mis Prestamos - Rekoober</title>    
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
   
    <div class="container">
        <hr />
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    Lista de Prestamos
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead class="thead-light">
                                <tr>
                                    <th >ID</th>
                                    <th >Libro</th>
                                    <th >Prestador</th>
                                    <th >Receptor</th>
                                    <th >Fecha de Prestamo</th>
                                    <th >Fecha de Retorno</th>
                                    <th >Estado</th>
                                </tr>
                            </thead>
                            <tbody>  
    
    <?php
        require_once "config.php";
        
        $sql = "select p.id_pre, l.tit_lib as tit_lib, k.nom_acc as pre_lib, c.nom_acc as nom_acc, p.fep_pre, p.fer_pre, p.est_pre from prestamos p inner join libros l on l.id_lib = p.lib_pre inner join cuentas c on c.id_acc = p.cue_pre inner join cuentas k on k.id_acc = l.cue_lib where k.id_acc = ".$_SESSION["id"]." order by p.id_pre asc";
        $result = mysqli_query($link,$sql);

        if($result->num_rows>0){
            //iterating only if the table is not empty
            while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                //Here you are iterating each row of the database
                foreach($row as $prestamos){ ?>                                                  
                    <tr>
                        <td class="center"><?php echo htmlentities($prestamos["id_pre"]);?></td>             
                        <td class="center"><?php echo htmlentities($prestamos["tit_lib"]);?></td>
                        <td class="center"><?php echo htmlentities($prestamos["pre_lib"]);?></td>
                        <td class="center"><?php echo htmlentities($prestamos["nom_acc"]);?></td>
                        <td class="center"><?php                    
                        $newDate = date("d-m-Y / H:i:s", strtotime($prestamos["fep_pre"]));
                        echo $newDate; ?></td>
                        <td class="center"><?php 
                        if (htmlentities($prestamos["fer_pre"]) == null){
                            echo 'No te han devuelto el libro.';
                        }else{
                            $retDate = date("d-m-Y / H:i:s", strtotime($prestamos["fer_pre"]));
                            echo $retDate;
                        }
                        ?></td>
                        <td class="center"><?php 
                        if (htmlentities($prestamos["est_pre"]) == 1){?>
                            <a href="#" class="btn btn-warning btn-block btn-sm disabled">En uso</a>
                        <?php }else if (htmlentities($prestamos["est_pre"]) == 2){ ?>
                            <a href="#" class="btn btn-success btn-block btn-sm disabled">Retornado</a>
                        <?php } ?></td>
                    </tr>
    <?php }}} ?>  
        
    <?php include('footer.php');?> 
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
</body>
</html>
<?php } 
ob_end_flush();
?>
