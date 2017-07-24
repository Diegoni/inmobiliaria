<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inmuebles extends MY_Controller 
{
	protected $_subject = 'inmuebles';
    protected $_model   = 'm_inmuebles';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_inmuebles_estados');
		$this->load->model('m_inmuebles_tipos');
        $this->load->model('m_proyectos');
        $this->load->model('m_contratos');
        $this->load->model('m_cuotas');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
                                   
        $db['estados']    	= $this->m_inmuebles_estados->getRegistros();
		$db['tipos']    	= $this->m_inmuebles_tipos->getRegistros();
        $db['proyectos']    = $this->m_proyectos->getRegistros();
        $db['estado']       = 0;
        
        $db['campos']   = array(
            array('inmueble',    '', 'required'),
            array('select',   'id_proyecto',  'proyecto', $db['proyectos'], 'required'),
            array('select',   'id_tipo',  'tipo', $db['tipos']),
            array('precio',    'onlyFloat', 'required'),
            array('nro_referencia',    '', ''),
           	array('dimension',    '', ''),
           	array('calle',    '', ''),
           	array('calle_numero',    '[9999]', ''),
           	array('superficie_cubierta',    '', ''),
            array('habitaciones',    '[99]', ''),
            array('plantas',    '[99]', ''),
            array('banos',    '[99]', ''),
            array('checkbox', 'permuta'),
            array('checkbox', 'permuta'),
            array('checkbox', 'garaje'),
            array('checkbox', 'agua'),
            array('checkbox', 'luz'),
            array('checkbox', 'gas'),
            array('checkbox', 'cloaca'),
            array('checkbox', 'expensas'),
            array('ano_construccion',    '[9999]', ''),
           	array('select',   'id_estado',  'estado', $db['estados'], 'disabled'),
            array('comentario',    '', ''),
        );
        
        if($id != NULL)
        {
            $registro = $this->model->getRegistros($id);
            if($registro)
            {
                foreach ($registro as $_row) 
                {
                    $estado = $_row->id_estado;    
                }
                
                if($estado == 2)
                {
                    $db['campos']   = array(
                        array('inmueble',    '', 'disabled'),
                        array('select',   'id_proyecto',  'proyecto', $db['proyectos'], 'disabled'),
                        array('select',   'id_tipo',  'tipo', $db['tipos'], 'disabled'),
                        array('precio',    'onlyFloat', 'disabled'),
                        array('nro_referencia',    '', 'disabled'),
                        array('dimension',    '', 'disabled'),
                        array('calle',    '', 'disabled'),
                        array('calle_numero',    '[9999]', 'disabled'),
                        array('superficie_cubierta',    '', 'disabled'),
                        array('habitaciones',    '[99]', 'disabled'),
                        array('plantas',    '[99]', 'disabled'),
                        array('banos',    '[99]', 'disabled'),
                        array('checkbox', 'permuta'),
                        array('checkbox', 'permuta'),
                        array('checkbox', 'garaje'),
                        array('checkbox', 'agua'),
                        array('checkbox', 'luz'),
                        array('checkbox', 'gas'),
                        array('checkbox', 'cloaca'),
                        array('checkbox', 'expensas'),
                        array('ano_construccion',    '[9999]', 'disabled'),
                        array('select',   'id_estado',  'estado', $db['estados'], 'disabled'),
                        array('comentario',    '', 'disabled'),
                    );
                    
                    $db['contrato'] = $this->m_contratos->getRegistros($id, 'id_inmueble');
                    $db['cuotas'] = $this->m_cuotas->getRegistros($id, 'id_inmueble');
                    
                    $db['estado']       = 2;
                }
            }    
        }
        
        
        $this->armarAbm($id, $db);
    }
    
/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getMonto()
    {
        if($this->input->post('id_inmueble'))
        {
            $id_inmueble = $this->input->post('id_inmueble');
            $inmueble  = $this->model->getRegistros($id_inmueble);
            
            foreach ($inmueble  as $row) 
            {
                echo $row->precio;
            }
        }
    }
    
/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getInmuebles()
    {
        if($this->input->post('id_cliente'))
        {
            $id_cliente = $this->input->post('id_cliente');             
            $contratos  = $this->m_contratos->getRegistros($id_cliente, 'id_cliente');
            
            echo '<option value="" disabled selected style="display:none;">Seleccione una opcion...</option>';
            foreach ($contratos  as $row) 
            {
                echo '<option value="'.$row->id_inmueble.'">'.$row->inmueble.'</option>';
            }
        }
    }
}
?>