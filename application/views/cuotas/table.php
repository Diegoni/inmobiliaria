<?php
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
$modal = 
'<button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal">
  <i class="fa fa-filter"></i> Filtros especiales
</button>';
 
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filtros</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Aplicar Filtros</button>
      </div>
    </div>
  </div>
</div>