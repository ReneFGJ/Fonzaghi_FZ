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
	var $include_class = '../';
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
	
	function menu_mailing(){
		global $dd;
		$onclickR = '<a class="bt_sub_menu" onclick="mailing(\''.$dd[0].'\',\'MAILING_REMOVE\' );" >';
		$onclickP = '<a class="bt_sub_menu" onclick="mailing(\''.$dd[0].'\',\'MAILING_RETORNO\' );" >';
		$sx = '<table  class="cab_status" width="100%"><tr>
				<td width="50%">
					<div id="mailing_status" width="100%"></div>
				</td>
				<td width="50%">
					'.$onclickR.'REMOVER</a>				
					'.$onclickP.'RETORNO</a>
				</td>	
				</tr></table>
			';
		
		return($sx);
	}
							
	function mailing_remove($cliente){
		$sql = "update cadastro set cl_last=20990101 where cl_cliente='".$cliente."'";
		$rlt = db_query($sql);	
		$sx = '<div class="red_light fnt_black">CONSULTORA REMOVIDA!!!</div>';
		return($sx);
	}
	
	function mailing_retorno($cliente){
		$sql = "select * from cadastro where cl_cliente='$cliente'";	
		$sx = '<div class="green_light fnt_black">CONSULTORA RETORNADA!!!</div>';
		return($sx);
	}
					
}
?>