<?php 
class m_presupuestos extends MY_Model 
{		
	protected $_tablename	= 'presupuestos';
	protected $_id_table	= 'id_presupuesto';
	protected $_order		= 'id_presupuesto';
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