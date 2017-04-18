<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuotas extends MY_Controller 
{
	protected $_subject = 'cuotas';
    protected $_model   = 'm_cuotas';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
        $this->load->model('m_clientes');
		$this->load->model('m_inmuebles');
        $this->load->model('m_contratos');
        $this->load->model('m_cuotas_estados');
        $this->load->model('m_formas_pagos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['clientes']    	= $this->m_clientes->getRegistros();
        $db['inmuebles']    = $this->m_inmuebles->getRegistros();
        $db['contratos']    = $this->m_contratos->getRegistros();
        $db['cuotas_estados'] = $this->m_cuotas_estados->getRegistros();
        $db['formas_pagos'] = $this->m_formas_pagos->getRegistros();

        $db['campos']   = array(
            array('select',   'id_cliente',  'cliente', $db['clientes'], 'disabled'),
            array('select',   'id_inmueble', 'inmueble', $db['inmuebles'], 'disabled'),
            array('select',   'id_contrato', 'contrato', $db['contratos'], 'disabled'),
            array('monto',    'onlyFloat', 'required'),
            array('fecha_pago',    '', 'required'),
            array('select',   'id_forma_pago', 'forma_pago', $db['formas_pagos'], 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
    
        
/*--------------------------------------------------------------------------------  
            Administración de Afiliados: Ajax para armar la tabla
 --------------------------------------------------------------------------------*/     
    
    public function ajax()
    {
        $registros    = $this->model->getRegistros();
        $json         = "";
        
        if($registros)
        {
            $icon_class         = "'fa fa-pencil-square-o'";
            $url_modificar      = "'".base_url()."index.php/cuotas/abm/";
            $btn_class          = "'btn btn-default'";
            $title_modificar    = "'Modificar'";
            
            foreach ($registros as $row) 
            {
                $url_final = $row->id_cuota."'";
                    
                $buttons = '<a class='.$btn_class.' title='.$title_modificar.'  href='.$url_modificar.$url_final.'><i class='.$icon_class.'></i></a> ';
                    
                $registro = array(
                    $row->cliente,
                    $row->inmueble,
                    $row->estado,
                    $buttons,
                );
                    
                $json .= setJsonContent($registro);
            }
            
            
            $json = substr($json, 0, -2);
        } 
        echo '{ "data": ['.$json.' ]  }';
    }

/*--------------------------------------------------------------------------------  
            Administración de Afiliados: Ajax para armar la tabla
 --------------------------------------------------------------------------------*/     
    
    public function resumen()
    {
    	 $db['clientes']    	= $this->m_clientes->getRegistros();
		 $db['cuotas_estados']    	= $this->m_cuotas_estados->getRegistros();
		 
		 $this->armarVista('resumen', $db);
	}
    
}
?>