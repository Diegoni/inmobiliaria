<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_condiciones extends MY_Controller 
{
	protected $_subject = 'vehiculos_condiciones';
    protected $_model   = 'm_vehiculos_condiciones';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['campos']   = array(
            array('condicion',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>