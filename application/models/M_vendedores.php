<?php 
class m_vendedores extends MY_Model 
{		
	protected $_tablename	= 'vendedores';
	protected $_id_table	= 'id_vendedor';
	protected $_order		= 'vendedor';
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