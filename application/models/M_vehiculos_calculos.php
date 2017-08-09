<?php 
class m_vehiculos_calculos extends MY_Model 
{		
	protected $_tablename	= 'vehiculos_calculos';
	protected $_id_table	= 'id_calculo';
	protected $_order		= 'calculo';
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