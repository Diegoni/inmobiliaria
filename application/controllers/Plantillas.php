<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plantillas extends MY_Controller 
{
	protected $_subject = 'plantillas';
    protected $_model   = 'm_plantillas';
    
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
            array('plantilla',    'onlyChar', 'required'),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>