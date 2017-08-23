<?php
include_once('models/m_clientes.php');
include_once('models/m_vendedores.php');
include_once('models/m_formas_pagos.php');
include_once('models/m_config.php');

$m_vendedores = new m_vendedores();
$query_vendedores = $m_vendedores->getRegistros();

$m_formas_pagos = new m_formas_pagos();
$query_formas_pagos = $m_formas_pagos->getRegistros();


$m_config = new m_config();
$result = $m_config->getRegistros(1);

foreach ($result as $row) 
{
	$cantidad_inicial = $row['cantidad_inicial'];
	$empresa = $row['empresa'];
	$forma_pago_default = $row['forma_pago_default'];
}
$librerias = '../librerias/plantilla/';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $empresa ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <link rel="stylesheet" href="<?php echo $librerias ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $librerias ?>fonts/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $librerias ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo $librerias ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo $librerias ?>plugins/jQueryUI/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $librerias ?>bootstrap/css/bootstrap.css" type="text/css" />
</head>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<header class="main-header">
			<nav class="navbar navbar-static-top">
				<div class="container">
            		<div class="navbar-header">
              			<a href="../../index2.html" class="navbar-brand"><b><?php echo $empresa?></b></a>
              			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                			<i class="fa fa-bars"></i>
              			</button>
            		</div>

            
            		<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              			<ul class="nav navbar-nav">
                			<li><a href="#" class="show_hide">Cabecera <span class="sr-only">(current)</span></a></li>
                			<li><a href="#" data-toggle="modal" data-target="#modal_comentario">Comentario</a></li>
              			</ul>
            		</div>
            
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
                  			<li class="dropdown messages-menu">
                    			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      				<i class="fa fa-envelope-o"></i>
                      				<span class="label label-success">4</span>
                    			</a>
                    			<ul class="dropdown-menu">
                      				<li class="header">You have 4 messages</li>
                      				<li>
                        				<ul class="menu">
	                          				<li><!-- start message -->
	                            				<a href="#">
	                              					<div class="pull-left">
	                                					<img src="<?php echo $librerias ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
	                              					</div>
	                              
	                              					<h4>
	                                					Support Team
	                                					<small><i class="fa fa-clock-o"></i> 5 mins</small>
	                              					</h4>
	                              					<p>Why not buy a new awesome theme?</p>
	                            				</a>
	                          				</li>
	                        			</ul>
                      				</li>
                      				<li class="footer">
                      					<a href="#">See All Messages</a>
									</li>
                    			</ul>
							</li>

                  			<li class="dropdown notifications-menu">
                    			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      				<i class="fa fa-bell-o"></i>
                      				<span class="label label-warning">10</span>
                    			</a>
                    			<ul class="dropdown-menu">
                      				<li class="header">You have 10 notifications</li>
                      				<li>
                        				<ul class="menu">
                          					<li>
                            					<a href="#">
                              						<i class="fa fa-users text-aqua"></i> 5 new members joined today
                            					</a>
                          					</li>
                        				</ul>
                      				</li>
                      				<li class="footer">
                      					<a href="#">View all</a>
									</li>
								</ul>
                  			</li>
                		</ul>
              		</div>
          		</div>
        	</nav>
		</header>
      
		<div class="content-wrapper">
        	<div class="container">
          		<section class="content">
		          	<div class="box box-default slidingDiv">
		          		<div class="box-body">
		        			<div class="row" id="cont_datos_buscador">
		        				<div class="col-md-7">
			                		<div class="form-group">
			                			<label class="control-label">Cliente</label>
			                    		<div class="input-group">
							    			<input class="data_cliente form-control input-sm" type="text" id="carga_cliente" placeholder="Alias o Cuil/Cuit"/>
							    			<div class="input-group-btn">
							      				<button onclick="limpia_cli()" class="btn btn-danger form-control input-sm" id="search" name="search">
							                    	<i class="glyphicon glyphicon-remove"></i>
							                    </button>
							    			</div>
							    			<div class="input-group-btn">
							      				<button class="btn btn-default form-control input-sm" data-toggle="modal" data-target="#modal_cliente">
							                    	<i class="fa fa-info-circle" aria-hidden="true"></i>
							                    </button>
							    			</div>
							  			</div>
							  		</div>
						  		</div>
						  		<div class="cont_rotulo_presupuesto form-group col-md-2">
				                	<label class="control-label">Fecha</label>
				                    <input class="data_presupuesto form-control input-sm" type="text" id="fecha_presupuesto" value="<?php echo date('d-m-Y')?>"/>
				                </div>
		                
				                <div class="cont_rotulo_presupuesto form-group col-md-3">
				                	<label class="control-label">Forma Pago</label>
				                    <select class='form-control input-sm' name="forma_pago" id="forma_pago">
				                    	<?php
		                            	if($query_formas_pagos)
		                            	{
		                                	foreach ($query_formas_pagos as $row_pagos) 
		                                	{
		                                		if($row_pagos['id_forma_pago'] == $forma_pago_default)
		                                		{
		                                			echo "<option value=".$row_pagos['id_forma_pago']." selected> ".$row_pagos['forma_pago']."</option>";
		                                		}else
		                                		{
		                                			echo "<option value=".$row_pagos['id_forma_pago']."> ".$row_pagos['forma_pago']."</option>";	
		                                		}
		                                	}
		                            	}
		                            	?>
									</select>
				                </div>
							</div>  
		             	</div>
					</div>

					<div class="box box-default">
						<div class="box-header with-border">
		                	<div id="cont_busqueda_producto">   
				                <div id="cont_busca">
				                	<form  action='' method='post'>
					                    <div class="row">
					                        <p>
					                            <div class="col-md-8">
					                                <div class="form-group">
					                                    <label class="col-sm-2 control-label">BUSCAR:</label>
					                                    <input class="form-control input-sm" type='text' placeholder="Cod o Detalle" name='country' value='' id='quickfind'/>
													</div>
					                            </div>
					                            <div class="col-md-2">
					                                <div class="form-group">
					                                    <label class="col-sm-2 control-label">Precio</label>
					                                    <input class="form-control input-sm" id="px_unitario_rapido" readonly="true"/>
					                                </div>
					                            </div>  
					                            <div class="col-md-2">
					                                <div class="form-group">
					                                    <label class="col-sm-2 control-label">Cantidad:</label>
					                                    <input class="form-control input-sm" type='number' name='cantidad' value='<?php echo $cantidad_inicial?>' id='cantidad'/>
					                                    <p><input onclick="carga(item_elegido)" type='button' id="carga_producto" hidden="hidden"/></p>
					                                </div>
					                            </div>
					                        </p>
					                    </div>  
									</form>
				                </div>
							</div>
						</div>
		              
		              	<div class="box-body">
		                	<div class="row">
		                        <label for="inputEmail3" class="col-sm-3 control-label">TOTAL</label>
		                        <label for="inputEmail3" class="col-sm-2 control-label">Total iva</label>
		                        <label for="inputEmail3" class="col-sm-2 control-label">%Desc.</label>
		                        <label for="inputEmail3" class="col-sm-2 control-label">Vendedor</label>
		                    </div>  
		                    <div id="totales_de_factura" class="row">
		                        <div id="cont_fac" class="col-sm-3">
		                            <input type='number' class='form-control' disabled value='0' id='total_presupuesto'style="background-color: #5cb85c; color: #fff;"/>
		                        </div>
		                        <div class="col-sm-2">
		                            <input type='number'  disabled value='0' id='total_iva' class='form-control'/>
		                        </div>
		                        <div class="col-sm-2">
		                            <input onchange="descuento()" type='number' autocomplete="off" value='0' disabled="disabled" id='descuento' min="0" max="100" class='form-control'/>
		                        </div>
		                        
		                        <div class="col-sm-2">
		                            <select name="vendedor" id="vendedor" class="form-control input-sm" autocomplete onchange="$('#quickfind').focus()">
		                            <?php
		                            if($query_vendedores)
		                            {
		                                foreach ($query_vendedores as $row_vendedor) 
		                                {
		                                    echo "<option value=".$row_vendedor['id_vendedor']."> ".$row_vendedor['vendedor']."</option>";
		                                }
		                            }
		                            ?>
		                            </select>
		                        </div>
		                        <div class="col-sm-3">
		                            <button id="cont_boton" onclick="carga_presupuesto()" hidden="true" class="btn btn-primary form-control input-sm">CARGAR PRESUPUESTO</button>
		                        </div>                    
		                    </div>
		                    <hr>
		                    <div id="reglon_factura" class="row">   
		                        <span class="titulo_item_reglon col-sm-5"><b>DETALLE</b></span>
		                        <span class="titulo_cant_item_reglon col-sm-1"><b>CANT</b></span>
		                        <span class="titulo_px_item_reglon col-sm-1"><b>P.U </b></span>
		                        <span class="titulo_px_item_reglon col-sm-1"><b>IVA</b></span>
		                        <span class="col-sm-1"><b>% IVA</b></span>
		                        <span class="titulo_px_reglon col-sm-1"><b>SUBTOTAL</b></span>
		                        <span class="col-sm-1"></span>
		                    </div>
		              	</div>
					</div>
				</section>
			</div>
		</div>
		
		<footer class="main-footer">
        	<div class="container">
          		<div class="pull-right hidden-xs">
            		<b>Version</b> 2.0.0
          		</div>
          		<strong>Consultas <a href="mailto:diego_nieto_1@hotmail.com">diego_nieto_1@hotmail.com</a>.</strong>
			</div>
		</footer>
	</div>

    <script src="<?php echo $librerias ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo $librerias ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $librerias ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $librerias ?>plugins/fastclick/fastclick.min.js"></script>
    <script src="<?php echo $librerias ?>dist/js/app.min.js"></script>
    <script src="<?php echo $librerias ?>dist/js/demo.js"></script>
    <script src="<?php echo $librerias ?>plugins/jQueryUI/jquery-ui.js"></script>      
	<script src="js/buscador.js"></script> 
