<?php
	session_start();
	include 'baseDeDatos.php';
	$obj = new baseDeDatos("172.18.0.1","root","12345","Sistemas Operativo");
	switch($_GET["tipo"]){
		case "login":
			$_SESSION["User"] = $obj->login( $_GET["User"], $_GET["Password"] ) ? $_GET["User"]:null;
		break;
		case "getInfo":
			print_r($obj->getInfo($_SESSION["User"]));
		break;
		case "updateInfo":
			$obj->updateInfo($_SESSION["User"],$_GET["nombre"],$_GET["apellidoP"],$_GET["apellidoM"],$_GET["edad"]);
		break;
		case "compra":
			$obj->compra($_SESSION["User"], $_GET["noproducto"]);
		break;
	}
?>