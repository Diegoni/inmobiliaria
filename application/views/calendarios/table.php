<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('calendario'),
    lang('opciones'),
);

$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Tabla
 --------------------------------------------------------------------------------*/

$html .= tableAdd($subjet);
$html .= '</div>';
$html .= '<div class="box-header ui-sortable-handle" style="cursor: move;">';
$html .= '<h3 class="box-title">Feriados</h3>';
$html .= '<div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">';
$html .= '</div>';
$html .= '<div id="calendar"></div>';


/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();
	
/*--------------------------------------------------------------------------------	
 --------------------------------------------------------------------------------
 			Datos Calendario
 --------------------------------------------------------------------------------
 --------------------------------------------------------------------------------*/

$calendario = new l_calendarios();

$array = array();
if($registros){
	foreach ($registros as $row) 
	{
		$array[$row->calendario] = $row->fecha;
	}	
}

$script = $calendario->script('calendar', $array);

$html .= $script;

echo $html;
?>