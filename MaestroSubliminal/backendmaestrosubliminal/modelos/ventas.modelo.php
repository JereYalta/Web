<?php

require_once "conexion.php";

class ModeloVentas{

	/*=============================================
	MOSTRAR EL TOTAL DE VENTAS
	=============================================*/

	static public function mdlMostrarTotalVentas($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(pago) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function mdlMostrarVentasporEditor($tabla,$idEditor){
		if($idEditor!="admin"){ # Aquí se debe cambiar el número que se esta comparando, por el id del Administrador
			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_editor=:idEditor ORDER BY id DESC");
			$stmt->bindParam(":idEditor",$idEditor,PDO::PARAM_STR);}
		else{
			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");}
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt=null;
	}


	static public function mdlMostrarVentas($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR ENVIO VENTA
	=============================================*/

	static public function mdlActualizarVenta($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;

	}



}