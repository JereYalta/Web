<?php

class ControladorVentas{

	/*=============================================
	MOSTRAR TOTAL VENTAS
	=============================================*/

	public function ctrMostrarTotalVentas(){

		$tabla = "compras";

		$respuesta = ModeloVentas::mdlMostrarTotalVentas($tabla);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	static public function ctrMostrarVentas(){

		$tabla = "compras";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla);

		return $respuesta;

	}

	static public function ctrMostrarVentasporEditor($idEditor){

		$tabla = "compras";

		$respuesta = ModeloVentas::mdlMostrarVentasporEditor($tabla,$idEditor);

		return $respuesta;

	}

}