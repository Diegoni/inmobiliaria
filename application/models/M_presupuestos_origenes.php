<?php 
class m_presupuestos_origenes extends MY_Model 
{		
	protected $_tablename	= 'presupuestos_origenes';
	protected $_id_table	= 'id_origen';
	protected $_order		= 'origen';
	protected $_relation    =  '';
		
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