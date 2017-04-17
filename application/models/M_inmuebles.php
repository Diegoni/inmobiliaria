<?php 
class m_inmuebles extends MY_Model 
{		
	protected $_tablename	= 'inmuebles';
	protected $_id_table	= 'id_inmueble';
	protected $_order		= 'inmueble';
	protected $_relation    =  array(
        'id_tipo' => array(
            'table'     => 'inmuebles_tipos',
            'subjet'    => 'tipo'
        ),
        'id_estado' => array(
            'table'     => 'inmuebles_estados',
            'subjet'    => 'estado'
        ),
        'id_proyecto' => array(
            'table'     => 'proyectos',
            'subjet'    => 'proyecto'
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