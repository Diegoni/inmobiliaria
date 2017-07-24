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



if($estado == 2)
{
    $html .= '
    <section class="content">
        <div class="row">
            <div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Inmueble</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Contrato</a></li>
            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Cuotas</a></li>
        </ul>';
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
if($estado == 2)
{
    $html .= '<div class="tab-content">';
    $html .= '<div class="tab-pane active" id="tab_1">'; 
}        
  
$html .= '<form action="#" method="post" class="form-horizontal">';
$html .= setForm($campos, $registro_values, $registro, $id_table);
$html .= '</form>';


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
               substr($_row, 0, 4) == 'elim' ))
            {
                $html .=  '<dt>'.str_replace("_", " ", ucwords ($_row)).'</dt>';
                $html .=  '<dd>'.$_value.'</dd>';    
            }
        }
        $html .= '</dl>';
    
    }
    
    $html .= '</div>';
    $html .= '<div class="tab-pane" id="tab_3">';
    

    if($cuotas)
    {
        $_c = 1;
        
        foreach ($cuotas as $_row) 
        {
            $_cuotas = (array) $_row;
            
            foreach ($_cuotas as $_row => $_value) 
            {
                if(!(substr($_row, 0, 3) == 'id_' ||
                   substr($_row, 0, 4) == 'date' || 
                   substr($_row, 0, 4) == 'user' || 
                   substr($_row, 0, 4) == 'elim' ))
                {
                    $cabeceras[] =  '<dt>'.str_replace("_", " ", ucwords ($_row)).'</dt>';
                    $_table[] =  '<dd>'.$_value.'</dd>';    
                       
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
    
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>'; 
    $html .= '</div>';
    $html .= '</section>';
    
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
</script>
