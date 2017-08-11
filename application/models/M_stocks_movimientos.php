<?php 
class m_stocks_movimientos extends MY_Model 
{		
	protected $_tablename	= 'stocks_movimientos';
	protected $_id_table	= 'id_movimiento';
	protected $_order		= 'date_add';
	protected $_relation    =  array(
        'id_producto' => array(
            'table'     => 'productos',
            'subjet'    => 'producto'
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