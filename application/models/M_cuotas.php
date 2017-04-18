<?php 
class m_cuotas extends MY_Model 
{		
	protected $_tablename	= 'cuotas';
	protected $_id_table	= 'id_cuota';
	protected $_order		= 'id_cuota';
	protected $_relation    =  array(
        'id_contrato' => array(
            'table'     => 'contratos',
            'subjet'    => 'contrato'
        ),
        'id_cliente' => array(
            'table'     => 'clientes',
            'subjet'    => 'cliente'
        ),
        'id_inmueble' => array(
            'table'     => 'inmuebles',
            'subjet'    => 'inmueble'
        ),
        'id_estado' => array(
            'table'     => 'cuotas_estados',
            'subjet'    => 'estado'
        ),
        'id_forma_pago' => array(
            'table'     => 'formas_pagos',
            'subjet'    => 'forma_pago'
        ),
    );
		
	function __construct()
	{
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
} 
?>