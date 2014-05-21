<?php
/*
 * @author Raimundo Oliveira Junior
 * @email jrdesing@gmail.com
 * 
 */
 
// dados do banco Mysql
$local = "localhost";
$usuario = "root";
$senha = "";
$banco = "banco";
 
$connect = mysql_connect("$local","$usuario","$senha") or die("ERRO AO CONECTAR AO MYSQL, VERIFIQUE COM O ADMINISTRADOR" . mysql_error());
mysql_select_db("$banco") or die("BASE DE DADOS INVÁLIDO");
 
$data = date("d/m/Y");
 
 
$sql = "SELECT * FROM artigos";
 
$query = mysql_query($sql);
 
// print o cabeçalho do xml
header("Content-type: application/xml");
 
// cabeçalho do RSS
echo "<?xml version="1.0" encoding="ISO-8859-1" ?>";
?>
<rss version="2.0">
    <channel>
        <title>Titulo site - Notícias</title>
        <link>Link do site</link>
        <description>Breve descrição sobre o conteudo do site</description>
        <language>pt-br</language>
        <copyright>Site - Todos os direitos reservados.</copyright>
        <lastBuildDate><?=$data;?></lastBuildDate>
        <ttl>20</ttl>
        <?php
        while($result = mysql_fetch_array($query)) {
        ?>
            <item>
                <title><?=$result[titulo];?></title>
                <autor><?=$result[autor];?></autor>
                <description><?=$result[texto];?></description>
                <datePosted><?=date("d-m-Y",strtotime($result[data]));?></datePosted>
            </item>
        <?php
        }
        fechaBD();
        ?>
    </channel>
</rss>
