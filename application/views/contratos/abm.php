<?php
$html = setCss('plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css');
$html .= setJs('plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js');

/*--------------------------------------------------------------------------------  
            Carga de array necesarios
 --------------------------------------------------------------------------------*/ 
    
if($fields)
{
    foreach ($fields as $field) 
    {
        $registro_values[$field] = '';
    }
}
        
if($registro)
{
    foreach ($registro as $row) 
    {
        $registro_values = (array) $row;
    }
}

/*--------------------------------------------------------------------------------  
            Comienzo del contenido
 --------------------------------------------------------------------------------*/ 

$html .= startContent();

if(isset($mensaje))
{
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/ 
 
$html .= '<form action="#" method="post" class="form-horizontal">';
$html .= setForm($campos, $registro_values, $registro, $id_table);
$html .= '</form>';


/*--------------------------------------------------------------------------------  
            Fin del contenido y js
 --------------------------------------------------------------------------------*/ 
 
$html .= endContent();

echo $html;
?>

<script>
$("[data-inputmask]").inputmask();
$(".checkbox").bootstrapSwitch();
</script>

<script>
$(function() {
    $("#modificar").hide();
    
    $("#id_inmueble").change(function () 
    {
        var id_inmueble = $('select#id_inmueble').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/inmuebles/getMonto/',
            data: { id_inmueble: id_inmueble },
            success: function(resp) 
            {
                $('#monto').val(resp);
                $('#monto').focus();
            }
        })  
    });
    
    $("#monto").change(function () 
    {
        calculoCouta();
    });
    
    $("#monto_anticipo").change(function () 
    {
        calculoCouta();
    });
    
    $("#cuotas").change(function () 
    {
        calculoCouta();
    });
});

function calculoCouta()
{
    var monto = $('#monto').val();
    var monto_anticipo = $('#monto_anticipo').val();
    var cuotas = $('#cuotas').val();
    
    if(cuotas > 0)
    {
        var monto_real = monto - monto_anticipo;
        var monto_cuota = monto_real/cuotas;
        $('#monto_cuota').val(monto_cuota.toFixed(2));    
    }
}
</script>
