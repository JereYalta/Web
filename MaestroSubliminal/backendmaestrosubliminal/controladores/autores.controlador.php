<?php

class ControladorAutores{



	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function ctrMostrarAutores($item, $valor){

		$tabla = "autores";

		$respuesta = ModeloAutores::mdlMostrarAutores($tabla, $item, $valor);

		return $respuesta;
	
	}

}