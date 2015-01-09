<?
    /**
     * Ged - Download file
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.11.29
	 * @package index
	 * @subpackage ged
    */
    
$nocab = 1;
require ("../db.php");


	/* Mensagens */
	$tabela = 'ged_upload';
	
$id = $dd[0];
$secu = uppercase($secu);
$chk1 = checkpost($id.$secu);
$secu = '';
$chk2 = checkpost($id);

$secu = $dd[91];
$chk1 = checkpost($id.$secu);

if (($dd[90] == $chk1) or ($dd[90] == $chk2))
	{
	require("_ged_config.php");
	if (strlen($dd[50]) > 0)
		{ $ged->tabela = $dd[50]; }
		echo $ged->download($id);
	} else {
		echo msg('erro_post');
	}
?>