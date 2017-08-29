<script>
function printDiv(divName) 
{
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>

<?php
echo startContent();
echo '<div id="printableArea">';

if($presupuestos)
{
	echo "<table class='table table-hover table-condensed'>";
				
	foreach ($presupuestos as $row) 
	{
		echo '<tr>';
		echo '<td class="active">'.lang('presupuesto').'</td>';
		echo '<th>'.$row->id_presupuesto.'</th>';
		echo '<td class="active">'.lang('fecha').'</td>';
		echo '<th>'.formatDate($row->fecha).'</th>';
		echo '<td class="active">'.lang('cliente').'</td>';
		echo '<td><a class="btn btn-default btn-xs" title="'.lang('ver').' '.lang('cliente').'" href="'.base_url().'index.php/clientes/abm/'.$row->id_cliente.'">'.$row->cliente.'</a></td>';
		echo '</tr>';		
									
		echo '<tr>';
		echo '<td class="active">'.lang('vendedor').'</td>';
		echo '<td><a class="btn btn-default btn-xs" title="'.lang('ver').' '.lang('vendedor').'" href="'.base_url().'index.php/vendedores/abm/'.$row->id_vendedor.'">'.$row->vendedor.'</a></td>';
		echo '<td class="active">'.lang('descuento').'</td>';
		echo '<th>'.formatImporte($row->descuento).'</th>';
		echo '<td class="active">'.lang('monto').'</td>';
		echo '<th>'.formatImporte($row->monto).'</th>';
		echo '</tr>';
					
		echo '<tr>';
		echo '<td class="active">'.lang('forma_pago').'</td>';
		echo '<th>'.$row->forma_pago.'</th>';
		echo '<td class="active">'.lang('condicion_pago').'</td>';
		echo '<th>'.$row->condicion_pago.'</th>';
		echo '<td class="active">'.lang('origen').'</td>';
		echo '<th>'.$row->origen.'</th>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td class="active">'.lang('fecha_entrega').'</td>';
		echo '<th>'.formatDate($row->fecha_entrega).'</th>';
		echo '<td class="active">'.lang('validez').'</td>';
		echo '<th>'.formatDate($row->validez).'</th>';
		echo '<td class="active">'.lang('envio').'</td>';
		echo '<th>'.$row->envio.'</th>';
		echo '</tr>';
		
		$monto_presupuesto = $row->monto;	                
	}
	echo '</table>';
				
	echo "<hr>";
				
	$total = 0;
				
	echo "<table class='table table-hover'>";
	
	if($llamada)
	{
		echo '<form method="post">';
		echo "<tr>";
		echo "<th colspan='2'><input type='text' name='producto' id='producto' class='form-control input-sm' placeholder='".lang('producto')."' autofocus></th>";
		echo "<th><input type='text' name='cantidad' id='cantidad' value='1' class='form-control input-sm' placeholder='".lang('cantidad')."'></th>";
		echo "<th><input type='text' name='precio' id='precio' class='form-control input-sm' placeholder='".lang('precio')."' readonly></th>";
		echo "<th><input type='text' name='monto' id='monto' class='form-control input-sm' placeholder='".lang('monto')."' readonly></th>";
		echo "<input type='hidden' name='id_producto' id='id_producto'>";
		echo "<th colspan='2'><button type='submit' class='btn btn-default form-control input-sm' id='carga_producto'>Aceptar</button></th>";
		echo "</tr>";
		echo '</form>';
	}
	
	echo "<tr>";
	echo "<th>".lang('codigo')."</th>";
	echo "<th>".lang('producto')."</th>";
	echo "<th>".lang('cantidad')."</th>";
	echo "<th>".lang('monto')."</th>";
	echo "<th>".lang('total')."</th>";
	if($llamada)
	{
		echo "<th></th>";
	}
	echo "</tr>";
	
	
	echo '<form method="post">';			
	if($detalle_presupuesto)
	{
		foreach ($detalle_presupuesto as $row_detalle) 
		{
			echo "<tr>";	
			//echo "<td><a title='ver Articulo' class='btn btn-default btn-xs' href='".base_url()."index.php/articulos/articulo_abm/read/".$row_detalle->id_producto."'>".$row_detalle->cod_proveedor."</a></td>";
			echo "<td><a title='".lang('ver').' '.lang('producto')."' class='btn btn-default btn-xs' href='".base_url()."index.php/productos/abm/".$row_detalle->id_producto."'>".$row_detalle->cod_proveedor."</a></td>";
			echo "<td>".$row_detalle->producto."</td>";
			echo "<td>".$row_detalle->cantidad."</td>";
			if($row_detalle->cantidad > 0){
				$precio = $row_detalle->precio/$row_detalle->cantidad;
			} else 
			{
				$precio = 0;
			}
			echo "<td>".formatImporte($precio)."</td>";
			$sub_total = $row_detalle->cantidad * $precio;
			$total = $total + $sub_total;
			echo "<td>".formatImporte($sub_total)."</td>";
			if($llamada)
			{
				echo "<th><button name='eliminar' value='".$row_detalle->id_renglon."' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></button></th>";
			}
			echo "</tr>";
		}
	}	
	echo '</form>';	
				
	if($interes_presupuesto)
	{
		foreach ($interes_presupuesto as $row_interes) 
		{
			echo "<tr>";	
			echo "<td>-</td>";
			echo "<td>".$row_interes->descripcion."</td>";
			echo "<td>-</td>";
			echo "<td>-</td>";
			$total = $total + $row_interes->monto;
			echo "<td>".$row_interes->monto."</td>";
			echo "</tr>";
		}
	}
				
	echo "<tr class='success'>";	
	echo "<td colspan='4'>".lang('total')."</td>";
	echo "<th>".formatImporte($total)."</th>";
	if($llamada)
	{
		echo "<td></td>";
	}
	echo "</tr>";
				
	echo "</table>";
					
	echo "<hr>";
	//echo $pie;
				
	if($row->comentario != '')
	{
		if($row->com_publico == 1)
		{
			echo '<div class="well">Comentario: '.$row->comentario."</div></div>";
		}else
		{
			echo '</div><div class="well">Comentario Privado: '.$row->comentario."</div>";
		}					
	}else
	{
		echo '</div>';
	}
}
else
{
	echo setMensaje(lang('no_registro'), 'success');
	echo '</div>';
}
			
			
if(!$llamada)
{
	echo "<a href='".base_url()."index.php/presupuestos/table/' type='button' class='btn btn-default'>".lang('presupuestos')."</a>";
}
		
if($row->id_estado != 3)
{
	?>
	<button class="btn btn-default" type="button" onclick="printDiv('printableArea')"/>
		<i class="fa fa-print"></i> Imprimir
	</button>
<?php 
	if(!$llamada)
	{
		// Presupuesto pendiente de pago
		if($row->id_forma_pago == 2)
		{
			echo '<a href="'.base_url().'index.php/ventas/interes/'.$id_presupuesto.'" class="btn btn-default" data-toggle="modal" data-target="#interesModal"/>';
			echo '<i class="fa fa-angle-up"></i> Interes';
			echo '</a>';
		}
		
		// Presupuesto pagado
		if($row->id_forma_pago == 1) 
		{
			echo '<a class="btn btn-default" data-toggle="modal" data-target="#anularModal"/>';
			echo '<i class="fa fa-trash-o"></i> Anular';
			echo '</a>';
		}
	}
} else 
{
	if($anulaciones)
	{
		foreach ($anulaciones as $row_a)
		{
			$mensaje  = "Nota de la anulación: ".$row_a->comentario."<br>";
			$mensaje .= "Fecha de la anulación: ".formatDate($row_a->date_add)."<br>";
		}
					
		echo setMensaje($mensaje, 'danger');
	}
}
?>
  			
</div>
</div>	
</div>
</div>
</body>
</html>



<!-- Modal Interes -->

<div class="modal fade" id="interesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/presupuestos/detalle_presupuesto/<?php echo $id_presupuesto?>">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">Interes</h4>
      			</div>
      			
      			<div class="modal-body">
      				<div class="form-group">
						<label class="col-sm-2 control-label">Descripcion</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="descripcion_monto" placeholder="Descripcion">
						</div>
					</div>
      				
  					<div class="form-group">
    					<label class="col-sm-2 control-label">Tipo</label>
    					<div class="col-sm-10">
      						<select class="form-control" name="interes_tipo" required>
      							<option value="porcentaje">Porcentaje %</option>
      							<option value="valor">Valor $</option>
      						</select>
    					</div>
  					</div>
  					
					<div class="form-group">
						<label class="col-sm-2 control-label">Interes</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" name="interse_monto" placeholder="Interes" required>
						</div>
					</div>
				</div>
      
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        		<button type="submit" class="btn btn-primary">Guardar</button>
	      		</div>
      		</form>
		</div>
	</div>
</div>






<div class="modal fade" id="anularModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" action="<?php echo base_url().'index.php/presupuestos/anular/'?>">				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">Anulación</h4>
      			</div>
      			
      			<div class="modal-body">
      				<label>Nota</label>
					<textarea name="nota" class="form-control" rows="6" required></textarea>
					<input name="id_presupuesto" value="<?php echo $id_presupuesto?>" type="hidden"/>
					<input name="monto" value="<?php echo $monto_presupuesto?>" type="hidden"/>
				</div>
      
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        		<button class="btn btn-danger"/>
						<i class="fa fa-trash-o"></i> Anular
					</button>
	      		</div>
      		</form>
		</div>
	</div>
</div>


<script>
/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Carga la lista de productos

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
var items_reglon	= [];

$(function() {
	$("#producto").autocomplete({
	    source: "<?php echo base_url()?>index.php/productos/getProductos",
	    minLength: 2,//search after two characters
	    select: function(event,ui){
	        porc_iva_art	= ui.item.iva;
	        item_elegido	= ui.item;
	        este			= ui.item.id;
			px_unitario		= ui.item.precio;
			
			$('#precio').val(px_unitario * ((porc_iva_art/100) + 1 ));	
			$('#id_producto').val(este);
			pos				= items_reglon.indexOf(este);
	    	
			$("#cantidad").removeAttr('disabled');
			$('#cantidad').focus();
			$('#cantidad').select();
			
			if (pos != -1) 
			{    
	        	nuevo		= false; 
				cant_cargada= $('#cant_'+este).val();
	            $('#cantidad').val(cant_cargada);
				$('#cantidad').select();
			}
		},
	    
		close: function( event, ui ) 
		{
		}
	});		
});



/*---------------------------------------------------------------------------------
----------------------------------------------------------------------------------- 

		Para cantidad

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
$("#cantidad").keyup(function( event ) {
	var cantidad = $("#cantidad").val();
	var precio = $("#precio").val();
	var monto = cantidad * precio;
	$("#monto").val(monto);
});	
	

        
$("#cantidad").keypress(function( event ) {
	if ( event.which == 13 ) {
		$("#carga_producto").click();
	}
});	





</script>



