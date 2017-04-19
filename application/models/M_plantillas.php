<?php 
class m_plantillas extends MY_Model 
{		
	protected $_tablename	= 'plantillas';
	protected $_id_table	= 'id_plantilla';
	protected $_order		= 'id_plantilla';
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