<?php 
class m_calendarios extends MY_Model 
{		
	protected $_tablename	= 'calendarios';
	protected $_id_table	= 'id_calendario';
	protected $_order		= 'calendario';
	protected $_relation    = array(
        'id_color' => array(
            'table'     => 'colores',
            'subjet'    => 'color'
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