<?php
include_once('models/m_clientes.php');

$term = trim(strip_tags(utf8_decode($_GET['term'])));//retrieve the search term that autocomplete sends
$m_clientes = new m_clientes();
$result = $m_clientes->getClientes($term);

if($result)
{
	foreach ($result as $row) 
	{
		$row['value']	= stripslashes(utf8_encode($row['cliente']));
		$row_set[]		= $row;//build an array
	}
}

echo json_encode($row_set);
?>