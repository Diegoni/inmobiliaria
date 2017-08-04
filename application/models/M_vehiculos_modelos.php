<?php 
class m_vehiculos_modelos extends MY_Model 
{		
	protected $_tablename	= 'vehiculos_modelos';
	protected $_id_table	= 'id_modelo';
	protected $_order		= 'modelo';
	protected $_relation    = array(
        'id_marca' => array(
            'table'     => 'vehiculos_marcas',
            'subjet'    => 'marca'
        ),
    );
		
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