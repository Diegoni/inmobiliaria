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
$cuotas = 
'<button type="submit" class="btn btn-default pull-right" id="actualizar">
  <i class="fa fa-filter"></i> '.lang('actualizar').' '.lang('cuotas').'
</button> ';
 
$html .= getExportsButtons($cabeceras, $cuotas);

$html .= startTable($cabeceras);
$html .= endTable($cabeceras);    
$html .= setDatatables(NULL, 0, base_url().'index.php/cuotas/ajax');     
         

/*--------------------------------------------------------------------------------  
            Fin del contenido
 --------------------------------------------------------------------------------*/
 
$html .= endContent();

echo $html;
?>

<script>
$(document).ready(function() 
{
    $('#actualizar').click(function(event) {
        event.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'index.php/cuotas/actualizar/'?>",
            data: "test=1",
            success: function(){location.reload();}
        });
    });
});
    
</script>