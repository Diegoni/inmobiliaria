<?php
include_once('My_Model.php');
class m_config extends My_Model
{
	protected $_tablename	= 'config';
	protected $_id_table	= 'id_config';
	protected $_order		= 'id_config';
	protected $_relation	= '';
	
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