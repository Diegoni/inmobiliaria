<?php
include_once('models/m_presupuestos.php');
include_once('models/m_presupuestos_renglones.php');

$fecha				= date('Y-m-d H:i:s');
$monto				= $_POST['total'];
$id_cliente			= $_POST['cliente'];
$forma_pago			= $_POST['forma_pago'];
$estado				= $_POST['estado'];
$dto				= $_POST['desc'];
$id_vendedor   		= $_POST['vendedor'];
$comentario			= $_POST['comentario'];
$com_publico  		= $_POST['com_publico'];

$codigos_a_cargar	= $_POST['codigos_art'];
$cant_a_cargar		= $_POST['cantidades'];
$precios_a_cargar	= $_POST['precios'];

/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Cargo Presupuesto
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  

$m_presupuesto = new m_presupuestos();

$registro = array(
	'fecha'			=> $fecha, 
	'monto'			=> $monto, 
	'id_cliente'	=> $id_cliente,
	'id_forma_pago'	=> $forma_pago,
	'estado'		=> $estado,
	'descuento'		=> $dto, 
	'id_vendedor'	=> $id_vendedor, 
	'comentario'	=> $comentario, 
	'com_publico'	=> $com_publico,
	
);

$id_presupuesto = $m_presupuesto->insert($registro);


/*--------------------------------------------------------------------------------- 
-----------------------------------------------------------------------------------  
            
       Cargo Renglon Presupuesto
  
----------------------------------------------------------------------------------- 
---------------------------------------------------------------------------------*/  

$m_renglones = new m_presupuestos_renglones();

$codigos_cargados = array();

for ($i=0; $i<count($codigos_a_cargar); $i++ ) 
{
	if(in_array($codigos_a_cargar[$i], $codigos_cargados))
	{
		$file = fopen("carga_presupuestos.log", "a");
		fwrite($file, date('Y-m-d H:i:s'). "El presupuesto nro ".$id_presupuesto." esta repitiendo los codigos\n" . PHP_EOL);
		fclose($file);
	}else
	{
		$registro = array(
			'id_presupuesto'	=> $id_presupuesto,
			'id_producto'		=> $codigos_a_cargar[$i],
			'cantidad'			=> $cant_a_cargar[$i],
			'precio'			=> $precios_a_cargar[$i],
			'estado'			=> 1
		);
		
		$m_renglones->insert($registro);
	}
}
?>