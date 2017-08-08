<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contratos extends MY_Controller 
{
	protected $_subject = 'contratos';
    protected $_model   = 'm_contratos';
    protected $_config  = '';
    
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
        $this->load->model('m_vehiculos');
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
        $db['_config']          = $this->_config;
        
        if($id == NULL)
        {
            $db[$this->config->item('table')] = $this->{$this->config->item('model')}->getRegistros('1', 'id_estado');
            $db['id'] = '0';   
            
            $db['campos']   = array(
                array('contrato', '', 'required'),
                array('select', 'id_cliente',  'cliente', $db['clientes'], 'required'),
                array('select', $this->config->item('id_table'),  $this->config->item('subjet'), $db[$this->config->item('table')], 'required'),
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
            $db[$this->config->item('table')]    = $this->{$this->config->item('model')}->getRegistros();
            $db['id']           = $id;
            
            $db['campos']   = array(
                array('contrato', '', 'disabled'),
                array('select', 'id_cliente',  'cliente', $db['clientes'], 'disabled'),
                array('select', $this->config->item('id_table'),  $this->config->item('subjet'), $db[$this->config->item('table')], 'disabled'),
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
                $this->config->item('id_table')   => $registro[$this->config->item('id_table')],
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
        
        $update = array(
            'id_estado' => 2
        );
        
        $where = array(
            $this->config->item('id_table') => $registro[$this->config->item('id_table')]
        );
        
        $this->{$this->config->item('model')}->update($update, $where); 
        
        // Retorno del array registro
        
        return $registro;
    }


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Borrar contratos
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/ 


    function eliminar()
    {
        $id = $this->input->post('id');
        
        $contratos = $this->model->getRegistros($id);
        
        if($contratos)
        {
            foreach ($contratos as $row) 
            {
                $id_registro = $row->{$this->config->item('id_table')};    
            }
            
            // Borramos contrato
            $this->model->delete($id);
            
            // Borramos cuotas
            $registro = array(
                'eliminado'     => 1
            );
            
            $where = array(
                'id_contrato'   => $id
            );
            
            $this->m_cuotas->update($registro, $where);
            
            // Cambio estado del inmueble
            $registro = array(
                'id_estado'     => 1
            );
            
            $where = array(
                $this->config->item('id_table')   => $id_registro, 
            );
            
            $this->{$this->config->item('model')}->update($registro, $where);
        }
        
        redirect('/contratos/table','refresh');
    }
}
?>