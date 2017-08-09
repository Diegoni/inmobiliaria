<?php 
class m_vehiculos extends MY_Model 
{		
	protected $_tablename	= 'vehiculos';
	protected $_id_table	= 'id_vehiculo';
	protected $_order		= 'vehiculo';
	protected $_relation    = array(
        'id_categoria' => array(
            'table'     => 'vehiculos_categorias',
            'subjet'    => 'categoria'
        ),
        'id_marca' => array(
            'table'     => 'vehiculos_marcas',
            'subjet'    => 'marca'
        ),
		'id_modelo' => array(
            'table'     => 'vehiculos_modelos',
            'subjet'    => 'modelo'
        ),
        'id_version' => array(
            'table'     => 'vehiculos_versiones',
            'subjet'    => 'version'
        ),
        'id_condicion' => array(
            'table'     => 'vehiculos_condiciones',
            'subjet'    => 'condicion'
        ),
        'id_calculo' => array(
            'table'     => 'vehiculos_calculos',
            'subjet'    => 'calculo'
        ),
        'id_estado' => array(
            'table'     => 'vehiculos_estados',
            'subjet'    => 'estado'
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