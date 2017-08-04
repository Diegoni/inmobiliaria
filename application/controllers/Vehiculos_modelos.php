<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_modelos extends MY_Controller 
{
	protected $_subject = 'vehiculos_modelos';
    protected $_model   = 'm_vehiculos_modelos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_vehiculos_marcas');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['marcas']    = $this->m_vehiculos_marcas->getRegistros();
                                   
        $db['campos']   = array(
            array('modelo',   'onlyChar', 'required'),
            array('select',   'id_marca',  array('categoria', 'marca'), $db['marcas']),
        );
        
        $this->armarAbm($id, $db);
    }

/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getAjax()
    {
        if($this->input->post('id_marca'))
        {
            
            $_id = $this->input->post('id_marca');
            $_id_model = $this->input->post('id_modelo');
            $registros  = $this->model->getRegistros($_id, 'id_marca');
            
            echo '<option value="" disabled selected style="display:none;">Seleccione una opcion...</option>';
            if($registros)
            {
                foreach ($registros  as $row) 
                {
                    if($_id_model == $row->id_modelo)
                    {
                        echo '<option value="'.$row->id_modelo.'" selected>'.$row->modelo.'</option>';
                    }else
                    {
                        echo '<option value="'.$row->id_modelo.'">'.$row->modelo.'</option>';
                    }
                }    
            }
        }
    }     
}
?>