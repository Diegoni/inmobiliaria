<?php
include_once('models_/conexion.php');
include_once('models/m_clientes.php');
include_once('models/m_vendedores.php');
include_once('models/m_config.php');

$m_vendedores = new m_vendedores();
$query_vendedores = $m_vendedores->getRegistros();

$m_config = new m_config();
$result = $m_config->getRegistros(1);

foreach ($result as $row) 
{
	$cantidad_inicial = $row['cantidad_inicial'];
	$empresa = $row['empresa'];
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Top Navigation</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../librerias/plantilla/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../librerias/plantilla/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../librerias/plantilla/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" href="../librerias/plantilla/plugins/jQueryUI/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="../librerias/plantilla/bootstrap/css/bootstrap.css" type="text/css" />
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
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
	                                					<img src="../librerias/plantilla/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
         

          <!-- Main content -->
          <section class="content">
          	
          	
          	<div class="box box-default slidingDiv">
		          		<div class="box-body">
		        			<div class="row" id="cont_datos_buscador">
		                		<div class="form-group col-md-6 ">
		                			<label class="control-label">Cliente</label>
		                    		<div class="input-group">
						    			<input class="data_cliente form-control input-sm" type="text" id="carga_cliente" placeholder="Alias o Cuil/Cuit"/>
						    			<div class="input-group-btn">
						      				<button onclick="limpia_cli()" class="btn btn-danger form-control input-sm" id="search" name="search">
						                    	<i class="glyphicon glyphicon-remove"></i>
						                    </button>
						    			</div>
						  			</div>
		                		</div>
		                
		                	<!-- Aca esta el button que estabas necesitando -->
		                		<div class="form-group col-md-1">
		                			<label class="control-label"></label>
		                 		</div>
		                        
				                <div class="cont_rotulo_presupuesto form-group col-md-2">
				                	<label class="control-label">Fecha</label>
				                    <input class="data_presupuesto form-control input-sm" type="text" id="fecha_presupuesto" value=""/>
				                </div>
		                
				                <div class="cont_rotulo_presupuesto form-group col-md-3">
				                	<label class="control-label">Pago</label>
				                    <select class='form-control' name="tipo">
				                    	<option value="1">Contado</option>
				                    	<option value="1">Tarjeta</option>
				                    	<option value="1">Cuenta Corriente</option>
									</select>
				                </div>
							</div>  
		            		<div class="row" id="cont_datos_cliente">
				                <div class="cont_rotulo_cliente col-md-3">
				                    <div class="form-group">
				                        <label for="email" class="col-sm-2 control-label">Nombre</label>
				                        <input class="data_cliente form-control input-sm" disabled type="text" id="nombre_cliente" value=""/>
				                    </div>
				                </div>
		                    
				                <div class="cont_rotulo_cliente col-md-3">
				                    <div class="form-group">
				                        <label for="email" class="col-sm-2 control-label">Apellido</label>
				                        <input class="data_cliente form-control input-sm" disabled type="text" id="apellido_cliente" value=""/>
				                    </div>
				                </div>
		                    
		                    
				                <div class="cont_rotulo_cliente col-md-3">
				                    <div class="form-group">
				                        <label for="email" class="col-sm-2 control-label">Domicilio</label>
				                        <input class="data_cliente form-control input-sm" disabled type="text" id="domicilio_cliente" value=""/>
				                    </div>
				                </div>
		                
				                <div class="cont_rotulo_cliente col-md-3">
				                    <div class="form-group">
				                        <label for="email" class="col-sm-2 control-label">Cuil/Cuit</label>
				                        <input class="data_cliente form-control input-sm" type="text" disabled id="cuit_cliente" value=""/>
				                    </div>
				                </div>
		                
		                		<input hidden="hidden" type="text"  id="id_cliente" value="0"/>
		            		</div>
		             	</div>
					</div>
					
					
					
					
					<div class="box box-default">
		              <div class="box-header with-border">
		                
							<div id="cont_busqueda_articulo">   
				                <div id="cont_busca">
				                <form  action='' method='post'>
				                    <div class="row">
				                        <p>
				                            <div class="col-md-8">
				                                <div class="form-group">
				                                    <label class="col-sm-2 control-label">BUSCAR:</label>
				                                    <input class="form-control input-sm" type='text' placeholder="Cod o Detalle" name='country' value='' id='quickfind'/>
				                                    <!--<input class="form-control input-sm" type='text' placeholder="Busqueda x Codigo" name='country' value='' id='quickfind_cod'/>
				                                --></div>
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
				                                    <p><input onclick="carga(item_elegido)" type='button' id="carga_articulo" hidden="hidden"/></p>
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
		              </div><!-- /.box-body -->
					</div><!-- /.box -->
					
					
					
            
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
          </div>
          <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../librerias/plantilla/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../librerias/plantilla/bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../librerias/plantilla/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../librerias/plantilla/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../librerias/plantilla/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../librerias/plantilla/dist/js/demo.js"></script>
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


<script type="text/javascript" src="../librerias/plantilla/plugins/jQueryUI/jquery-ui.js"></script>      
<script type="text/javascript" src="js/buscador.js"></script> 
   

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
