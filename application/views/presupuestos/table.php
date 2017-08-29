<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('presupuesto'),
    lang('fecha'),
    lang('monto'),
	lang('descuento'),
	lang('cliente'),
	lang('forma_pago'),
	lang('vendedor'),
    lang('opciones'),
);

$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Tabla
 --------------------------------------------------------------------------------*/

if($permiso_editar == 1)
{
    $html .= getExportsButtons($cabeceras, tableAdd($subjet));    
}else
{
    $html .= getExportsButtons($cabeceras);
}

$html .= startTable($cabeceras);

if($registros)
{
    foreach ($registros as $row) 
    {
    	
    	$buttons = tableButton($subjet.'/detalle_presupuesto', $row->id_presupuesto, 'fa fa-folder-open');
		$buttons .= tableButton($subjet.'/detalle', $row->id_presupuesto, 'fa fa-pencil-square-o');
		
        $registro = array(
            $row->id_presupuesto,
            formatDate($row->fecha),
    		formatImporte($row->monto),
			formatImporte($row->descuento),
			$row->cliente,
			$row->forma_pago,
			$row->vendedor,
            $buttons,
        );
        
        $html .= setTableContent($registro);    
    }
}
            
$html .= endTable($cabeceras);         
$html .= setDatatables();           

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>