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
        $db['inmuebles']        = $this->m_inmuebles->getRegistros('1', 'id_estado');
        $db['formas_pagos']     = $this->m_formas_pagos->getRegistros();

        $db['campos']   = array(
            array('contrato', '', 'required'),
            array('select', 'id_cliente',  'cliente', $db['clientes'], 'required'),
            array('select', 'id_inmueble',  'inmueble', $db['inmuebles'], 'required'),
            array('monto', 'onlyFloat', ''),
            array('monto_anticipo', 'onlyFloat', ''),
            array('select', 'id_forma_pago',  'forma_pago', $db['formas_pagos']),
            array('cuotas', '[999]', ''),
            array('monto_cuota','onlyFloat', 'disabled'),
            array('inicio_cuota', '[99]', ''),
            array('vencimiento_cuota', '[99]', ''),
            array('comentario', '', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>