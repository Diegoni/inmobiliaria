<?php 
class m_contratos extends MY_Model 
{		
	protected $_tablename	= 'contratos';
	protected $_id_table	= 'id_contratos';
	protected $_order		= 'contrato';
	protected $_relation    =  array(
        'id_cliente' => array(
            'table'     => 'clientes',
            'subjet'    => 'cliente'
        ),
        'id_inmueble' => array(
            'table'     => 'inmuebles',
            'subjet'    => 'inmueble'
        ),
        'id_forma_pago' => array(
            'table'     => 'formas_pagos',
            'subjet'    => 'forma_pago'
        )
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