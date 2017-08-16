<?php
include_once('models/m_articulos.php');

$term = trim(strip_tags(utf8_decode($_GET['term'])));//retrieve the search term that autocomplete sends
$m_articulos = new m_articulos();
$result = $m_articulos->getArticulo($term);

if($result)
{
	foreach ($result as $row) 
	{
		$row['value']	= stripslashes(utf8_encode($row['value']));
		$row['id']		= (int)$row['id_articulo'];
		$row['iva']		= (float)$row['porc_iva'];
		$row['precio']	= (float)$row['precio_venta_sin_iva_con_imp'];
		$row_set[]		= $row;//build an array
	}
}

echo json_encode($row_set);//format the array into json data
?>