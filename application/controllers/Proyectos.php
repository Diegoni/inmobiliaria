<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyectos extends MY_Controller 
{
	protected $_subject = 'proyectos';
    protected $_model   = 'm_proyectos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_proyectos_estados');
		$this->load->model('m_proyectos_tipos');
        $this->load->model('m_localidades');
        $this->load->model('m_provincias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        if($id != NULL)
        {
            $registros = $this->model->getRegistros($id);
            foreach ($registros as $registro) 
            {
                $id_provincia = $registro->id_provincia;    
            }
            
            $db['localidades'] = $this->m_localidades->getRegistros($id_provincia, 'id_provincia');
        }else
        {
            $db['localidades'] = '';
        }
                                   
        $db['estados']      = $this->m_proyectos_estados->getRegistros();
		$db['tipos']        = $this->m_proyectos_tipos->getRegistros();
        $db['provincias']   = $this->m_provincias->getRegistros();
        
        $db['campos']   = array(
            array('proyecto',    '', 'required'),
            array('select',   'id_tipo',  'tipo', $db['tipos']),
            array('nro_referencia',    '', ''),
           	array('dimension',    '', ''),
           	array('select',   'id_provincia',  'provincia', $db['provincias'], 'onchange="provincias_activas()"'),
           	array('select',   'id_localidad',  'localidad', $db['localidades']),
           	array('select',   'id_estado',  'estado', $db['estados']),
            array('comentario',    '', ''),
        );
        
        $this->armarAbm($id, $db);
    }
}
?>