<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presupuestos extends MY_Controller 
{
	protected $_subject = 'presupuestos';
    protected $_model   = 'm_presupuestos';
    
    function __construct()
    {
        parent::__construct(
            $subject    = $this->_subject,
            $model      = $this->_model 
        );
        
        $this->load->model($this->_model, 'model');  
		$this->load->model('m_presupuestos_renglones');		
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['campos']   = array(
            array('tipo',    'onlyChar', 'required'),
        );
        
        $this->armarAbm($id, $db);
    }
	
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  	
	
	
	function detalle_presupuesto($id, $llamada = NULL)
	{
		if($this->session->userdata('logged_in'))
		{
			$_presupuesto = $this->model->getRegistros($id);
			if($_presupuesto){
				if($this->input->post('interes_tipo')){
				
					foreach ($_presupuesto as $_row) {
						$presupuesto_monto = $_row->monto;
					}
					
					if($this->input->post('interes_tipo') == 'porcentaje'){
						$interes_monto = $presupuesto_monto * $this->input->post('interse_monto') / 100 ;
					}else{
						$interes_monto = $this->input->post('interse_monto');
					}
					
					if($this->input->post('descripcion_monto') == ""){
						$descripcion = date('d-m-Y').' Intereses generados por atraso';
					}else{
						$descripcion = date('d-m-Y').' '.$this->input->post('descripcion_monto');
					}
					
					$interes = array(
						'id_presupuesto'	=> $id,
						'id_tipo'			=> 1,
						'monto'				=> $interes_monto,
						'descripcion'		=> $descripcion,
						'fecha'				=> date('Y-m-d H:i:s'),
						'id_usuario'		=> 1, //agregar nombre de usuario
					);
						
					$this->intereses_model->insert($interes);
						
					$_presupuesto = array(
						'monto'				=> $presupuesto_monto + $interes_monto,
					);
						
					$this->presupuestos_model->update($_presupuesto, $id);
				}
			
				$condicion = array(
					'id_presupuesto' => $id
				);			
				
				//$db['texto']				= getTexto();			
				$db['presupuestos']			= $this->model->getRegistros($id);
				$db['detalle_presupuesto']	= $this->m_presupuestos_renglones->getRegistros($id, 'id_presupuesto');
				//$db['interes_presupuesto']	= $this->intereses_model->getInteres($id);
				$db['interes_presupuesto']	= FALSE;
				//$db['impresiones']			= $this->config_impresion_model->getRegistro(2);
				$db['impresiones']			= FALSE;
				//$db['devoluciones']			= $this->devoluciones_model->getBusqueda($condicion);
				$db['devoluciones']			= FALSE;
				//$db['anulaciones']			= $this->anulaciones_model->getAnulaciones($id);
				$db['anulaciones']			= FALSE;
				$db['id_presupuesto']		= $id;
				
				if($llamada == NULL)
				{
					$db['llamada'] = FALSE;
					//$this->load->view('head.php',$db);
					//$this->load->view('menu.php');
					$this->armarVista('detalle_presupuestos.php' ,$db);
					//$this->load->view('footer.php');
				}else
				{
					$db['llamada'] = TRUE;
					$this->load->view('head.php',$db);
					$this->load->view('presupuestos/detalle_presupuestos.php');
				}
				
			}else{
				redirect('/','refresh');
			}
		}else{
			redirect('/','refresh');
		}
	}
}
?>