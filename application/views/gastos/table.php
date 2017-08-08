<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('gasto'),
    lang('vehiculo'),
    lang('monto'),
    lang('fecha'),
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
        $registro = array(
            $row->gasto,
            $row->vehiculo,
            formatImporte($row->monto),
            formatDate($row->fecha),
            tableUpd($subjet, $row->id_gasto),
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