<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos_marcas extends MY_Controller 
{
	protected $_subject = 'productos_marcas';
    protected $_model   = 'm_productos_marcas';
    
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
            array('marca',    '', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>