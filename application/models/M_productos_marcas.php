<?php 
class m_productos_marcas extends MY_Model 
{		
	protected $_tablename	= 'productos_marcas';
	protected $_id_table	= 'id_marca';
	protected $_order		= 'marca ';
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