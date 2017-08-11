<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colores extends MY_Controller 
{
	protected $_subject = 'colores';
    protected $_model   = 'm_colores';
    
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
            array('color',    'onlyChar', 'required'),
            array('background_color',    '', 'required'),
            array('border_color',    '', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>