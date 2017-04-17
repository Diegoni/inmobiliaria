<?php 
class m_proyectos extends MY_Model 
{		
	protected $_tablename	= 'proyectos';
	protected $_id_table	= 'id_proyecto';
	protected $_order		= 'proyecto';
	protected $_relation    =  array(
        'id_tipo' => array(
            'table'     => 'proyectos_tipos',
            'subjet'    => 'tipo'
        ),
        'id_estado' => array(
            'table'     => 'proyectos_estados',
            'subjet'    => 'estado'
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