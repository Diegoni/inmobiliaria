<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos_mediciones extends MY_Controller 
{
	protected $_subject = 'productos_mediciones';
    protected $_model   = 'm_productos_mediciones';
    
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
            array('medicion',    '', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>