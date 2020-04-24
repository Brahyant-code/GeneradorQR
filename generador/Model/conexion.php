<?php

$servidor="localhost";
$usuario="root";
$contraseña="";
$base_de_datos="base_de_datos";

$conexion=mysqli_connect($servidor,$usuario,$contraseña,$base_de_datos);





if (!$conexion) {
	echo "error de conexion ";
}
else{
	echo "";
}


?>