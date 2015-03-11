<?php
/**
 * Pré-Cadastro Site - extend da classe cadastro_pre
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.15.10
 * @package _class
 * @subpackage _class_cadastro_pre_site.php
 */
require_once ('_class_cadastro_pre.php');

class cadastro_pre_site extends cadastro_pre {

	/**
	 * Lista cadastros pendetes do site
	 */
	function lista() {
		$sql = "select * from cad_site
				where	sit_status='@'
				";
		$rlt = db_query($sql);

		$sx = '<center><table width="1000px"><tr>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">Cadastro</th>';
		$sx .= '<th width="550px" align="left" class="tabelaTH">Nome</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">CPF</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">CEP</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">Cidade</th>';
		$sx .= '<th width="50px" align="center" class="tabelaTH">UF</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">DDD 1</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">Tel 1</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">DDD 2</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">Tel 2</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">E-mail</th>';
		$sx .= '<th width="100px" align="center" class="tabelaTH">Ação</th>';
		$sx .= '</tr>';

		while ($line = db_read($rlt)) {
			$tt++;
			$sx .= '<tr>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . stodbr($line['sit_data']) . '</td>';
			$sx .= '	<td align="left" class="tabela01 radius5">' . $line['sit_nome'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_cpf'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_cep'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_cidade'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_uf'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_ddd1'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_tel1'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_ddd2'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_tel2'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5">' . $line['sit_email'] . '</td>';
			$sx .= '	<td align="center" class="tabela01 radius5"><a href="pre_site_ed.php?dd0=' . $line['id_sit'] . '"><img src="../img/icone_editar.gif"></a></td>';
			$sx .= '</tr>';
		}

		$sx .= '<tr><th  align="center" class="tabela01 radius5" colspan="11">Total : ' . $tt . '</th></tr>';
		$sx .= '</table></center>';

		return ($sx);
	}

	function mostra($id) {
		
		$sql = "select * from cad_site
				where	id_sit=".$id."
				";
		$rlt = db_query($sql);

/*		
<{sit_numero: }>,
<{sit_bairro: }>,
<{sit_cidade: }>,
<{sit_uf: }>,
<{sit_propaganda1: }>,
<{sit_propaganda2: }>,
<{sit_log: }>,
<{sit_status: @}>);
 * 
 * 
 */
		if ($line = db_read($rlt)) {
			$sx .= '<center><table width="800px" class="tabela01 radius5">';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Cadastro:</td>';
			$sx .= '<td width="650px"align="left">'.stodbr($line['sit_data']) . '</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Nome:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_nome'] . '</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Cpf:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_cpf'] . '</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Telelefone 1:</td>';
			$sx .= '<td width="650px"align="left">('.$line['sit_ddd1'].')'.$line['sit_tel1'] . '</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Telelefone 2:</td>';
			$sx .= '<td width="650px"align="left">('.$line['sit_ddd2'].')'.$line['sit_tel2'] . '</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">E-mail:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_email'].'</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">CEP:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_cep'].'</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Logradouro:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_rua'].', '.$line['sit_numero'].'</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Bairro:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_bairro'].'</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Cidade:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_cidade'].'</td>';
			$sx .= '</tr>';
			$sx .= '<tr>';
			$sx .= '<td width="150px" align="right">Estado:</td>';
			$sx .= '<td width="650px"align="left">'.$line['sit_uf'].'</td>';
			$sx .= '</tr>';
			$sx .= '</table></center>';
		}
		
		return($sx);
	}

	function cp() {
		$cp = array();
		array_push($cp, array('$H8', 'id_sit', '', False, True));
		array_push($cp, array('$H20', 'sit_log', '', False, True));
		array_push($cp, array('$O @:Pendente&A:Finalizado', 'sit_status', 'Situação', False, True));
		array_push($cp, array('$B', '', 'Salvar', False, True));

		return ($cp);
	}

}
?>