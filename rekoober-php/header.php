<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/main.js"></script>
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        </style>
</head>
    
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="home.php"> <img src="images/rekoober.png" width="180px" class="d-inline-block align-top" alt=""> </a>
    <div class="input-group input-group-sm col-sm">
        <form method="post" action="busqueda.php" class="input-group-sm form-inline">
        <input type="text" name="buscar" id="buscar" class="form-control mr-sm-2" placeholder="Busca el libro que quieras">
        <button class="btn btn-outline-success my-2 btn-sm my-sm-0" value="buscar" type="submit"><i class="fa fa-search"></i> Buscar</button>
        </form>
    </div>  

    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Libros
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"  href="agregar-libro.php">Agregar Libro</a>
                <a class="dropdown-item"  href="ver-libro.php">Ver Libros</a> 
            </div>
        </li> 
    </ul> 
    
    <div style="border-left:1px solid #000;height:20px"></div>   
    
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Editoriales
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"  href="agregar-editorial.php">Agregar Editorial</a>
                <a class="dropdown-item"  href="ver-editorial.php">Ver Editoriales</a> 
            </div>
        </li> 
    </ul>    
         
    <div style="border-left:1px solid #000;height:20px"></div>      
      
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Autores
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"  href="agregar-autor.php">Agregar Autor</a>
                <a class="dropdown-item"  href="ver-autor.php">Ver Autores</a> 
            </div>
        </li> 
    </ul>
      
    <div style="border-left:1px solid #000;height:20px"></div>
     <ul class="navbar-nav">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
             role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Categorias
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item"  href="agregar-categoria.php">Agregar Categoria</a>
              <a class="dropdown-item"  href="ver-categoria.php">Ver Categorias</a> 
          </div>
      </li> 
    </ul> 
      
    <div style="border-left:1px solid #000;height:20px"></div>
      
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
             role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Mi cuenta
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="mis-solicitudes.php">Mis solicitudes</a>
                <a class="dropdown-item" href="mis-prestamos.php">Mis prestamos</a>
                <!--<a class="dropdown-item" href="editar-cuenta.php">Editar cuenta</a>-->
                <a class="dropdown-item" href="reset-password.php">Cambiar contraseña</a>
                <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item">Cerrar sesión</a>
                </div>
      </li> 
      <li class="nav-item">
      <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Hola, <b><?php echo htmlspecialchars($_SESSION["nombre"]);?></b></a>
      </li> 
    </ul>     
    </nav>       
</body>
</html>



 
