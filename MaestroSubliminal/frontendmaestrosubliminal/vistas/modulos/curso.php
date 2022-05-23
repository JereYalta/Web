<?php

$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();

?>

<!--=====================================
VALIDAR SESIÓN
======================================-->

<?php

if(!isset($_SESSION["validarSesion"])){

	echo '<script>window.location = "'.$url.'";</script>';

	exit();

}

?>

<!--=====================================
BREADCRUMB CURSO
======================================-->
<div class="container-fluid well well-sm">
	
	<div class="container">
		
		<div class="row">
			
			<ul class="breadcrumb fondoBreadcrumb text-uppercase">
				
				<li><a href="<?php echo $url;  ?>">INICIO</a></li>
				<li class="active pagActiva"><?php echo $rutas[0] ?></li>

			</ul>

		</div>

	</div>

</div>


<!--=====================================
TRAER CURSO
======================================-->



<div class="container-fluid infoproducto">
	
	<div class="container">
		
		<div class="row">


			<?php

if(isset($rutas[1]) && isset($rutas[2]) && isset($rutas[3])){

	$item = "id";
	$valor = $rutas[1];
	$idUsuario = $rutas[2];
	$idProducto = $rutas[3];

	$confirmarCompra = ControladorUsuarios::ctrMostrarCompras($item, $valor);

	if($confirmarCompra[0]["id_usuario"] == $idUsuario &&
	   $confirmarCompra[0]["id_usuario"] == $_SESSION["id"] &&
	   $confirmarCompra[0]["id_producto"] == $idProducto){

	   		$item = "id";
			$valor =$confirmarCompra[0]["id_producto"];
 
			$traerProducto = ControladorProductos::ctrMostrarInfoProducto($item, $valor);



 
		 echo "<center><h2>Gracias! por adquirir este producto de alta calidad</h2></center>
<hr>
		 ";

					echo '<div class="col-sm-6 col-xs-12">
							
						<iframe class="videoPresentacion" src="https://www.youtube.com/embed/'.$traerProducto["multimedia1"].'?rel=0&autoplay=0" 						width="100%" frameborder="0" allowfullscreen></iframe>  <br><br>

					

					</div>
<br>

					<div class="col-sm-6 col-xs-12"> 

						<h2 class="text-muted text-uppercase">'.$traerProducto["titulo"].'</h2>

	<p class="id_editor text-left">'.$traerProducto["id_editor"].'</p> 

<div class="container">
<button type="button" class="btn btn-info"  style="background-color:#5851db" data-toggle="modal" data-target="#exampleModalLong"><b>
INSTRUCCIONES</b>
</button>
</div>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle"></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<hr style="background-color:#f3f4f7" />
<p>
</p>
<h6>Instrucciones:</h6>
<ul>
<p>'.$traerProducto["descriProducto"].'</p>
</ul>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>				
<hr>
	

	<button class="linkProducto btn-block btn-success" >
	<a href="https://drive.google.com/uc?id='.$traerProducto["linkProducto"].'&export=download&authuser=0" ><h4 style="color:#FFFFFF";><b>Descargar este producto MP3 Alta Calidad</b></h4>
	</a>
	</button>

</div>';

	

 
 }else{

		echo '<div class="col-xs-12 text-center error404">
				               
	    		<h1><small>¡Oops!</small></h1>
	    
	    		<h2>No tienes acceso a este producto</h2>

	  	</div>';

	}

}else{

	echo '<div class="col-xs-12 text-center error404">
			               
    		<h1><small>¡Oops!</small></h1>
    
    		<h2>No tienes acceso a este producto</h2>

  	</div>';

}
?>

	
			
		</div>

	</div>

</div>

