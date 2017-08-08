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
        $this->load->model($this->config->item('model'));
        $this->load->model('m_contratos');
		$this->load->model('m_cuotas_actualizaciones');
        $this->load->model('m_cuotas_estados');
        $this->load->model('m_formas_pagos');
        $this->load->model('m_plantillas');
        $this->load->model('m_proyectos');
    } 
    
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Ejemplo de abm
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/   
    
    
    function abm($id = NULL)
    {                           
        $db['clientes']     = $this->m_clientes->getRegistros();
        $db[$this->config->item('table')]    = $this->{$this->config->item('model')}->getRegistros();
        $db['contratos']    = $this->m_contratos->getRegistros();
        $db['cuotas_estados'] = $this->m_cuotas_estados->getRegistros();
        $db['estados']      = $this->m_cuotas_estados->getRegistros();
        
        $db['campos']   = array(
            array('select',   'id_cliente',  'cliente', $db['clientes'], 'disabled'),
            array('select',   $this->config->item('id_table'), $this->config->item('subjet'), $db[$this->config->item('table')], 'disabled'),
            array('select',   'id_contrato', 'contrato', $db['contratos'], 'disabled'),
            array('monto',    '', 'disabled'),
            array('monto_interes',    '', 'disabled'),
            array('fecha_inicio',    '', 'disabled'),
            array('fecha_vencimiento',    '', 'disabled'),
            array('select',   'id_estado', 'estado', $db['estados'], 'disabled'),
            array('monto_pago',    '', 'disabled'),
            array('fecha_pago',    '', 'disabled'),
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
                    $row->{$this->config->item('subjet')},
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
         $db['clientes']        = $this->m_clientes->getRegistros();
         $db['cuotas_estados']      = $this->m_cuotas_estados->getRegistros();
         
         $this->armarVista('resumen', $db);
    }
    
/*--------------------------------------------------------------------------------  
            Funciones para ajax: localidades de una provincia
 --------------------------------------------------------------------------------*/

    public function getCuotas()
    {
        if($this->input->post('id_cliente'))
        {
            $where = array(
                'id_cliente' => $this->input->post('id_cliente'),
                $this->config->item('id_table') => $this->input->post($this->config->item('id_table')),  
                'impaga'    => $this->input->post('impaga'),
                'emitida'   => $this->input->post('emitida'),
                'paga'      => $this->input->post('paga'),
                'vencida'   => $this->input->post('vencida'),
            );              
            $coutas  = $this->model->getCuotas($where);
            if($coutas)
            {
                $table = '<table class="table table-hover table-responsive dataTable" id="table_cuotas">';
                $table .= '<thead>';
                    $table .= '<tr class="success" role="row">';
                    $table .= '<th></th>';
                    $table .= '<th>'.lang('monto').'</th>';
                    $table .= '<th>'.lang('monto_interes').'</th>';
                    $table .= '<th>'.lang('inicio').'</th>';
                    $table .= '<th>'.lang('vencimiento').'</th>';
                    $table .= '<th>'.lang('estado').'</th>';
                    $table .= '</tr>';
                $table .= '</thead>';                    
                $table .= '<tbody>';
                foreach ($coutas  as $row) 
                {
                    $table .= '<tr>';
                    if($row->id_estado == 2)
                    {
                        $table .= '<td></td>';
                        $table .= '<td>'.formatImporte($row->monto).'</td>';
                        $table .= '<td>'.formatImporte($row->monto_interes).'</td>';
                    }else if($row->id_estado == 3)
                    {
                        $table .= '<td><input type="checkbox" class="montos" name="cuota_'.$row->id_cuota.'" value="'.$row->monto_interes.'" onclick="sumarMontos()"></td>';
                        $table .= '<td>'.formatImporte($row->monto).'</td>';
                        $table .= '<td class="info">'.formatImporte($row->monto_interes).'</td>';
                    }else
                    {
                        $table .= '<td><input type="checkbox" class="montos" name="cuota_'.$row->id_cuota.'" value="'.$row->monto.'" onclick="sumarMontos()"></td>';
                        $table .= '<td class="info">'.formatImporte($row->monto).'</td>';
                        $table .= '<td>'.formatImporte($row->monto_interes).'</td>';    
                    }
                    
                   
                    $table .= '<td>'.formatDate($row->fecha_inicio).'</td>';
                    $table .= '<td>'.formatDate($row->fecha_vencimiento).'</td>';
                    $table .= '<td>'.$row->estado.'</td>';
                    $table .= '</tr>';
                }   
                $table .= '</tbody>'; 
                $table .= '</table>';
                
                $table .= '<center>';
                $table .= '<button type="submit" class="btn btn-app">';
                $table .= '<i class="fa fa-credit-card"></i> '.$this->lang->line('pagar');
                $table .= '</button>';
                '</center>';
                
                echo $table;
            }        
        }
    }

/*--------------------------------------------------------------------------------  
            Administración de Afiliados: Ajax para armar la tabla
 --------------------------------------------------------------------------------*/     
    
    public function setPagos()
    {
         foreach ($_POST as $key => $value) 
         {
            if(substr($key, 0, 6) == 'cuota_')
            {
                $id_cuota = substr($key, 6);
                
                $update = array(
                    'id_estado'  => '2',
                    'fecha_pago' => date('Y-m-d'),
                    'monto_pago' => $value, 
                );
                
                $where = array(
                    'id_cuota'  => $id_cuota,
                );
                
                $this->model->update($update, $where);  
                
                $db['tickets'][] = $this->model->getRegistros($id_cuota);
            }
         }
         
         $db['plantillas'] = $this->m_plantillas->getRegistros(1);
         
         $this->armarVista('imprimir', $db);
    }
    
/*--------------------------------------------------------------------------------  
            Administración de Afiliados: Ajax para armar la tabla
 --------------------------------------------------------------------------------*/     
    
    public function actualizar()
    {
        $set        = array();
        $impagas    = $this->model->getRegistros('1', 'id_estado');
        $emitidas   = $this->model->getRegistros('4', 'id_estado');
        $fecha_actua = date('Y-m-d'); 
		$cat_imp	= 0;
		$cat_ven	= 0;
		
        if($impagas)
        {
            foreach ($impagas as $row_impagas) 
            {
                if($row_impagas->fecha_inicio <= $fecha_actua)
                {
                	$cat_imp = $cat_imp + 1;
                    $set[] = array(
                        'id_cuota'        => $row_impagas->id_cuota,
                        'id_estado'       => '4',
                    );
                }
            }   
        }
        
        if($emitidas)
        {
            foreach ($emitidas as $row_emitidas) 
            {
                if($row_emitidas->fecha_vencimiento <= $fecha_actua)
                {
                	$cat_ven = $cat_ven + 1;
                    $set[] = array(
                        'id_cuota'        => $row_emitidas->id_cuota,
                        'id_estado'       => '3',
                    );
                }            
            }
        }        
        
        $this->model->actualizar($set);
		
		$actualiacion = array(
			'emitidas'	=> $cat_imp,
			'vencidas'	=> $cat_ven
		);
		
		$this->m_cuotas_actualizaciones->insert($actualiacion);
        
        echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
    }    
}
?>