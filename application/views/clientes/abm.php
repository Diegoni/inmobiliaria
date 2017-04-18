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
function provincias_activas(){
    var provincia = $('select#id_provincia').val(); //Obtenemos el id de la provincia seleccionada en la lista
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php/localidades/getLocalidades/', //Realizaremos la petición al metodo prueba del controlador direcciones
        data: { provincia: provincia }, //Pasaremos por parámetro POST el id de la provincia
        success: function(resp) { //Cuando se procese con éxito la petición se ejecutará esta función
            //Activar y Rellenar el select de departamentos
            $('select#id_localidad').attr('disabled',false).html(resp); //Con el método ".html()" incluimos el código html devuelto por AJAX en la lista de provincias
            $('select#id_localidad').focus();
        }
    })  
};
</script>
