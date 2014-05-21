<?php
require("../_class/_class_rss.php");
header("Content-type: text/xml; charset=utf-8");
$rss = new rss;
$path = '../img/';
$vpath = '/fz/';

$rss->gerar_imagens($path,$vpath);
$rss->montar_rss();

echo $rss->tela;
?>
