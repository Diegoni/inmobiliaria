<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiculos_marcas extends MY_Controller 
{
	protected $_subject = 'vehiculos_marcas';
    protected $_model   = 'm_vehiculos_marcas';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_vehiculos_categorias');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {
        $db['categorias']    = $this->m_vehiculos_categorias->getRegistros();
                                   
        $db['campos']   = array(
            array('marca',    'onlyChar', 'required'),
            array('select',   'id_categoria',  'categoria', $db['categorias']),
        );
        
        $this->armarAbm($id, $db);
    }

/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getAjax()
    {
        if($this->input->post('id_categoria'))
        {
            
            $_id = $this->input->post('id_categoria');
            $_id_model = $this->input->post('id_marca');
            $registros  = $this->model->getRegistros($_id, 'id_categoria');
            
            echo '<option value="" disabled selected style="display:none;">Seleccione una opcion...</option>';
            if($registros)
            {
                foreach ($registros  as $row) 
                {
                    if($_id_model == $row->id_marca)
                    {
                        echo '<option value="'.$row->id_marca.'" selected>'.$row->marca.'</option>';
                    }else
                    {
                        echo '<option value="'.$row->id_marca.'">'.$row->marca.'</option>';
                    }
                }    
            }
        }
    }    
}
?>