<?php 
class m_vehiculos_categorias extends MY_Model 
{		
	protected $_tablename	= 'vehiculos_categorias';
	protected $_id_table	= 'id_categoria';
	protected $_order		= 'categoria';
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