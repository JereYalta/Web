<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/subcategorias.controlador.php";
require_once "../modelos/subcategorias.modelo.php";

require_once "../controladores/autores.controlador.php";
require_once "../modelos/autores.modelo.php";


require_once "../controladores/cabeceras.controlador.php";
require_once "../modelos/cabeceras.modelo.php";


class TablaProductoFinal{

  /*=============================================
  MOSTRAR LA TABLA DE PRODUCTOS
  =============================================*/ 


   public function mostrarTablaProductoFinal(){	


  	$item = null;
  	$valor = null;

  	$productoFinal = ControladorProductos::ctrMostrarProductos($item, $valor);



	$datosJson = '

  		{	
  			"data":[';

	 	for($i = 0; $i < count($productoFinal)-1; $i++){

			/*=============================================
  			TRAER LAS CATEGORÍAS
  			=============================================*/

  			$item = "id";
			$valor = $productoFinal[$i]["id_categoria"];

			$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

			if($categorias["categoria"] == ""){

				$categoria = "SIN CATEGORÍA";
			
			}else{

				$categoria = $categorias["categoria"];
			}

			/*=============================================
  			TRAER LAS SUBCATEGORÍAS
  			=============================================*/

  			$item2 = "id";
			$valor2 = $productoFinal[$i]["id_subcategoria"];

			$subcategorias = ControladorSubCategorias::ctrMostrarSubCategorias($item2, $valor2);



			if($subcategorias[0]["subcategoria"] == ""){

				$subcategoria = "SIN SUBCATEGORÍA";
			
			}else{

				$subcategoria = $subcategorias[0]["subcategoria"];
			}


      

			/*=============================================
  			AGREGAR ETIQUETAS DE ESTADO
  			=============================================*/

  			if($productoFinal[$i]["estado"] == 0){

  				$colorEstado = "btn-danger";
  				$textoEstado = "Desactivado";
  				$estadoProducto = 1;

  			}else{

  				$colorEstado = "btn-success";
  				$textoEstado = "Activado";
  				$estadoProducto = 0;

  			}

  			$estado = "<button class='btn btn-xs btnActivar ".$colorEstado."' idProducto='".$productoFinal[$i]["id"]."' estadoProducto='".$estadoProducto."'>".$textoEstado."</button>";

  		
			
  			/*=============================================
			TRAER MULTIMEDIA
  			=============================================*/

  			if($productoFinal[$i]["multimedia"] != null){

  				$multimedia = json_decode($productoFinal[$i]["multimedia"],true);

  				if($multimedia[0]["foto"] != ""){

  					$vistaMultimedia = "<img src='".$multimedia[0]["foto"]."' class='img-thumbnail imgTablaMultimedia' width='100px'>";

  				}else{

  					$vistaMultimedia = "<img src='http://i3.ytimg.com/vi/".$productoFinal[$i]["multimedia"]."/hqdefault.jpg' class='img-thumbnail imgTablaMultimedia' width='100px'>";

  				}


  			}else{

  				$vistaMultimedia = "<img src='vistas/img/multimedia/default/default.jpg' class='img-thumbnail imgTablaMultimedia' width='100px'>";

  			}

  		

	  		/*=============================================
  			TRAER LAS ACCIONES
  			=============================================*/

  			$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarProductoFinal' idProducto='".$productoFinal[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProductoFinal'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProductoFinal' idProducto='".$productoFinal[$i]["id"]."' imgPrincipal='".$productoFinal[$i]["portada"]."'><i class='fa fa-times'></i></button></div>";

  			/*=============================================
  			CONSTRUIR LOS DATOS JSON
  			=============================================*/


			$datosJson .='[
					
					"'.($i+1).'",
					"'.$productoFinal[$i]["titulo"].'",
					"'.$categoria.'",
					"'.$subcategoria.'",
					"'.$estado.'",
					"'.$productoFinal[$i]["descriproducto"].'",
					"'.$productoFinal[$i]["linkproducto"].'",
			 	  	"'.$vistaMultimedia.'",
				  	"'.$acciones.'"	   

			],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .= ']

		}';

		echo $datosJson;

  }


}



/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductoFinal = new TablaProductoFinal();
$activarProductoFinal -> mostrarTablaProductoFinal();
