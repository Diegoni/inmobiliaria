<?php 
class m_colores extends MY_Model 
{		
	protected $_tablename	= 'colores';
	protected $_id_table	= 'id_color';
	protected $_order		= 'color';
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