<?php 
class m_presupuestos extends MY_Model 
{		
	protected $_tablename	= 'presupuestos';
	protected $_id_table	= 'id_presupuesto';
	protected $_order		= 'id_presupuesto';
	protected $_relation    = array(
        'id_cliente' => array(
            'table'     => 'clientes',
            'subjet'    => 'cliente',
        ),
        'id_vendedor' => array(
            'table'     => 'vendedores',
            'subjet'    => 'vendedor',
        ),
        'id_forma_pago' => array(
            'table'     => 'formas_pagos',
            'subjet'    => 'forma_pago',
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