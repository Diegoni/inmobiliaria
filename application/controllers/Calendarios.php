<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendarios extends MY_Controller 
{
	protected $_subject = 'calendarios';
    protected $_model   = 'm_calendarios';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
		$this->load->model('m_colores');
		$this->load->library('l_calendarios');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
    	$db['colores'] = $this->m_colores->getRegistros();
		                           
        $db['campos']   = array(
            array('calendario',    'onlyChar', 'required'),
            array('select',    'id_color', 'color', $db['colores']),
            array('fecha',    '', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>