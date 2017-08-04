<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos extends MY_Controller 
{
	protected $_subject = 'vehiculos';
    protected $_model   = 'm_vehiculos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_vehiculos_categorias');
        $this->load->model('m_vehiculos_condiciones');

    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['vehiculos_categorias']   = $this->m_vehiculos_categorias->getRegistros();
        $db['marcas']       = '';
        $db['versiones']    = '';
        $db['modelos']      = '';
        $db['condiciones']  = $this->m_vehiculos_condiciones->getRegistros();
        
        $db['campos']   = array(
            array('vehiculo',    '', 'required'),
            array('select',   'id_categoria',  'categoria', $db['vehiculos_categorias'], 'onchange="categorias_activas()"'),
            array('select',   'id_marca',  'marca', $db['marcas']),
            array('select',   'id_version',  'version', $db['versiones']),
            array('select',   'id_modelo',  'modelo', $db['modelos']),
            array('select',   'id_condicion',  'condicion', $db['condiciones']),
            array('kilometros',    '', ''),
            array('nro_chasis',    '', ''),
            array('nro_motor',    '', ''),
            array('color',    '', ''),
            array('precio_toma',    '', ''),
            array('precio_costo',    '', 'disabled'),
            array('precio_venta',    '', ''),
            array('fecha_ingreso',    '', ''),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>