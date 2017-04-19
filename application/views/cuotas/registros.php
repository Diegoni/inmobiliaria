<?php

foreach ($clientes as $row_cliente) 
{
    echo $row_cliente->cliente;
}
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('cliente'),
    lang('inmueble'),
    lang('estado'),
    lang('opciones'),
);

$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Tabla
 --------------------------------------------------------------------------------*/

 
$html .= getExportsButtons($cabeceras);

$html .= startTable($cabeceras);
$html .= endTable($cabeceras);    
$html .= setDatatables(NULL, 0, base_url().'index.php/cuotas/ajax');     
         

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>