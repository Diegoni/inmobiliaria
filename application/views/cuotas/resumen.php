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
$html .= '<select name="id_cliente" id="id_cliente" class="select2 form-control" onchange="getInmuebles()">';
$html .= setOption($clientes, 'id_cliente', 'cliente');
$html .= '</select>';
$html .= '</div>';

$html .= setLabel(lang('cuotas').' '.lang('estado'), 2);
foreach ($cuotas_estados as $row_cuota_estado) 
{
	$html .= '<div class="col-sm-1">';
	$html .= '<div class="checkbox">';
	$html .= '<label><input type="checkbox" onclick="getCuotas()" id="estado_'.$row_cuota_estado->id_estado.'" value="'.$row_cuota_estado->id_estado.'"';
	if($row_cuota_estado->id_estado == 3 || $row_cuota_estado->id_estado == 4)
	{
	    $html .= ' checked ';
	}
	$html .= '>'.$row_cuota_estado->estado.'</label>';
	$html .= '</div>';
	$html .= '</div>';
}
$html .= '</div>';

$html .= '<div class="form-group">'; 
// Inmuebles
$html .= setLabel(lang('inmueble'), 1);
$html .= '<div class="col-sm-5">';
$html .= '<select name="id_inmueble" id="id_inmueble" class="select2 form-control" onchange="getCuotas()">';
$html .= '</select>';
$html .= '</div>';

$html .= setLabel(lang('total'), 2);
$html .= '<div class="col-sm-4">';
$html .= '<input name="total" id="total" class="form-control" readonly>';
$html .= '</div>';

$html .= '</div>';
$html .= '</form>';


$html .= '<form action="'.base_url().'index.php/cuotas/setPagos/" method="post" class="form-horizontal">';
$html .='<hr>';
$html .='<div class="row">';
$html .='<div class="col-sm-12" id="div_cuotas">';
$html .= '</div>';
$html .= '</div>';
$html .= '</form>';
 
$html .= endContent();

echo $html;
?>
<script>
function getInmuebles(){
    var id_cliente = $('select#id_cliente').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/inmuebles/getInmuebles/',
        data: { id_cliente: id_cliente },
        success: function(resp) {
            $('select#id_inmueble').attr('disabled',false).html(resp);
            $('select#id_inmueble').focus();
        }
    })  
};

function getCuotas(){
    var id_inmueble = $('select#id_inmueble').val();
    var id_cliente  = $('select#id_cliente').val();
    var impaga      = 0;
    var emitida     = 0;
    var paga        = 0;
    var vencida     = 0;
    
    if ($('#estado_1').prop('checked')) { impaga = 1; };
    if ($('#estado_2').prop('checked')) { paga = 1; };
    if ($('#estado_3').prop('checked')) { vencida = 1; };
    if ($('#estado_4').prop('checked')) { emitida = 1; };
    
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/cuotas/getCuotas/',
        data: { 
            id_cliente: id_cliente, 
            id_inmueble: id_inmueble,
            impaga: impaga,
            emitida: emitida,
            paga: paga,
            vencida: vencida 
        },
        success: function(resp) {
            $('div#div_cuotas').empty();
            $('div#div_cuotas').attr('disabled',false).html(resp);
            $('div#div_cuotas').focus();
        }
    })  
};


function sumarMontos(){
    var suma = 0;
    var valor = 0;
    
    $('.montos').each(function (index, currentObject) {
        if ($(currentObject).prop('checked')){ 
           valor = $(currentObject).val();
           valor = parseFloat(valor);
           suma = suma + valor;
        };
    });
    
    $('#total').val(suma);
};
</script>
