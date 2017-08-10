<?php 
class m_vehiculos extends MY_Model 
{		
	protected $_tablename	= 'vehiculos';
	protected $_id_table	= 'id_vehiculo';
	protected $_order		= 'vehiculo';
	protected $_relation    = array(
        'id_categoria' => array(
            'table'     => 'vehiculos_categorias',
            'subjet'    => 'categoria'
        ),
        'id_marca' => array(
            'table'     => 'vehiculos_marcas',
            'subjet'    => 'marca'
        ),
		'id_modelo' => array(
            'table'     => 'vehiculos_modelos',
            'subjet'    => 'modelo'
        ),
        'id_version' => array(
            'table'     => 'vehiculos_versiones',
            'subjet'    => 'version'
        ),
        'id_condicion' => array(
            'table'     => 'vehiculos_condiciones',
            'subjet'    => 'condicion'
        ),
        'id_calculo' => array(
            'table'     => 'vehiculos_calculos',
            'subjet'    => 'calculo'
        ),
        'id_estado' => array(
            'table'     => 'vehiculos_estados',
            'subjet'    => 'estado'
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
    
/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Actualiza los precios de los vehiculos
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/    
        
    function actualizarCostos($id_vehiculo)
    {
        $sql = "
        SELECT 
            *
        FROM
            gastos
        WHERE 
            id_vehiculo = '$id_vehiculo' AND
            eliminado = '0'           
        ";
        
        $gastos = $this->getQuery($sql);
        $vehiculos = $this->getRegistros($id_vehiculo);
        
        foreach ($vehiculos as $row) 
        {
            $_registro = array(
                'precio_costo'  => $row->precio_toma,
                'id_calculo'    => $row->id_calculo, 
                'calculo'    => $row->calculo,
            );
        }
        
        // Suma Costo del Vehiculo
        if($gastos)
        {
            foreach ($gastos as $gasto) 
            {
                if($gasto->aumenta_costo == 1)
                {
                    $_registro['precio_costo'] = $_registro['precio_costo'] + $gasto->monto;
                }
            }    
        }
        
        // Cambio de costos del vehiculo
        if($_registro['id_calculo'] == 1)
        {
            $porcentaje = $_registro['calculo'] * $_registro['precio_costo'] / 100;
            $_registro['precio_venta'] = $_registro['precio_costo'] + $porcentaje; 
        }else if($_registro['id_calculo'] == 2)
        {
            $_registro['precio_venta'] = $_registro['precio_costo'] + $_registro['calculo'];
        }
        
        $where = array(
            'id_vehiculo' => $id_vehiculo,
        );  
        
        $this->update($_registro, $where);
    }
} 
?>