</body>
</html>



        
<!--------------------------------------------------------------------------------------------------    
----------------------------------------------------------------------------------------------------
        
        Modal Comentario
            
----------------------------------------------------------------------------------------------------    
---------------------------------------------------------------------------------------------------> 
        
	<div class="modal fade" id="modal_comentario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
				<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">Comentario</h4>
      			</div>
		      	<div class="modal-body">
		        	<textarea class="form-control input-sm" rows="3" id="comentario" name="comentario"></textarea>
		        	<div class="checkbox">
						<label>
							<input type="checkbox" value="" id="com_publico" name="com_publico">
					    	Publico
						</label>
					</div>
		      	</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal" id="cancel_comentario">Cancelar</button>
        			<button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
	
	<div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
				<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">Datos Cliente</h4>
      			</div>
		      	<div class="modal-body">
		        	<div class="row" id="cont_datos_cliente">
						<div class="form-group">
    						<label class="control-label col-sm-4" for="cuit_cliente">Cuit Cliente:</label>
    						<div class="col-sm-8">
      							<input type="text" class="form-control" id="cuit_cliente" disabled/>
    						</div>
  						</div>
  						<div class="form-group">
    						<label class="control-label col-sm-4" for="calle">Calle:</label>
    						<div class="col-sm-8">
      							<input type="text" class="form-control" id="calle" disabled/>
    						</div>
  						</div>
  						<div class="form-group">
    						<label class="control-label col-sm-4" for="calle_numero">Calle nro:</label>
    						<div class="col-sm-8">
      							<input type="text" class="form-control" id="calle_numero" disabled/>
    						</div>
  						</div>
  						<div class="form-group">
    						<label class="control-label col-sm-4" for="telefono">Telefono:</label>
    						<div class="col-sm-8">
      							<input type="text" class="form-control" id="telefono" disabled/>
    						</div>
  						</div>
  						
  					</div>
  					<input type="hidden" id="id_cliente" name="id_cliente">
		      	</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal" id="cancel_comentario">Cerrar</button>
      			</div>
    		</div>
  		</div>
	</div>
	
							

<script>
$(document).ready(function(){
	 $("#cancel_comentario").click(function() {
  		 $('#comentario').val('');
	});
});
</script>



<script>
$(document).ready(function(){
    $(".slidingDiv").hide();
    $(".show_hide").show();
 
    $('.show_hide').click(function(){
        $(".slidingDiv").slideToggle();
    });
});

$(document).ready(function(){
	 $("#cancel_comentario").click(function() {
  		 $('#comentario').val('');
	});
});
</script>
