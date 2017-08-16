<?php
include_once('My_Model.php');
class m_vendedores extends My_Model
{
	protected $_tablename	= 'vendedor';
	protected $_id_table	= 'id_vendedor';
	protected $_order		= 'vendedor';
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
	
	function getClientes($filtro)
	{
		$sql = "SELECT 
				`cuil` as num_cuil, 
				direccion , 
				alias as value,
				id_cliente,
				apellido, 
				nombre 
			FROM 
				cliente 
			WHERE 
				id_estado = 1  AND 
				(alias LIKE '%".$filtro."%' OR 
				`cuil` LIKE '%".$filtro."%') 
			LIMIT 20";
			
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

