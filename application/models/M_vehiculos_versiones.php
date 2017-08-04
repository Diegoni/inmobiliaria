<?php 
class m_vehiculos_versiones extends MY_Model 
{		
	protected $_tablename	= 'vehiculos_versiones';
	protected $_id_table	= 'id_version';
    protected $_order		= array('vehiculos_modelos.modelo', 'version');
	protected $_relation    = array(
        'id_modelo' => array(
            'table'     => 'vehiculos_modelos',
            'subjet'    => 'modelo'
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