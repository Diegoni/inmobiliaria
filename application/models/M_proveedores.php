<?php 
class m_proveedores extends MY_Model 
{		
	protected $_tablename	= 'proveedores';
	protected $_id_table	= 'id_proveedor';
	protected $_order		= 'id_proveedor';
	protected $_relation    =  array(
        'id_tipo' => array(
            'table'     => 'proveedores_tipos',
            'subjet'    => 'tipo'
        ),
        'id_forma_juridica' => array(
            'table'     => 'formas_juridicas',
            'subjet'    => 'forma_juridica'
        ),
        'id_empleado' => array(
            'table'     => 'empleados',
            'subjet'    => 'empleado'
        ),
        'id_localidad' => array(
            'table'     => 'localidades',
            'subjet'    => 'localidad'
        ),
        'id_provincia' => array(
            'table'     => 'provincias',
            'subjet'    => 'provincia'
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