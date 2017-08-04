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
        $this->load->model('m_vehiculos_marcas');
        $this->load->model('m_vehiculos_versiones');        
        $this->load->model('m_vehiculos_modelos');
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
        if($id != NULL)
        {
            $registros = $this->model->getRegistros($id);
            foreach ($registros as $registro) 
            {
                $id_marca = $registro->id_marca;   
                $id_version = $registro->id_version;
                $id_modelo = $registro->id_modelo;
            }
            
            $db['marcas']       = $this->m_vehiculos_marcas->getRegistros($id_marca, 'id_marca');
            $db['versiones']    = $this->m_vehiculos_versiones->getRegistros($id_version, 'id_version');
            $db['modelos']      = $this->m_vehiculos_modelos->getRegistros($id_modelo, 'id_modelo');
        }else
        {
            $db['marcas']       = '';
            $db['versiones']    = '';
            $db['modelos']      = '';
        }
        
        $db['condiciones']  = $this->m_vehiculos_condiciones->getRegistros();
        
        $db['campos']   = array(
            array('vehiculo',    '', 'required'),
            array('select',   'id_categoria',  'categoria', $db['vehiculos_categorias'], 'onchange="marcas_activas()"'),
            array('select',   'id_marca',  'marca', $db['marcas'], 'onchange="modelos_activas()"'),
            array('select',   'id_modelo',  'modelo', $db['modelos'], 'onchange="versiones_activas()"'),
            array('select',   'id_version',  'version', $db['versiones']),
            array('select',   'id_condicion',  'condicion', $db['condiciones']),
            array('ano',    '', ''),
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