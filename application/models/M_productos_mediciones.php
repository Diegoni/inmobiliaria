<?php 
class m_productos_mediciones extends MY_Model 
{		
	protected $_tablename	= 'productos_mediciones';
	protected $_id_table	= 'id_medicion';
	protected $_order		= 'medicion ';
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