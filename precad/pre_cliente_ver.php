<?php
require("cab.php");
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

$pre->le($dd[0]);

echo $pre->mostra();

?>
