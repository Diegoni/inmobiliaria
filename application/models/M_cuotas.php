<?php 
class m_cuotas extends MY_Model 
{		
	protected $_tablename	= 'cuotas';
	protected $_id_table	= 'id_cuota';
	protected $_order		= 'id_cuota';
	protected $_relation    =  array(
        'id_contrato' => array(
            'table'     => 'contratos',
            'subjet'    => 'contrato'
        ),
        'id_cliente' => array(
            'table'     => 'clientes',
            'subjet'    => 'cliente'
        ),
        'id_inmueble' => array(
            'table'     => 'inmuebles',
            'subjet'    => 'inmueble'
        ),
        'id_estado' => array(
            'table'     => 'cuotas_estados',
            'subjet'    => 'estado'
        ),
        'id_forma_pago' => array(
            'table'     => 'formas_pagos',
            'subjet'    => 'forma_pago'
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
    
    function getCuotas($filtros)
    {
        $where = " id_cliente = '$filtros[id_cliente]' ";
        $where .= " AND id_inmueble = '$filtros[id_inmueble]' ";
        
        if($filtros['impaga'] == 1)
        {
            $estados[] = " cuotas.id_estado = '1' ";
        }
        
        if($filtros['paga'] == 1)
        {
            $estados[] = " cuotas.id_estado = '2' ";
        }
        
        if($filtros['vencida'] == 1)
        {
            $estados[] = " cuotas.id_estado = '3' ";
        }
        
        if($filtros['emitida'] == 1)
        {
            $estados[] = " cuotas.id_estado = '4' ";
        }
        
        if(isset($estados))
        {
            $where .= " AND (";
            foreach ($estados as $estado) 
            {
                $where .= $estado." OR ";
            }
            
            $where = substr($where, 0, -3);
            $where .= " )";
        }
        
        $query = "
        SELECT 
            * 
        FROM 
            $this->_tablename 
        INNER JOIN 
            cuotas_estados ON(cuotas_estados.id_estado = $this->_tablename.id_estado)
        WHERE ".$where;
        
        log_message('debug', 'query '.$query);
        
        return $this->getQuery($query);
    }
} 
?>