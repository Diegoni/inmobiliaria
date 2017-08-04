<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_categorias extends MY_Controller 
{
	protected $_subject = 'vehiculos_categorias';
    protected $_model   = 'm_vehiculos_categorias';
    
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
            array('categoria',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>