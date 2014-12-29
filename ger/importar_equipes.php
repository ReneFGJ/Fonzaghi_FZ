<?
$include = '../';
require($include."cab.php");
require($include."sisdoc_debug.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require("../db_fghi_210.php");	
$sql = "select cl_cliente, cl_clientep from clientes where cl_clientep <>  '' ";
$rlt = db_query($sql);

$sql = "DROP TABLE cliente; CREATE TABLE cliente ( id_ce serial NOT NULL,  ce_cliente character(7),  ce_equipe character(7),  CONSTRAINT key_cliente_key PRIMARY KEY (id_ce) );  ";

$sql .= "insert into cliente (ce_cliente,ce_equipe) values ";
$ini = 0;
while ($line = db_read($rlt))
	{
	if ($ini > 0) { $sql .= ", "; }
	$sql .= "('".$line['cl_cliente']."','".$line['cl_clientep']."') ";
	$ini++;
	}
require("../db_ecaixa.php");	

$rlt = db_query($sql);
?>