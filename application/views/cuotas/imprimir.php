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

if(isset($plantilla))
{
    if($tickets)
    {
        foreach ($tickets as $cuotas) 
        {
            $_ticket = $plantilla; 
            foreach ($cuotas as $row_cuota) 
            {
                $_ticket = str_replace ('#cliente#', $row_cuota->cliente, $_ticket);
                $_ticket = str_replace ('#inmueble#', $row_cuota->inmueble, $_ticket);
                $_ticket = str_replace ('#monto#', formatImporte($row_cuota->monto), $_ticket);
                $_ticket = str_replace ('#fecha_pago#', formatDate($row_cuota->fecha_pago), $_ticket);
            }
            $_tickets[] = $_ticket.'<hr>';
        }
    }
    
    foreach ($_tickets as $_tick) 
    {
        $html .= $_tick;
    }
}
 
$html .= endContent();

echo $html;
?>