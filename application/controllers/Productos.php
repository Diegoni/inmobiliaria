<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends MY_Controller 
{
	protected $_subject = 'productos';
    protected $_model   = 'm_productos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_productos_mediciones');
        $this->load->model('m_impuestos');
        $this->load->model('m_proveedores');
        $this->load->model('m_productos_marcas');
        $this->load->model('m_productos_categorias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['mediciones']       = $this->m_productos_mediciones->getRegistros();
        $db['impuestos']        = $this->m_impuestos->getRegistros();
        $db['proveedores']      = $this->m_proveedores->getRegistros();
        $db['marcas']           = $this->m_productos_marcas->getRegistros();
        $db['categoria']        = $this->m_productos_categorias->getRegistros();
		
		if($id == NULL)
		{
			$_readonly = '';
		}else
		{
			$_readonly = 'readonly';
		}
        
        
        $db['campos']   = array(
            array('producto',    '', 'required'),
            array('cod_proveedor',  '',  'required'),
            array('stock_alerta',    '', ''),
            array('stock_deseado',    '', ''),
            array('stock_fisico',    '', $_readonly),
            array('stock_pedido',    '', ''),
            array('select',   'id_medicion',  'medicion', $db['mediciones']),
            array('medicion',    '', ''),
            array('precio_venta',    '', ''),
            array('precio_min_venta',    '', ''),
            array('precio_costo',    '', $_readonly),
            array('select',   'id_impuesto',  'impuesto', $db['impuestos']),
            array('select',   'id_proveedor',  'proveedor', $db['proveedores']),
            array('select',   'id_marca',  'marca', $db['marcas']),
            array('select',   'id_categoria',  'categoria', $db['categoria']),
            array('comentario',    '', ''),
        );
		        
        $this->armarAbm($id, $db);
    }
}
?>