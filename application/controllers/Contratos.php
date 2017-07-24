<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contratos extends MY_Controller 
{
	protected $_subject = 'contratos';
    protected $_model   = 'm_contratos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_clientes');
        $this->load->model('m_cuotas');
        $this->load->model('m_inmuebles');
        $this->load->model('m_formas_pagos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['clientes']         = $this->m_clientes->getRegistros();
        $db['formas_pagos']     = $this->m_formas_pagos->getRegistros();
        
        if($id == NULL)
        {
            $db['inmuebles']    = $this->m_inmuebles->getRegistros('1', 'id_estado');   
            
            $db['campos']   = array(
                array('contrato', '', 'required'),
                array('select', 'id_cliente',  'cliente', $db['clientes'], 'required'),
                array('select', 'id_inmueble',  'inmueble', $db['inmuebles'], 'required'),
                array('monto', 'onlyFloat', ''),
                array('monto_anticipo', 'onlyFloat', ''),
                array('select', 'id_forma_pago',  'forma_pago', $db['formas_pagos']),
                array('cuotas', 'onlyInt', 'required'),
                array('monto_cuota','onlyFloat', 'readonly'),
                array('monto_interes','onlyFloat', ''),
                array('fecha_inicio','', 'required'),
                array('inicio_cuota', '[99]', 'required'),
                array('vencimiento_cuota', '[99]', 'required'),
                array('comentario', '', ''),
            ); 
        }else
        {
            $db['inmuebles']    = $this->m_inmuebles->getRegistros();
            
            $db['campos']   = array(
                array('contrato', '', 'disabled'),
                array('select', 'id_cliente',  'cliente', $db['clientes'], 'disabled'),
                array('select', 'id_inmueble',  'inmueble', $db['inmuebles'], 'disabled'),
                array('monto', 'onlyFloat', 'disabled'),
                array('monto_anticipo', 'onlyFloat', 'disabled'),
                array('select', 'id_forma_pago',  'forma_pago', $db['formas_pagos'], 'disabled'),
                array('cuotas', 'onlyInt', 'disabled'),
                array('monto_cuota','onlyFloat', 'disabled'),
                array('monto_interes','onlyFloat', 'disabled'),
                array('fecha_inicio','', 'disabled'),
                array('inicio_cuota', '[99]', 'disabled'),
                array('vencimiento_cuota', '[99]', 'disabled'),
                array('comentario', '', 'disabled'),
            );
        }
        
        

        
        
        $this->armarAbm($id, $db);
    }

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Generacion de cuotas
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/     
    
    function afterInsert($registro, $id)
    {
        // Generacion de cuotas
        $fecha_array = explode('-', $registro['fecha_inicio']);
        $fecha_actual = $fecha_array[0].'-'.$fecha_array[1].'-'.$fecha_array[2];
        $fecha_actual = date('Y-m-j', strtotime($fecha_actual));
        
        for ($i=0 ; $i < $registro['cuotas']; $i++) 
        {
            $fecha_nueva  = strtotime( "+$i month" , strtotime($fecha_actual)) ;
            $fecha_inicio = date('Y-m-'.$registro['inicio_cuota'] , $fecha_nueva);
            $fecha_vencim = date('Y-m-'.$registro['vencimiento_cuota'] , $fecha_nueva);
            
            // Si es sabado o domingo sumamos los dias
            if(date('N', strtotime($fecha_vencim)) == 6)
            {
                $fecha_vencim = strtotime("+2 day" , strtotime( $fecha_vencim ));
                $fecha_vencim = date('Y-m-j' , $fecha_vencim);
            }else if(date('N', strtotime($fecha_vencim)) == 7)
            {
                $fecha_vencim = strtotime("+1 day" , strtotime( $fecha_vencim ));
                $fecha_vencim = date('Y-m-j' , $fecha_vencim);
            }

            $cuota = array(
                'numero'        => $i+1,
                'id_cliente'    => $registro['id_cliente'],
                'id_inmueble'   => $registro['id_inmueble'],
                'id_contrato'   => $id,
                'monto'         => $registro['monto_cuota'],
                'monto_interes' => $registro['monto_interes'],
                'fecha_inicio'  => $fecha_inicio,
                'fecha_vencimiento' => $fecha_vencim,
                'id_estado'     => '1',
            );
            
            $this->m_cuotas->insert($cuota); 
        }
        
        // Cambio de estado del inmueble
        
        $inmueble = array(
            'id_estado' => 2
        );
        
        $where = array(
            'id_inmueble' => $registro['id_inmueble']
        );
        
        $this->m_inmuebles->update($inmueble, $where); 
        
        // Retorno del array registro
        
        return $registro;
    }
}
?>