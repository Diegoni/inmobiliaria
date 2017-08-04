<?php 
class m_vehiculos_condiciones extends MY_Model 
{		
	protected $_tablename	= 'vehiculos_condiciones';
	protected $_id_table	= 'id_condicion';
	protected $_order		= 'condicion';
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