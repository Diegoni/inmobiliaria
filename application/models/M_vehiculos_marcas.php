<?php 
class m_vehiculos_marcas extends MY_Model 
{		
	protected $_tablename	= 'vehiculos_marcas';
	protected $_id_table	= 'id_marca';
	protected $_order		= array('vehiculos_categorias.categoria', 'marca');
	protected $_relation    = array(
        'id_categoria' => array(
            'table'     => 'vehiculos_categorias',
            'subjet'    => 'categoria'
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