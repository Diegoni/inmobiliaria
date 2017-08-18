<?php
include_once('My_Model.php');
class m_clientes extends My_Model
{
	protected $_tablename	= 'cliente';
	protected $_id_table	= 'id_cliente';
	protected $_order		= 'nombre';
	protected $_relation    =  array(
        'id_tipo' => array(
            'table'     => 'clientes_tipos',
            'subjet'    => 'tipo'
        ),
        'id_forma_juridica' => array(
            'table'     => 'formas_juridicas',
            'subjet'    => 'forma_juridica'
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
	
	function getClientes($filtro)
	{
		//direccion
		$sql = "
		SELECT 
			*
		FROM 
			clientes
		WHERE 
			eliminado = 0  AND 
			(cliente LIKE '%".$filtro."%' OR 
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

