<?php
$html = startContent();

if(isset($mensaje)){
    $html .= setMensaje($mensaje);
}
$html .= '<form action="#" method="post" class="form-horizontal">';

$html .= '<div class="form-group">'; 
// Cliente
$html .= setLabel(lang('cliente'), 1);
$html .= '<div class="col-sm-5">';
$html .= '<select name="id_cliente" id="id_cliente" class="select2 form-control">';
$html .= setOption($clientes, 'id_cliente', 'cliente');
$html .= '</select>';
$html .= '</div>';


$html .= setLabel(lang('cuotas').' '.lang('estado'), 2);
foreach ($cuotas_estados as $row_cuota_estado) 
{
	$html .= '<div class="col-sm-1">';
	$html .= '<div class="checkbox">';
	$html .= '<label><input type="checkbox" value="'.$row_cuota_estado->id_estado.'">'.$row_cuota_estado->estado.'</label>';
	$html .= '</div>';
	$html .= '</div>';
}
$html .= '</div>';




$html .= '<div class="form-group">'; 
// Cliente
$html .= setLabel(lang('inmueble'), 1);
$html .= '<div class="col-sm-5">';
$html .= '<select name="id_inmueble" id="id_inmueble" class="select2 form-control">';
$html .= setOption($clientes, 'id_cliente', 'cliente');
$html .= '</select>';
$html .= '</div>';

$html .= setLabel(lang('total'), 2);
$html .= '<div class="col-sm-4">';
$html .= '<input name="total" id="total" class="form-control" readonly>';
$html .= '</div>';




$html .= '</div>';
$html .= '</div>';

$html .= '</form>';

$html .= endContent();

echo $html;
?>

