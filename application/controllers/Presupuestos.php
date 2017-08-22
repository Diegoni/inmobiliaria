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
		$this->load->model('m_intereses');
		$this->load->model('m_anulaciones');
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
			if($_presupuesto)
			{
				if($this->input->post('interes_tipo'))
				{
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
					);
						
					$this->m_intereses->insert($interes);
						
					$_presupuesto = array(
						'monto'				=> $presupuesto_monto + $interes_monto,
					);
						
					$this->model->update($_presupuesto, $id);
				}
			
				$condicion = array(
					'id_presupuesto' => $id
				);			
				
				$db['presupuestos']			= $this->model->getRegistros($id);
				$db['detalle_presupuesto']	= $this->m_presupuestos_renglones->getRegistros($id, 'id_presupuesto');
				$db['interes_presupuesto']	= $this->m_intereses->getRegistros($id, 'id_presupuesto');
				$db['anulaciones']			= $this->m_anulaciones->getRegistros($id, 'id_presupuesto');
				$db['id_presupuesto']		= $id;
				
				if($llamada == NULL)
				{
					$db['llamada'] = FALSE;
					$this->armarVista('detalle_presupuestos.php' ,$db);
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



	function anular($id = NULL)
	{
		if($this->session->userdata('logged_in'))
		{
			if($this->input->post('nota'))
			{
				$registro = array(
					'id_presupuesto'	=> $this->input->post('id_presupuesto'),
					'monto'				=> $this->input->post('monto'),
					'comentario'		=> $this->input->post('nota'),
				);	
				
				$this->m_anulaciones->insert($registro);
				
				$presupuesto = array(
					'estado' => 3
				);
				
				$this->model->update($presupuesto, $registro['id_presupuesto']);
				
				redirect('presupuestos/table/','refresh');
				
			}
			
			$condicion = array(
				'id_presupuesto' => $id
			);			
			
			$db['presupuestos']			= $this->model->getRegistros($id);
			$db['detalle_presupuesto']	= $this->m_presupuestos_renglones->getRegistros($id, 'id_presupuesto');
			//$db['devoluciones']			= $this->m_devoluciones->getBusqueda($condicion);
			$db['devoluciones'] = FALSE;
			$db['impresiones'] = FALSE;
			$db['id_presupuesto'] = $id;
			
			$this->armarVista('anular.php' ,$db);
		}else
		{
			redirect('/','refresh');
		}
	}
}
?>