<?php
include_once('My_Model.php');
class m_presupuestos_renglones extends My_Model
{
	protected $_tablename	= 'presupuestos_renglones';
	protected $_id_table	= 'id_renglon';
	protected $_order		= 'id_renglon';
	protected $_relation    = '';
	
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