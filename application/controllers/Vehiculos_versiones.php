<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_versiones extends MY_Controller 
{
	protected $_subject = 'vehiculos_versiones';
    protected $_model   = 'm_vehiculos_versiones';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_vehiculos_modelos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['modelos']    = $this->m_vehiculos_modelos->getRegistros();
                                   
        $db['campos']   = array(
            array('version',    'onlyChar', 'required'),
            array('select',   'id_modelo',  array('marca', 'modelo'), $db['modelos']),
        );
        
        
        $this->armarAbm($id, $db);
    }
    
/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getAjax()
    {
        if($this->input->post('id_modelo'))
        {
            $_id = $this->input->post('id_modelo');
            $_id_model = $this->input->post('id_version');
            $registros  = $this->model->getRegistros($_id, 'id_modelo');
            
            echo '<option value="" disabled selected style="display:none;">Seleccione una opcion...</option>';
            if($registros)
            {
                foreach ($registros  as $row) 
                {
                    if($_id_model == $row->id_version)
                    {
                        echo '<option value="'.$row->id_version.'" selected>'.$row->version.'</option>';
                    }else
                    {
                        echo '<option value="'.$row->id_version.'">'.$row->version.'</option>';
                    }
                }    
            }
        }
    }    
}
?>