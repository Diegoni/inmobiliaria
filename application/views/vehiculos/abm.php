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
function marcas_activas(){
    var id_categoria = $('select#id_categoria').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/vehiculos_marcas/getAjax/',
        data: { id_categoria: id_categoria },
        success: function(resp) 
        {
            $('select#id_marca').attr('disabled',false).html(resp);
            $('select#id_marca').focus();
        }
    })  
};

function modelos_activas(){
    var id_marca = $('select#id_marca').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/vehiculos_modelos/getAjax/',
        data: { id_marca: id_marca },
        success: function(resp) 
        {
            $('select#id_modelo').attr('disabled',false).html(resp);
            $('select#id_modelo').focus();
        }
    })  
};

function versiones_activas(){
    var id_modelo = $('select#id_modelo').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/vehiculos_versiones/getAjax/',
        data: { id_modelo: id_modelo },
        success: function(resp) 
        {
            $('select#id_version').attr('disabled',false).html(resp);
            $('select#id_version').focus();
        }
    })  
};


$('#calculo').keyup(function() {
    if($('#id_calculo').val() == '')
    {
        alert("Seleccione un tipo de cálculo");
        $('#id_calculo').focus();
    }else if($('#id_calculo').val() == 1)
    {
        var porcentaje = parseFloat($('#calculo').val())* parseFloat($('#precio_costo').val())/100;
        $('#precio_venta').val( parseFloat($('#precio_costo').val()) + porcentaje ); 
    }else if($('#id_calculo').val() == 2){
        $('#precio_venta').val( parseFloat($('#calculo').val())+ parseFloat($('#precio_costo').val()) );
    }    
});
</script>

