<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: home.php");
    exit;
}

else{
    // Incluyendo el archivo de configuración de base de datos.
    require_once "config.php";

    // Definción en inicialización de variables.
    $id_aut = 0;

    // Procesamientos de valores entregados en el formulario.
    if (isset($_GET['id'])) {

        $id_aut = $_GET['id'];

        //$sql = "update  autores set nom_aut = (?,?) where id=:athrid";
        $sql = "delete from autores WHERE id_aut=$id_aut";
            //$sql = "UPDATE autores (nom_aut, ape_aut) VALUES (?, ?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Vincula las variables a la declaración preparada como parámetros.
                    mysqli_stmt_bind_param($stmt, "i", $param_id);

                    // Seteamos parametros
                    $param_id = $id_aut;    

                    // Ejecución de sentencia.
                    if (mysqli_stmt_execute($stmt)) {
                        // Redireccion a la pagina de inicio.
                        header("location: ver-autor.php");
                    } else {
                        echo "Algo salió mal, por favor inténtalo de nuevo.";
                    }
                }
                // Cierra sentencia.
                mysqli_stmt_close($stmt);
            // Cierra conexión.
            mysqli_close($link);
    }

?> 

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Ver Autores - Rekoober</title>    
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
        <hr />
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    Lista de Autores
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead class="thead-light">
                                <tr>
                                    <th style="text-align:center">ID</th>
                                    <th >Nombre</th>  
                                    <th >Apellido</th>
                                    <th style="text-align:center">Modificar</th>
                                    <th style="text-align:center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>

    <?php 
        require_once "config.php";

        $sql = "SELECT * from  autores";
        $result = mysqli_query($link,$sql);

        if($result->num_rows>0){
            //iterating only if the table is not empty
            while ($row=$result->fetch_all(MYSQLI_ASSOC)) {
                //Here you are iterating each row of the database
                foreach($row as $autores){ ?>                                                  
                    <tr>

                        <td style="width: 5%" class="center"><?php echo htmlentities($autores["id_aut"]);?></td>               
                        <td class="center"><?php echo htmlentities($autores["nom_aut"]);?></td>
                        <td class="center"><?php echo htmlentities($autores["ape_aut"]);?></td>
                        <td style="width: 15%" class="center">
                            <a href="editar-autor.php?id=<?php echo htmlentities($autores["id_aut"]);?>"><button class="btn btn-primary btn-sm btn-block"><i class="fa fa-edit "></i> Modificar</button>             
                        </td>
                        <td style="width: 15%"class="center">
                            <a href="ver-autor.php?id=<?php echo htmlentities($autores["id_aut"]);?>" 
                               onclick="return confirm('Estás seguro que deseas eliminar?');" >  
                               <button class="btn-block btn btn-sm btn-danger "><i class="fa fa-pencil"></i> Borrar</button>
                        </td>         
                    </tr>
    <?php }}} ?>  
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php');?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
</body>
</html>
<?php } ?>