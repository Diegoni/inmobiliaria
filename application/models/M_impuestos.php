<?php 
class m_impuestos extends MY_Model 
{		
	protected $_tablename	= 'impuestos';
	protected $_id_table	= 'id_impuesto';
	protected $_order		= 'impuesto';
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
?>