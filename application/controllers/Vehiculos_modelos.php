<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_modelos extends MY_Controller 
{
	protected $_subject = 'vehiculos_modelos';
    protected $_model   = 'm_vehiculos_modelos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_vehiculos_marcas');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['marcas']    = $this->m_vehiculos_marcas->getRegistros();
                                   
        $db['campos']   = array(
            array('modelo',   'onlyChar', 'required'),
            array('select',   'id_marca',  array('categoria', 'marca'), $db['marcas']),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>