<br><br><br><br>
<!--=====================================
ARTÏCULOS RELACIONADOS
======================================-->
<div class="container-fluid productos">
	
	<div class="container">

		<div class="row">

			<div class="col-xs-12 tituloDestacado">

				<div class="col-sm-6 col-xs-12">
			
					<h1><small>PRODUCTOS RELACIONADOS</small></h1>

				</div>

				<div class="col-sm-6 col-xs-12">

				<?php

					$item = "id";
					$valor = $traerProducto["id_subcategoria"];

					$rutaArticulosDestacados = ControladorProductos::ctrMostrarSubcategorias($item, $valor);

					echo '<a href="'.$url.$rutaArticulosDestacados[0]["ruta"].'">
						
						 <span class=" verMas pull-right"><b>VER MÁS</b></span>

					</a>';

				?>

				</div>

			</div>

			<div class="clearfix"></div>

			<hr>

		</div>

		<?php

			$ordenar = "";
			$item = "id_subcategoria";
			$valor = $traerProducto["id_subcategoria"];
			$base = 0;
			$tope = 4;
			$modo = "Rand()";

			$relacionados = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);

			if(!$relacionados){

				echo '<div class="col-xs-12 error404">

					<h1><small>¡Oops!</small></h1>

					<h2>No hay productos relacionados</h2>

				</div>';

			}else{

				echo '<ul class="grid0">';

				foreach ($relacionados as $key => $value) {

				if($value["estado"] != 0){
				
					echo '<li class="col-md-3 col-sm-6 col-xs-12">

						<figure>
							
							<a href="'.$url.$value["ruta"].'" class="pixelProducto">
								
								<img src="'.$servidor.$value["portada"].'" class="img-responsive">

							</a>

						</figure>

						'.$value["id"].'

						<h4>
				
							<small>
								
								<a href="'.$url.$value["ruta"].'" class="pixelProducto">
									
									'.$value["titulo"].'<br>

									<span style="color:rgba(0,0,0,0)">-</span>';

									$fecha = date('Y-m-d');
									$fechaActual = strtotime('-30 day', strtotime($fecha));
									$fechaNueva = date('Y-m-d', $fechaActual);

									if($fechaNueva < $value["fecha"]){

										echo '<span class="label label-warning fontSize">Nuevo</span> ';

									}

									if($value["oferta"] != 0 && $value["precio"] != 0){

										echo '<span class="label label-warning fontSize">'.$value["descuentoOferta"].'% off</span>';

									}

								echo '</a>	

							</small>			

						</h4>

						<div class="col-xs-6 precio">';

						if($value["precio"] == 0){

							echo '<h2><small>GRATIS</small></h2>';

						}else{

							if($value["oferta"] != 0){

								echo '<h2>

										<small>
					
											<strong class="oferta">USD $'.$value["precio"].'</strong>

										</small>

										<small>$'.$value["precioOferta"].'</small>
									
									</h2>';

							}else{

								echo '<h2><small>USD $'.$value["precio"].'</small></h2>';

							}
							
						}
										
						echo '</div>

						<div class="col-xs-6 enlaces">
							
							<div class="btn-group pull-right">
								
								<button type="button" class="btn btn-default btn-xs deseos" idProducto="'.$value["id"].'" data-toggle="tooltip" title="Agregar a mi lista de deseos">
									
									<i class="fa fa-heart" aria-hidden="true"></i>

								</button>';

								if($value["tipo"] == "virtual" && $value["precio"] != 0){

									if($value["oferta"] != 0){

										echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value["id"].'" imagen="'.$servidor.$value["portada"].'" titulo="'.$value["titulo"].'" precio="'.$value["precioOferta"].'" tipo="'.$value["tipo"].'" peso="'.$value["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">

										<i class="fa fa-shopping-cart" aria-hidden="true"></i>

										</button>';

									}else{

										echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value["id"].'" imagen="'.$servidor.$value["portada"].'" titulo="'.$value["titulo"].'" precio="'.$value["precio"].'" tipo="'.$value["tipo"].'" peso="'.$value["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">

										<i class="fa fa-shopping-cart" aria-hidden="true"></i>

										</button>';

									}

								}

								echo '<a href="'.$url.$value["ruta"].'" class="pixelProducto">
								
									<button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">
										
										<i class="fa fa-eye" aria-hidden="true"></i>

									</button>	
								
								</a>

							</div>

						</div>

					</li>';

				}
			}

			echo '</ul>';

		}

		?>

	</div>

</div>