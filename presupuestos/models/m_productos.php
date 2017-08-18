<?php
include_once('My_Model.php');
class m_productos extends My_Model
{
	protected $_tablename	= 'productos';
	protected $_id_table	= 'id_producto';
	protected $_order		= 'producto';
	protected $_relation    = '';
	
	function __construct()
	{
		parent::__construct(
				$tablename		= $this->_tablename, 
				$id_table		= $this->_id_table, 
				$order			= $this->_order, 
				$relation		= $this->_relation 
		);
	}
	
	function getProducto($filtro)
	{
		$sql = "
		SELECT 
			*
		FROM 
			productos 
		WHERE 
			(producto LIKE '%".$filtro."%' OR 
			cod_proveedor LIKE '%".$filtro."%') AND
			eliminado = 0 
		LIMIT 
			20 ";
			
		$result = $this->_db->query($sql);
		
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_array())
			{
				$rows[] = $row;
			}
			
			return $rows;	
		}
		else
		{
			return FALSE;	
		}						
	}
}

