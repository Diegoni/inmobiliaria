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
 
$html .= '<form action="#" method="post" class="form-horizontal" onsubmit="return controlContrato()">';
$html .= setForm($campos, $registro_values, $registro, $id_table);
$html .= '</form>';

if($id != 0)
{
    $html .= '<center>';
    $html .= '<form action="'.base_url().'index.php/Contratos/eliminar/" method="post" class="form-horizontal">';
    $html .= '<input value="'.$id.'"  name="id" type="hidden">';
    $html .= btnDlt();
    $html .= '</form>';
    $html .= '</center>'; 
}


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
    
    $("#<?php echo $this->config->item('id_table')?>").change(function () 
    {
        var <?php echo $this->config->item('id_table')?> = $('select#<?php echo $this->config->item('id_table')?>').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/<?php echo $this->config->item('table')?>/getMonto/',
            data: { <?php echo $this->config->item('id_table')?>: <?php echo $this->config->item('id_table')?> },
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
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    
    $("#fecha_inicio").val(yyyy+"-"+mm+"-"+dd);
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

function controlContrato()
{
    var inicio_cuota = parseInt($("#inicio_cuota").val());
    var vencimiento_cuota = parseInt($("#vencimiento_cuota").val());
    var monto =  parseFloat($("#monto").val());
    var monto_cuota = parseFloat($("#monto_cuota").val());
    var monto_interes = parseFloat($("#monto_interes").val());
    var monto_anticipo = parseFloat($("#monto_anticipo").val());
    var cuotas = parseInt($("#cuotas").val());
    var error = 1;
        
    if(inicio_cuota > 30)
    {
        alert("El nro no puede superar a 30");
        $("#inicio_cuota").focus();
    }else if(vencimiento_cuota > 30)
    {
        alert("El nro no puede superar a 30");
        $("#vencimiento_cuota").focus();
    }else if(inicio_cuota > vencimiento_cuota)
    {
       alert("El inicio no puede ser mayor al vencimiento");
        $("#vencimiento_cuota").focus(); 
    }else if(monto_anticipo > monto)
    {
       alert("El anticipo no puede ser mayor a la cuota");
        $("#monto_anticipo").focus(); 
    }else if(monto_anticipo != monto && cuotas == '')
    {
       alert("Debes ingresar la cantidad de cuotas");
        $("#cuotas").focus();
    }else if(monto_cuota > monto_interes)
    {
       alert("La cuota no puede ser mayor que el interes");
        $("#monto_interes").focus(); 
     
    }else{
        error = 2;
    }
    
    if(error == 1)
    {
        $("#agregar").button('reset');
        return false;    
    }else
    {
        return true;
    }
    
}

</script>
