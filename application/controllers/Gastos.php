<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gastos extends MY_Controller 
{
	protected $_subject = 'gastos';
    protected $_model   = 'm_gastos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');
        $this->load->model('m_vehiculos');  
        $this->load->model('m_gastos_tipos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['vehiculos']    = $this->m_vehiculos->getRegistros();
        $db['tipos']        = $this->m_gastos_tipos->getRegistros();
                                   
        $db['campos']   = array(
            array('gasto',    'onlyChar', 'required'),
            array('select',   'id_vehiculo',  'vehiculo', $db['vehiculos']),
            array('select',   'id_tipo',  'tipo', $db['tipos']),
            array('fecha',    '', 'required'),            
            array('monto',    'onlyFloat', 'required'),
            array('checkbox', 'aumenta_costo'),
        );
        
        $this->armarAbm($id, $db);
    }

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Acualizar el costo del vehiculo despues de insert
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  
    
    
   function afterInsert($registro)
   {
       $this->m_vehiculos->actualizarCostos($registro['id_vehiculo']);
   }
   
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Acualizar el costo del vehiculo despues de update
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  
    
    
   function afterUpdate($registro)
   {
       $this->m_vehiculos->actualizarCostos($registro['id_vehiculo']);
   }
}
?>