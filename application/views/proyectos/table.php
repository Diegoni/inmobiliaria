<?php
/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/
 
$cabeceras = array(
    lang('proyecto'),
    lang('tipo'),
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
            $row->proyecto,
            $row->tipo,
            $row->estado,
            tableUpd($subjet, $row->id_proyecto),
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