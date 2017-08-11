<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stocks_movimientos extends MY_Controller 
{
	protected $_subject = 'stocks_movimientos';
    protected $_model   = 'm_stocks_movimientos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_productos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['productos']       = $this->m_productos->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_producto',  'producto', $db['productos']),
            array('ingreso',    '', ''),
            array('egreso',    '', ''),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);
    }
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Actualizacion del stock
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/      
    
    function afterInsert($registro, $id)
    {
        $productos = $this->m_productos->getRegistros($registro['id_producto']);
        
        foreach ($productos as $_row) 
        {
            $stock_fisico = $_row->stock_fisico;
        }
        
        $update = array(
            'stock_fisico'  => $stock_fisico + $registro['cantidad_ingreso'] - $registro['cantidad_egreso'], 
        );
        
        $where = array(
            'id_producto'   => $registro['id_producto'],
        );
        
        $this->m_productos->update($update, $where);
        
        return $registro;
    }
}
?>