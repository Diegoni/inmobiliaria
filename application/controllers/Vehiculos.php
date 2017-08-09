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
        $this->load->model('m_contratos');
        $this->load->model('m_cuotas');
        $this->load->model('m_gastos');
        $this->load->model('m_vehiculos_calculos');
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
        $db['estado']       = 1;
        $db['vehiculos_categorias']   = $this->m_vehiculos_categorias->getRegistros();
        $db['vehiculos_calculos']   = $this->m_vehiculos_calculos->getRegistros();
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
            $db['gastos']       = $this->m_gastos->getRegistros($id, 'id_vehiculo');
        }else
        {
            $db['marcas']       = '';
            $db['versiones']    = '';
            $db['modelos']      = '';
            $db['gastos']       = FALSE;
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
            array('precio_toma',    'onlyFloat', ''),
            array('select',   'id_calculo',  'calculo', $db['vehiculos_calculos']),
            array('calculo',    'onlyFloat', ''),
            array('precio_costo',    '', 'readonly'),
            array('precio_venta',    '', 'readonly'),
            array('fecha_ingreso',    '', ''),
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
                    $db['campos'] = array(
                        array('vehiculo',    '', 'disabled'),
                        array('select',   'id_categoria',  'categoria', $db['vehiculos_categorias'], 'disabled'),
                        array('select',   'id_marca',  'marca', $db['marcas'], 'disabled'),
                        array('select',   'id_modelo',  'modelo', $db['modelos'], 'disabled'),
                        array('select',   'id_version',  'version', $db['versiones'], 'disabled'),
                        array('select',   'id_condicion',  'condicion', $db['condiciones'],  'disabled'),
                        array('ano',    '', 'disabled'),
                        array('kilometros',    '', 'disabled'),
                        array('nro_chasis',    '', 'disabled'),
                        array('nro_motor',    '', 'disabled'),
                        array('color',    '', 'disabled'),
                        array('precio_toma',    'onlyFloat', 'disabled'),
                        array('select',   'id_calculo',  'calculo', $db['vehiculos_calculos'],  'disabled'),
                        array('calculo',    'onlyFloat', 'disabled'),
                        array('precio_costo',    '', 'disabled'),
                        array('precio_venta',    '', 'disabled'),
                        array('fecha_ingreso',    '', 'disabled'),
                        array('comentario',    '', 'disabled'),
                    );
                    
                    $this->load->library('Graficos');
                    
                    $db['contrato'] = $this->m_contratos->getRegistros($id, 'id_vehiculo');
                    $db['cuotas'] = $this->m_cuotas->getRegistros($id, 'id_vehiculo');
                    
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
        if($this->input->post('id_vehiculo'))
        {
            $id_vehiculo    = $this->input->post('id_vehiculo');
            $registro       = $this->model->getRegistros($id_vehiculo);
            
            foreach ($registro  as $row) 
            {
                echo $row->precio_venta;
            }
        }
    }
    
/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getRegistros()
    {
        if($this->input->post('id_cliente'))
        {
            $id_cliente = $this->input->post('id_cliente');             
            $contratos  = $this->m_contratos->getRegistros($id_cliente, 'id_cliente');
            
            echo '<option value="" disabled selected style="display:none;">Seleccione una opcion...</option>';
            foreach ($contratos  as $row) 
            {
                echo '<option value="'.$row->id_vehiculo.'">'.$row->vehiculo.'</option>';
            }
        }
    }    
}
?>