<?php 
class m_anulaciones extends MY_Model {
		
	protected $_tablename	= 'anulaciones';
	protected $_id_table	= 'id_anulacion';
	protected $_order		= 'id_anulacion';
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