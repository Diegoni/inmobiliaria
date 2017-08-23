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
	echo "<table class='table table-hover'>";
				
	foreach ($presupuestos as $row) 
	{
		echo '<tr>';
		echo '<td class="active">'.lang('presupuesto').'</td>';
		echo '<th>'.$row->id_presupuesto.'</th>';
		echo '<td class="active">'.lang('fecha').'</td>';
		echo '<th>'.formatDate($row->fecha).'</th>';
		echo '</tr>';		
									
		echo '<tr>';
		echo '<td class="active">'.lang('cliente').'</td>';
		echo '<td><a class="btn btn-default btn-xs" title="'.lang('ver').' '.lang('cliente').'" href="'.base_url().'index.php/clientes/abm/'.$row->id_cliente.'">'.$row->cliente.'</a></td>';
		echo '<td class="active">'.lang('vendedor').'</td>';
		echo '<td><a class="btn btn-default btn-xs" title="'.lang('ver').' '.lang('vendedor').'" href="'.base_url().'index.php/vendedores/abm/'.$row->id_vendedor.'">'.$row->vendedor.'</a></td>';
		echo '</tr>';
					
		echo '<tr>';
		echo '<td class="active">'.lang('descuento').'</td>';
		echo '<th>'.formatImporte($row->descuento).'</th>';
		echo '<td class="active">'.lang('monto').'</td>';
		echo '<th>'.formatImporte($row->monto).'</th>';
		echo '</tr>';
		
		$monto_presupuesto = $row->monto;	                
	}
	echo '</table>';
				
	echo "<hr>";
				
	$total = 0;
				
	echo "<table class='table table-hover'>";
	echo "<tr>";
	echo "<th>".lang('producto')."</th>";
	echo "<th>".lang('descripcion')."</th>";
	echo "<th>".lang('cantidad')."</th>";
	echo "<th>".lang('monto')."</th>";
	echo "<th>".lang('total')."</th>";
	echo "</tr>";
				
	if($detalle_presupuesto)
	{
		foreach ($detalle_presupuesto as $row_detalle) 
		{
			echo "<tr>";	
			//echo "<td><a title='ver Articulo' class='btn btn-default btn-xs' href='".base_url()."index.php/articulos/articulo_abm/read/".$row_detalle->id_producto."'>".$row_detalle->cod_proveedor."</a></td>";
			echo "<td><a title='".lang('ver').' '.lang('producto')."' class='btn btn-default btn-xs' href='".base_url()."index.php/productos/abm/".$row_detalle->id_producto."'>".$row_detalle->cod_proveedor."</a></td>";
			//echo "<td>".$row_detalle->producto."</td>";
			echo "<td></td>";
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
			echo "</tr>";
		}
	}		
				
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
		
if($row->estado != 3)
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

