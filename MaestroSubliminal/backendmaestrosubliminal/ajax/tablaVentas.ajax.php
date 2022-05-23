<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaVentas{

  /*=============================================
  MOSTRAR LA TABLA DE VENTAS
  =============================================*/

  public function mostrarTabla(){
  	$idEditor=$_GET["idUsuario"];
  	// $ventas = ControladorVentas::ctrMostrarVentas();
  	$ventas=ControladorVentas::ctrMostrarVentasporEditor($idEditor);
  	if(count($ventas)>0){
  		$datosJson='{
  			"data":[';
	  		for($i=0;$i<count($ventas);$i++){
	  			/*=============================================
				TRAER PRODUCTO
				=============================================*/
				$item="id";
				$valor=$ventas[$i]["id_producto"];
				$infoProducto=ControladorProductos::ctrMostrarProductos($item,$valor);
				$imgProducto="<img class='img-thumbnail' src='".$infoProducto[0]["portada"]."' width='100px'>";
				/*=============================================
				TRAER CLIENTE
				=============================================*/
				$item2="id";
				$valor2=$ventas[$i]["id_usuario"];
				$traerCliente=ControladorUsuarios::ctrMostrarUsuarios($item2, $valor2);
				$cliente=$traerCliente["nombre"];
				/*=============================================
				TRAER FOTO CLIENTE
				=============================================*/
				if($traerCliente["foto"] != ""){
					$imgCliente = "<img class='img-circle' src='".$traerCliente["foto"]."' width='70px'>";
				}else{
					$imgCliente = "<img class='img-circle' src='vistas/img/usuarios/default/anonymous.png' width='70px'>";
				}
				/*=============================================
				TRAER EMAIL CLIENTE
				=============================================*/
				if($ventas[$i]["email"] == ""){
					$email = $traerCliente["email"];
				}else{
					$email = $ventas[$i]["email"];
				}
				/*=============================================
				TRAER PROCESO DE ENVÍO
				=============================================*/
				if($ventas[$i]["envio"] == 0 && $infoProducto[0]["tipo"] == "virtual"){
					$envio = "<button class='btn btn-info btn-xs'>Entrega inmediata</button>";
				}else if($ventas[$i]["envio"] == 0 && $infoProducto[0]["tipo"] == "fisico"){
					$envio ="<button class='btn btn-danger btn-xs btnEnvio' idVenta='".$ventas[$i]["id"]."' etapa='1'>Despachando el producto</button>";
				}else if($ventas[$i]["envio"] == 1 && $infoProducto[0]["tipo"] == "fisico"){
					$envio = "<button class='btn btn-warning btn-xs btnEnvio' idVenta='".$ventas[$i]["id"]."' etapa='2'>Enviando el producto</button>";
				}else{
					$envio = "<button class='btn btn-success btn-xs'>Producto entregado</button>";
				}
				/*=============================================
				LOGOS PAYPAL Y PAYU
				=============================================*/
				if($ventas[$i]["metodo"] == "paypal"){
					$metodo = "<img class='img-responsive' src='vistas/img/plantilla/paypal.jpg' width='300px'>";
				}else if($ventas[$i]["metodo"] == "payu"){
					$metodo = "<img class='img-responsive' src='vistas/img/plantilla/payu.jpg' width='300px'>";
				}else{
					$metodo = "GRATIS";
				}

	  			$datosJson.='[
	  				"'.($i+1).'",
	  				"'.$infoProducto[0]["titulo"].'",
	  				"'.$imgProducto.'",
	  				"'.$cliente.'",
	  				"'.$imgCliente.'",
	  				"$ '.number_format($ventas[$i]["pago"],2).'",
	  				"'.$infoProducto[0]["tipo"].'",
	  				"'.$envio.'",
	  				"'.$metodo.'",
	  				"'.$email.'",
	  				"'.$ventas[$i]["direccion"].'",
	  				"'.$ventas[$i]["pais"].'",
	  				"'.$ventas[$i]["fecha"].'"
	  			],';
	  		}
		$datosJson=substr($datosJson,0,-1);
		$datosJson.=']
		}';
		echo $datosJson;
	}
  	else{
		echo '{
			"data":[]
		}';
		return;}

  }

}

/*=============================================
ACTIVAR TABLA DE VENTAS
=============================================*/
$activar=new TablaVentas();
$activar->mostrarTabla();

