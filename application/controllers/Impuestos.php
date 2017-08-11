<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Impuestos extends MY_Controller 
{
	protected $_subject = 'impuestos';
    protected $_model   = 'm_impuestos';
    
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
            array('impuesto',    '', 'required'),
            array('porcentaje',    '', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>