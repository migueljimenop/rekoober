<?php
// Inicializa la sesión.
session_start();

// Verificamos si está el usuario logueado, en caso que no se redirige al login.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
   <meta charset="UTF-8">
    <title>Acerca - Rekoober</title>
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/acerca.css" /> 
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css" />
    <script src="https://kit.fontawesome.com/05c75b6c3e.js" crossorigin="anonymous"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .koob{ font-weight: bold; font-size: 1.5em; color:#3aa935; }
        .re .er { font-weight: bold; font-size: 1.4em; color:#2a9df4; } 
    </style>
</head>
<body>
    <?php include('header.php');?>    
    
    <div class="container">   
        <div class="about-section paddingTB60">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="about-title clearfix">
                            <h1>Rekoober <span>ATPC</span></h1>
                            <h3>Desarrollo / Miguel Jimeno - Mariana Orellana</h3>
                            <p> <strong>Proyecto /</strong> Trabajo realizado para la asignatura Talle de Integración de Software - 2020.</p>
                            
                            <hr />
                            <div class="row">
                            <div class="col-sm-6">
                            <p><strong>Miguel Jimeno /</strong> Estudiante de Analista Programador en CFT Inacap Rancagua. Cursando último semestre de la carrera.
                                Emprendimiento propio de mantención, desarrollo y diseño en ATPC.
                            </p> 
                            <img class="center" src="images/miguel.jpeg" style=" border-radius:20px; width: 100%; height: 15vw; object-fit: cover;" alt="" />
                            <hr >
                            <div style="display: contents; margin-right: auto; margin-left: auto;">
                            <a href="https://www.facebook.com/pg/arreglotupc.chile"><i style="color:#535353;" class="fab fa-facebook-square fa-2x"></i></a>
                            <a href="https://twitter.com/miguel_jimeno"><i style="color:#535353;" class="fab fa-twitter-square fa-2x"></i></a>
                            <a href="https://www.instagram.com/arreglotupc/"><i style="color:#535353;" class="fab fa-instagram-square fa-2x"></i></a>
                            <a href="mailto:migueljimeno.p@gmail.com"><i style="color:#535353;" class="fa fa-envelope-square fa-2x"></i></a>
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>Mariana Orellana /</strong> Estudiante de Analista Programador en CFT Inacap Rancagua. Cursando último semestre de la carrera. Incursionando en YouTube con gameplays de diversos juegos. </p>
                            <img class="center" src="images/mariana.jpg" style=" border-radius:20px; width: 100%; height: 15vw; object-fit: cover;" alt="" />
                            <hr >
                            <div>
                            <a href="#"><i style="color:#535353;" class="fab fa-facebook-square fa-2x"></i></a>
                            <a href="#"><i style="color:#535353;" class="fab fa-twitter-square fa-2x"></i></a>
                            <a href="#"><i style="color:#535353;" class="fab fa-instagram-square fa-2x"></i></a>
                            <a href="#"><i style="color:#535353;" class="fa fa-envelope-square fa-2x"></i></a>    
                            </div>
                            </div>                                    
                            </div>
                        </div>
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