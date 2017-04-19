<?php 
class m_cuotas_actualizaciones extends MY_Model 
{		
	protected $_tablename	= 'cuotas_actualizaciones';
	protected $_id_table	= 'id_actualizacion';
	protected $_order		= 'id_actualizacion';
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