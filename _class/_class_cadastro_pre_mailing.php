<?php
/**
 * Pré-Cadastro Mailing - extend da classe cadastro_pre
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.14.38
 * @package _class
 * @subpackage _class_cadastro_pre_mailing.php
 */
require_once ('_class_cadastro_pre.php');

class cadastro_pre_mailing extends cadastro_pre {
	
	function row_mailing(){
		global $tabela,$http_edit,$http_edit_para,$cdf,$cdm,$masc,$offset,$order;
        $tabela = "cadastro";
        $label = "Consultoras inativas mais de 6 meses";
        $http_edit = 'pre_cad_mailing_ed.php'; 
        $offset = 20;
        $order  = "cl_last";
        
        $cdf = array('cl_cliente','cl_cliente','cl_nome','cl_dtcadastro','cl_last');
        $cdm = array('ID','Codigo','Nome','Cadastro','Ultimo movimento');
        $masc = array('','','','','','','');
        return(true);
	}
}
?>