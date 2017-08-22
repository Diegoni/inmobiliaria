<?php 
class m_intereses extends MY_Model {
		
	protected $_tablename	= 'intereses';
	protected $_id_table	= 'id_interes';
	protected $_order		= 'id_interes';
	protected $_relation	= '';
		
	function __construct(){
		parent::__construct(
			$tablename		= $this->_tablename, 
			$id_table		= $this->_id_table, 
			$order			= $this->_order,
			$relation		= $this->_relation
		);
	}
} 
?>