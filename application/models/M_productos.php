<?php 
class m_productos extends MY_Model 
{		
	protected $_tablename	= 'productos';
	protected $_id_table	= 'id_producto';
	protected $_order		= 'producto';
	protected $_relation    =  array(
        'id_medicion' => array(
            'table'     => 'productos_mediciones',
            'subjet'    => 'medicion'
        ),
        'id_impuesto' => array(
            'table'     => 'impuestos',
            'subjet'    => 'impuesto'
        ),
        'id_proveedor' => array(
            'table'     => 'proveedores',
            'subjet'    => 'proveedor'
        ),
        'id_marca' => array(
            'table'     => 'productos_marcas',
            'subjet'    => 'marca'
        ),
        'id_categoria' => array(
            'table'     => 'productos_categorias',
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
	
	
	
	function getProductos($filtro)
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
			
		return $this->getQuery($sql);			
	}
} 
?>