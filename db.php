<?php
    /**
     * DB
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2014 - sisDOC.com.br
	 * @access public
     * @version v0.14.17
	 * @package System
	 * @subpackage Database connection
    */
    header("Content-Type: text/html; charset=ISO-8859-1",true);
	
	/* Noshow Errors */
	$debug1 = 0; $debug2 = 0;
	date_default_timezone_set('Etc/GMT+2');
	if (file_exists('debug.txt')) 
		{ $debug1 = 7; $debug2 = 255; } 	
	
	ini_set('display_errors', $debug1);
	ini_set('error_reporting', $debug2);
	    
    if (!isset($include)) { $include = '_include/'; }
	else { $include .= '_include/'; }
	if (!(is_dir($include))) { $include = '../'.$include; }
	if (!(is_dir($include))) { $include = '../'.$include; }
	

	if (!isset($include_db)) { $include_db = '_db/'; }
	else { $include_db .= '_db/'; }
    ob_start();
	session_start();

	/* Path Directory */
	//$path_info = trim($_SERVER['PATH_INFO']);
	
	/* Set header param */
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);	

    $ip = $_SERVER['SERVER_ADDR'];
	if ($ip == '::1') { $ip = '127.0.0.1'; }
	
	//$charset = 'utf-8';
	$charset = 'ISO-8859-1';
	header('Content-Type: text/html; charset='.$charset);
	/* Include */
	require($include.'sisdoc_sql.php');
	//require($include.'_class_debug.php');
	require($include.'_class_msg.php');
	require($include.'_class_char.php');		


	global $cnn,$conn;
	//echo '<br><br>'.$cnn;
	//echo '<br><br>'.$conn;
	/* Leituras das Variaveis dd0 a dd99 (POST/GET) */
	$vars = array_merge($_GET, $_POST);
	$acao = troca($vars['acao'],"'",'�');
	for ($k=0;$k < 100;$k++)
		{
		$varf='dd'.$k;
		$varf=$vars[$varf];
		$dd[$k] = post_security($varf);
		}	
	
	/* Data base */
	$filename = $include_db."db_mysql_".$ip.".php";
	if (!(file_exists($filename)))
		{ $filename = '../'.$include_db."db_mysql_".$ip.".php"; }
	if (!(file_exists($filename)))
		{ $filename = '../../'.$include_db."db_mysql_".$ip.".php"; }
		
	if (file_exists($filename))
		{
			require($filename);
		} else {		
			if ($install != 1) 
				{
					echo 'redirecionando '.$filename;
					exit;
				redireciona('__install/index.php');
				
				if (!file_exists($file))
					{
						echo '<H1>Configuracao do sistema</h1>';
						require("db_config.php");
						exit;
					} else {
						echo 'Contacte o administrador, arquivo de configuracao invalida';
					}
				
		}	
	}	

	
$include_class = '../../fonzaghi/_class/';
function post_security($s)
	{
		$s = troca($s,'<','&lt;');
		$s = troca($s,'>','&gt;');
		$s = troca($s,'"','&quot;');
		//$s = troca($s,'/','&#x27;');
		$s = troca($s,"'",'&#x2F;');
		return($s);		
	}    
?>