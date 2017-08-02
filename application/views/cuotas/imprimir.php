<?php
$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}

if($plantillas)
{
    foreach ($plantillas as $row_plantilla) 
    {
        $plantilla = $row_plantilla->comentario;
    }            
}

$dias = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");


if(isset($plantilla))
{
    if(isset($tickets))
    {
        foreach ($tickets as $cuotas) 
        {
            $_ticket = $plantilla; 
            if($cuotas)
            {
                foreach ($cuotas as $row_cuota) 
                {
                    $ci =&get_instance();
                    $proyecto = $ci->m_proyectos->getProyectos($row_cuota->id_inmueble);
                    
                    if($proyecto)
                    {
                        foreach ($proyecto as $row_proyecto) 
                        {
                            $_ticket = str_replace ('#loteo#', $row_proyecto->proyecto, $_ticket);
                            $_ticket = str_replace ('#direccion_loteo#', $row_proyecto->direccion, $_ticket);
                            $_ticket = str_replace ('#localidad_loteo#', $row_proyecto->localidad, $_ticket);
                            $_ticket = str_replace ('#provincia_loteo#', $row_proyecto->provincia, $_ticket);
                            $_ticket = str_replace ('#tipo_loteo#', $row_proyecto->tipo, $_ticket);
                        }    
                    }
                    
                    //var_dump($row_cuota);
                    $_ticket = str_replace ('#dia_semana#', $dias[date("w")], $_ticket);
                    $_ticket = str_replace ('#dia#', date("d"), $_ticket);
                    $_ticket = str_replace ('#mes#', date("m"), $_ticket);
                    $_ticket = str_replace ('#ano#', date("Y"), $_ticket);
                    
                    $_ticket = str_replace ('#cliente#', $row_cuota->cliente, $_ticket);
                    $_ticket = str_replace ('#inmueble#', $row_cuota->inmueble, $_ticket);
                    $_ticket = str_replace ('#cuota_monto#', formatImporte($row_cuota->monto_pago), $_ticket);
                    $_ticket = str_replace ('#cuota_nro#', $row_cuota->numero, $_ticket);
                    $_ticket = str_replace ('#cuota_vencimiento#', formatDate($row_cuota->fecha_pago), $_ticket);
                    $_ticket = str_replace ('#lote#', $row_cuota->inmueble, $_ticket);
                }
            }
            
            $_tickets[] = $_ticket.'<hr>';
        }
    }
        
    if(isset($_tickets))
    {
        $html .= '<div class="print">';
        foreach ($_tickets as $_tick) 
        {
            $html .= $_tick;
        }
        $html .= '</div>';
        
        $html .= '<center>';
        $html .= '<button type="button" class="printer btn btn-app hide" value="Imprimir" id="imprimir">';
        $html .= '<i class="fa fa-print"></i> '.$this->lang->line('imprimir');
        $html .= '</button>';
        $html .= '<img src="'.base_url().'assets/image_crud/loading_small.gif" class="image divider" id="loading" height= "45px;" style="margin-bottom: 15px;">';       
        $html .= '</center>';
    }else
    {
        $mensaje = 'No hay cuotas para imprimir';
        $html .= setMensaje($mensaje);
    }
}
 
$html .= endContent();

echo $html;
?>


<script>
var beforeload = (new Date()).getTime();

function getPageLoadTime(){
    var afterload = (new Date()).getTime();
    seconds = (afterload-beforeload) / 1000;
    $(".printer" ).click(function() {
        $("#imprimir" ).slideUp('disabled').delay( seconds * 1000 + 300 ).fadeIn(400);
        $("#loading").fadeIn(400).delay( seconds * 1000 + 300 ).slideUp( 400 );

        $(".print").printThis({
            importStyle: true,
            printDelay: seconds * 1000 + 300
        });
    });
    
    $("#imprimir" ).removeClass('hide').fadeIn(400);
    $("#loading" ).slideUp(400);
}
window.onload = getPageLoadTime;

$(function() {
    $('#id_lote').chosen();
});
</script>

<style>
@media all {
   div.saltopagina{
      display: none;
   }
}
   
@media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
}
</style>