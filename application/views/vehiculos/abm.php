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



if($estado == 2 || $gastos)
{
    $html .= '
    <section class="content">
        <div class="row">
            <div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#registro" data-toggle="tab" aria-expanded="true">'.$this->config->item('subjet').'</a></li>';
    if($gastos)
    {
        $html .= '<li><a href="#gastos" data-toggle="tab" aria-expanded="true">'.lang('gastos').'</a></li>';
    }   
    
    if($estado == 2)
    {
        $html .= '<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Contrato</a></li>
                  <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Cuotas</a></li>';
    }         
            
    $html .= '</ul>';
}else{
    $html .= startContent();
}

if(isset($mensaje))
{
    $html .= setMensaje($mensaje);
}

/*--------------------------------------------------------------------------------  
            Formulario
 --------------------------------------------------------------------------------*/ 
if($estado == 2 || $gastos)
{
    $html .= '<div class="tab-content">';
    $html .= '<div class="tab-pane active" id="registro">'; 
}        
  
$html .= '<form action="#" method="post" class="form-horizontal">';
$html .= setForm($campos, $registro_values, $registro, $id_table);
$html .= '</form>';

if($this->config->item('subjet') == 'vehiculo')
{
    $_no = 'inmueble';
}else
{
    $_no = 'vehiculo';
}

/*--------------------------------------------------------------------------------  
            Datos asociados al inmueble
 --------------------------------------------------------------------------------*/ 

if($estado == 2)
{
    $html .= '</div>';
    $html .= '<div class="tab-pane" id="tab_2"> ';
    
    if($contrato)
    {
        $html .= '<dl class="dl-horizontal">';
        foreach ($contrato as $_row) 
        {
            $_contrato = (array) $_row;
        }
        
        foreach ($_contrato as $_row => $_value) 
        {
            if(!(substr($_row, 0, 3) == 'id_' ||
               substr($_row, 0, 4) == 'date' || 
               substr($_row, 0, 4) == 'user' || 
               substr($_row, 0, 4) == 'elim' ||
               $_row == $_no ))
            {
                $html .=  '<dt>'.str_replace("_", " ", ucwords ($_row)).'</dt>';
                $html .=  '<dd>'.$_value.'</dd>';    
            }
        }
        $html .= '</dl>';
    
    }
    
    $html .= '</div>';
    $html .= '<div class="tab-pane" id="tab_3">';
    
    $datos_v = array(
        'primer_vencimiento'  => 0,
        'segundo_vencimiento'  => 0,
    );
    
    
    if($cuotas)
    {
        $_c = 1;
        
        foreach ($cuotas as $_row) 
        {
            if(isset($datos_n[$_row->estado]))
            {
                $datos_n[$_row->estado] = $datos_n[$_row->estado] + 1;
            }else
            {
                $datos_n[$_row->estado] = 1;
            }
            
            if($_row->id_estado == 2)
            {
                if($_row->monto_pago == $_row->monto)
                {
                    $datos_v['primer_vencimiento'] = $datos_v['primer_vencimiento'] + 1; 
                }else
                {
                    $datos_v['segundo_vencimiento'] = $datos_v['segundo_vencimiento'] + 1;
                }
            }
             
            $_cuotas = (array) $_row;
            
            foreach ($_cuotas as $_row => $_value) 
            {
                if(!(substr($_row, 0, 3) == 'id_' ||
                   substr($_row, 0, 4) == 'date' || 
                   substr($_row, 0, 4) == 'user' || 
                   substr($_row, 0, 4) == 'elim' ||
                   $_row == $_no))
                {
                   
                    $cabeceras[] =  str_replace("_", " ", ucwords ($_row));
                    $_table[] =  $_value; 
                }
            }
            
            if($_c == 1)
            {
                $html .= startTable($cabeceras);    
                $_c = 0;
            }
            
            $html .= setTableContent($_table);    
            unset($_table);
        }

            
        $html .= endTable();         
        $html .= setDatatables();
    }
    
    $html .= '<div class="row">';
    $html .= '<div class="col-md-12">';
        
    $html .= setGraficoDiv('id_barra');
    $html .= setGraficoDiv('id_pagos');
    
    $opciones_n = array(
        'title'     => 'Estado cuotas',
        'id'        => 'id_barra',
        'type'      => '3d'
    );
    
    $opciones_v = array(
        'title'     => 'Tipo Pago',
        'id'        => 'id_pagos',
        'type'      => '3d'
    );
    
    $graficos = new Graficos();
    $html .= $graficos->torta($opciones_n, $datos_n);
    $html .= $graficos->torta($opciones_v, $datos_v);
     
    $html .= '</div>';//<div class="col-md-12">    
    $html .= '</div>';//<div class="row">
   
}

if($gastos)
{
    $html .= '</div>';
    $html .= '<div class="tab-pane" id="gastos"> ';
    $cabeceras = array(
        lang('fecha'),
        lang('gasto'),
        lang('tipo'),
        lang('monto'),
        lang('aumenta_costo'),
        lang('opciones'),
    );
    
    $html .= startTable($cabeceras, 'table-gastos');
   
    $aumenta = 0;
    $no_aumenta = 0;
    $total = 0;
    
    foreach ($gastos as $gasto) 
    {
        $_table = array(
            formatDate($gasto->fecha),
            $gasto->gasto,
            $gasto->tipo,
            formatImporte($gasto->monto),
            setSpan($gasto->aumenta_costo),
            tableUpd('Gastos', $gasto->id_gasto),
        );
        
        if($gasto->aumenta_costo == 1)
        {
            $aumenta = $aumenta + $gasto->monto;
        }else
        {
            $no_aumenta = $no_aumenta + $gasto->monto;
        }
        
        $total = $total + $gasto->monto;
        
        $html .= setTableContent($_table);
    }
    
    $html .= endTable(); 
    
    $html .= '<div class="row">
                <div class="col-md-6 col-md-offset-3">
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total gastos en costo <span class="pull-right badge bg-green">'.formatImporte($aumenta).'</span></a></li>
                    <li><a href="#">Total gastos sin costo <span class="pull-right badge bg-red">'.formatImporte($no_aumenta).'</span></a></li>
                    <li><a href="#">Total gastos <span class="pull-right badge bg-blue">'.formatImporte($total).'</span></a></li>
                  </ul>
                </div>
                </div>
                </div>';

}  

if($estado == 2 || $gastos)
{
    $html .= '</div>';//<div class="tab-pane" id="tab_3">   
    $html .= '</div>'; //<div class="nav-tabs-custom">
    $html .= '</div>'; //<div class="col-md-12">
    $html .= '</div>'; // <div class="row">
    
    $html .= '</section>'; //<section class="content">
}else{
     
    $html .= endContent();
}                   

/*--------------------------------------------------------------------------------  
            Fin del contenido y js
--------------------------------------------------------------------------------*/ 

if($estado == 2)
{
   $html .=   '<script>';
   $html .=   '$("#modificar").hide();';
   $html .=   '</script>';  
}

echo $html;
?>
                    
                   

<script>
$("[data-inputmask]").inputmask();
$(".checkbox").bootstrapSwitch();


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

</script>
