<body class="hold-transition skin-<?php echo $this->config->item('color')?> sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
		    <!--
			<a href="<?php echo base_url().'index.php' ?>" class="logo">
			-->
			<a href="#" class="logo">
				<span class="logo-mini"><i class="fa fa-globe"></i></span>
				<?php
				$font_size = 14;
				echo '<span class="logo-lg" style="font-size: '.$font_size.'px">
				<center>
				'.$this->config->item('programa').'
				</center>
				</span>';
				?>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
	          	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	            	<span class="sr-only">Toggle navigation</span>
	          	</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown notifications-menu">
							<?php
							if(isset($alertas_user)){
								$cantidad_alertas	= count($alertas_user);
								$icon_alertas		= setSpan($cantidad_alertas, 'warning');
								$header_alertas		= 'Tienes '.$cantidad_alertas.' alertas';
								$footer_alertas		= '<a href="#" onclick="set_vistas()">'.lang('marcar_vistas').'</a>';
							}else{
								$cantidad_alertas	= 0;
								$icon_alertas		= '';
								$header_alertas		= lang('no_alertas');
								$footer_alertas		= '';
							}
							?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<?php echo $icon_alertas?>
							</a>
							<ul class="dropdown-menu">
								<li class="header"><?php echo $header_alertas?></li>
								<li>
									<ul class="menu">
										<?php
										if(isset($alertas_user)){
											foreach ($alertas_user as $row) {
												echo '<li class="alerta_li">'.$row->alerta.'</li>';
											}
										}
										?>
									</ul>
								</li>
	                  			<li class="footer"><?php echo $footer_alertas?></li>
                			</ul>
              			</li>
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="hidden-xs"><?php echo lang('usuario') ?></span>
							</a>
							<ul class="dropdown-menu bounceInRight wow" data-wow-duration="2s">
								<li class="user-header">
									<img src="<?php echo base_url().'assets/uploads/img/user.png' ?>" class="img-circle" alt="User Image">
									<p>
										<?php echo $session['usuario'] ?>
										<small><?php echo $session['nombre'].' '.$session['apellido'] ?></small>
									</p>
								</li>
		                  
								<li class="user-footer">
									<div class="text-center">
										<a href="<?php echo base_url().'index.php/Login/logout/'?>" class="btn btn-default btn-flat">
											<i class="fa fa-sign-out"></i> <?php echo lang('salir');?>
										</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		

<script>
function set_vistas(){
	$.ajax({
	 	type: 'POST',
	 	url: '<?php echo base_url(); ?>index.php/alertas/marcar_leidas/',
	 	data: { 
            id_usuario: <?php echo $session['id_usuario']; ?>
        },
	 	success: function(resp) { 
	 		if("<?php echo $this->uri->segment(2)?>" == "do_upload"){
	 			if("<?php echo $this->uri->segment(1)?>" == "Pagos_tarjetas" || "<?php echo $this->uri->segment(1)?>" == "Pagos_boletas"){
	 				window.location.href = 'upload';
	 			} else {
	 				window.location.href = 'table';
	 			}	 			
	 		}else{
	 			location.reload();
	 		}
	 	}
	});
}
</script>