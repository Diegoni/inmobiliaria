<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Localidades extends MY_Controller 
{
	protected $_subject = 'Localidades';
    protected $_model   = 'm_localidades';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_provincias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['provincias'] = $this->m_provincias->getRegistros();
                                   
        $db['campos']   = array(
            array('localidad',    'onlyChar', 'required'),
            array('select',   'id_provincia',  'provincia', $db['provincias']),
        );
        
        $this->armarAbm($id, $db);
    }
    
/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getLocalidades()
    {
        if($this->input->post('provincia'))
        {
            $id_provincia = $this->input->post('provincia');
            $id_localidad = $this->input->post('id_localidad');             
            $departamentos  = $this->model->getRegistros($id_provincia, 'id_provincia');
            
            echo '<option value="" disabled selected style="display:none;">Seleccione una opcion...</option>';
            foreach ($departamentos  as $row) 
            {
                if($id_localidad == $row->id_localidad)
                {
                    echo '<option value="'.$row->id_localidad.'" selected>'.$row->localidad.'</option>';
                }else
                {
                    echo '<option value="'.$row->id_localidad.'">'.$row->localidad.'</option>';
                }
            }
        }
    }
}
?>