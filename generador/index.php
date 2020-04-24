<?php    

    include("Model/conexion.php");
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="http://localhost/generador/index.php">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
        //echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        //QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LectorQr</title>
    <?php
    include("Views/cabecera.php");
    ?>
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
    <div class="container">

        <div class="row">

             <div class="col-xs-12 col-md-4 col-lg-4 col-sm-0">


                 <form action="index.php" method="post">
                    
                    <div class="card">
                    <div class="card-header text-center">
                     MI MENÚ
                     </div>
                    <div class="card-body">

                         <div>
                        <input name="data" class="form-control" value=<?php echo ''.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'www.trij.cl').''?> >
                        <br>
                        </div>

                       <div>
                            <select name="categoria" id="categoria" class="form-control" >
                            <option >Colacion</option>
                            <option >Menú</option>
                            <option >Desuyunos</option>
                            <option >Jugos</option>
                            </select>
                            <br>
                       </div>

                        <input type="text" name="nombre" placeholder="TITULO" class="form-control" >
                        <br>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="form-control" placeholder="ingrese la descripcion de su plato..." required=""></textarea>
                        <br>
                        <input type="number" name="precio"  placeholder="ingrese el precio del almuerzo" class="form-control" required="">
                        <br>
                        <div>
                        </div>
                        <br>
                        <input type="submit" value="Generar Menu" class="btn btn-primary btn-block" name="enviar">
                
                     </div>
                    </div>

                       

                </form>
                    
               
                <br>        
            </div>


            <div class="col-md-6 col-xs-12 col-lg-6">
 <div class="card text-center" style="border-color:green" >
                <div class="card-body">
                <h5 class="card-title">Nombre del restaurant</h5>
                <h6 class="card-subtitle mb-2 text-muted">Puede escanear el codigo para provar su funcionalidad</h6>
                <img width="" height="" src=<?php echo ''.$PNG_WEB_DIR.basename($filename).''?>> 
                
                </div>
                </div>  
            </div>

                <?php

                   
                    if (isset($_POST['enviar'])) {

                            $categoria = $_POST['categoria'];
                            $nombre    = $_POST['nombre'];
                            $descripcion = $_POST['descripcion'];                          
                            $precio    = $_POST['precio'];
                            $consulta = "INSERT INTO menu (categoria,nombre,descripcion,precio) VALUES ('$categoria','$nombre','$descripcion','$precio')";
                            $ejecutar = $conexion->query($consulta);
                           

                            
                            
                    }else{


                    }

                    ?>
            
        </div>
        
    </div>
</body>
<?php
include("Views/footer.php");
?>
</html>


    