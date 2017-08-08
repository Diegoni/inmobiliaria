<?php 
class m_gastos extends MY_Model 
{		
	protected $_tablename	= 'gastos';
	protected $_id_table	= 'id_gasto';
	protected $_order		= 'gasto';
	protected $_relation    =  array(
        'id_tipo' => array(
            'table'     => 'gastos_tipos',
            'subjet'    => 'tipo'
        ),
        'id_vehiculo' => array(
            'table'     => 'vehiculos',
            'subjet'    => 'vehiculo'
        ),
        'id_inmueble' => array(
            'table'     => 'inmuebles',
            'subjet'    => 'inmueble'
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