<?php 
class m_proyectos extends MY_Model 
{		
	protected $_tablename	= 'proyectos';
	protected $_id_table	= 'id_proyecto';
	protected $_order		= 'proyecto';
	protected $_relation    =  array(
        'id_tipo' => array(
            'table'     => 'proyectos_tipos',
            'subjet'    => 'tipo'
        ),
        'id_estado' => array(
            'table'     => 'proyectos_estados',
            'subjet'    => 'estado'
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
    
    
    function getProyectos($id_inmueble)
    {
        $sql = "
        SELECT
            $this->_tablename.*,
            localidades.localidad, 
            provincias.provincia,
            proyectos_tipos.tipo
        FROM
            $this->_tablename
        INNER JOIN 
            inmuebles ON(inmuebles.id_proyecto = $this->_tablename.id_proyecto)  
        INNER JOIN 
            localidades ON(localidades.id_localidad = $this->_tablename.id_localidad)               
        INNER JOIN 
            provincias ON(provincias.id_provincia = $this->_tablename.id_provincia)
         INNER JOIN 
            proyectos_tipos ON(proyectos_tipos.id_tipo = $this->_tablename.id_tipo)            
        WHERE
            inmuebles.id_inmueble = '$id_inmueble'";
            
        return $this->getQuery($sql);            
            
    }
} 
?>