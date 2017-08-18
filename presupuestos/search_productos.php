<?php
include_once('models/m_productos.php');

$term = trim(strip_tags(utf8_decode($_GET['term'])));//retrieve the search term that autocomplete sends
$m_productos = new m_productos();
$result = $m_productos->getProducto($term);

if($result)
{
	foreach ($result as $row) 
	{
		$row['value']	= stripslashes(utf8_encode($row['producto']));
		$row['id']		= (int)$row['id_producto'];
		$row['iva']		= (float)$row['precio_iva'];
		$row['precio']	= (float)$row['precio_venta'];
		$row_set[]		= $row;//build an array
	}
}

echo json_encode($row_set);//format the array into json data
?>