<?php
include_once('My_Model.php');
class m_articulos extends My_Model
{
	protected $_tablename	= 'articulo';
	protected $_id_table	= 'id_articulo';
	protected $_order		= 'articulo';
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
	
	function getArticulo($filtro)
	{
		$sql = "SELECT 
				descripcion as value,
				id_articulo,
				precio_venta_sin_iva_con_imp, 
				iva as porc_iva 
			FROM 
				articulo 
			WHERE 
				(descripcion LIKE '%".$filtro."%' OR 
				cod_proveedor LIKE '%".$filtro."%') AND
				id_estado = 1 
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

