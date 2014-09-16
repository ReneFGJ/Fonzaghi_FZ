<?php
/**
 * Pré-Cadastro Analise - extend da classe cadastro_pre
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.14.23
 * @package _class
 * @subpackage _class_cadastro_pre_analise.php
 */
require_once ('_class_cadastro_pre.php');

class cadastro_pre_analise extends cadastro_pre {
	/**CPF da consultora. @name $cpf */
	var $cpf = '';
	/**Idade da consultora. @name $idade */
	var $idade = '';
	/**Genêro da consultora. @name $genero */
	var $genero = '';
	/**Se é avalista proprio ou não. @name $avalista */
	var $avalista = '';
	/**Código do avalista, caso não possua avalista recebera seu próprio código. @name $avalista_cod */
	var $avalista_cod = '';
	/**Distância da moradia da consultora em relção a Fonzaghi. @name $dist_moradia */
	var $dist_moradia = '';
	/**Patrimônio da consultora. @name $patrimonio */
	var $patrimonio = '';
	/**Renda familiar soma do salário com outros complementos. @name $renda_familiar */
	var $renda_familiar = 0;
	/**Experiência em vendas. @name $xp_vendas */
	var $xp_vendas = 0;
	/**Estado civil da consultora. @name $estado_civil */
	var $estado_civil = '';
	/**Referencias da consultora. @name $referencia */
	var $referencia = '';
	/**Tempo de união em anos. @name $tempo_uniao */
	var $tempo_uniao = 0;
	/**Tempo de moradia em anos. @name $tempo_moradia */
	var $tempo_moradia = 0;
	/**Tempo de emprego no atual emprego. @name $tempo_emprego */
	var $tempo_emprego = 0;
	/**Valor total das restrições. @name $TTrestricoes_vlr */
	var $TTrestricoes_vlr = '';
	/**Total de restrições CHQs e SPCs. @name $TTrestricoes */
	var $TTrestricoes = '';
	/**Total dos pontos calculados segundo criterios de avalição. @name $TTpontos */
	var $TTpontos = 0;
	/**Latitude da Fonzaghi para ser utilizado no calculo da distância. @name $latF*/
	var $latF = -25.427985;
	/**Longitude da Fonzaghi para ser utilizado no calculo da distância. @name $longF*/
	var $longF = -49.27563;
	/**Latitude da Consultora para ser utilizado no calculo da distância. @name $latC*/
	var $latC = 0;
	/**Longitude da Consultora para ser utilizado no calculo da distância. @name $longC*/
	var $longC = 0;
	/**Pesos utilizados no calculo dos pontos. @name $pesos */
	var $pesos = array();
	/**Contador auxiliar nas funções. @name $ct */
	var $ct = 0;
	/**
	 * Construtor seta os pesos a serem utilizados pelos métodos que calculam as pontuações
	 */
	function __construct() {
		$this -> pesos = array(2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);
	}

	/**
	 * Seta atributos do objeto pelo código do cliente e sequencia
	 */

	function obter_dados($cliente = '', $seq = '') {
		if (strlen($cliente) > 0) {
			$this -> cliente = $cliente;
			$this -> seq = $seq;
		}
		$this -> recupera_dados_pelo_codigo();
		$this -> recuperar_codigo_complemento();
		$this -> recupera_referencia_pelo_codigo();
		$this -> calcular_restricoes();
		$this -> cpf = $this -> line['pes_cpf'];
		$nasc = $this -> line['pes_nasc'];
		$this -> idade = $this->mostra_idade($nasc);
		$this -> genero = $this -> line['pes_genero'];
		$this -> avalista = $this -> line['pes_avalista'];
		$this -> avalista_cod = $this -> line['pes_avalista_cod'];
		$this -> dist_moradia = $this -> calcular_distancia();
		$this -> patrimonio = $this -> line_cmp['cmp_patrimonio'];
		$this -> renda_familiar = $this -> line_cmp['cmp_salario'] + $this -> line_cmp['cmp_salario_complementar'];
		$this -> xp_vendas = $this -> line_cmp['cmp_experiencia_vendas'];
		$this -> estado_civil = $this -> line_cmp['cmp_estado_civil'];
		$this -> tempo_uniao = $this -> line_cmp['cmp_estado_civil_tempo'];
		$this -> tempo_moradia = $this -> line_cmp['cmp_imovel_tempo'];
		$this -> tempo_emprego = $this -> line_cmp['cmp_emprego_tempo'];
		$this -> aluguel = $this -> line_cmp['cmp_valor_aluguel'];
		return (1);
	}

	function mostrar_relatorio() {
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$sx = '<center><table class="pre_tabela">';
		$sx .= '<tr><td' . $sty1 . 'colspan="2">Nome da candidata a consultora</td><td></td><td colspan="5"' . $sty1 . '>' . $this -> nome . '</td></tr>';
		$sx .= '<tr><td' . $sty1 . ' colspan="2">Endereco de moradia</td><td></td><td ' . $sty1 . 'colspan="5">Nome da rua</td></tr>';
		$sx .= '<tr><td class="pre_tabelaPT" rowspan="2" colspan="2">Pontuacao<br>' . $this -> TTpontos . '</td><td></td><td' . $sty1 . ' colspan="2">cep</td><td' . $sty1 . 'colspan="3">cidade</td></tr>';
		$sx .= '<tr><td></td><td' . $sty1 . ' colspan="3">Area de risco?</td><td ' . $sty1 . ' colspan="2">Sim/nao</td></tr>';
		$sx .= '<tr><td' . $sty1 . ' colspan="2" >Criterio</td><td></td><td' . $sty1 . ' colspan="2">Dados do Cadastro</td><td' . $sty1 . '>Peso</td><td' . $sty1 . '>P</td><td' . $sty1 . '>Pontos</td></tr>';
		$sx .= $this -> relatorio;
		$sx .= '</table></center>';

		//$sx .= '<tr><td '.$sty.'>4 a </td><td '.$sty.'>Veiculo</td><td'.$sty.'>4</td><td></td></tr>';
		//$sx .= '<tr><td '.$sty.'>4 b</td><td '.$sty.'>Imovel</td><td'.$sty.'></td><td></td></tr>';

		return ($sx);
	}

	/**
	 * autor codigo base - Cesar Bagatoli - http://www.cesar.inf.br/blog/?p=273
	 * distancia entre 2 pontos por latitude e longitude
	 * $p1LA - ponto latitude 1
	 * $p1LO - ponto longtude 1
	 * $p2LA - ponto latitude 2
	 * $p2LO - ponto longtude 2
	 * retorna em metros
	 */
	function calcular_distancia($p1LA = 0, $p1LO = 0) {
		$p2LA = $this -> latF;
		$p2LO = $this -> longF;

		if ($p1LA == 0) {
			$p1LA = $this -> latC;
		}
		if ($p1LO == 0) {
			$p1LO = $this -> longC;
		}
		//raio
		$r = 6371.0;

		$p1LA = $p1LA * pi() / 180.0;
		$p1LO = $p1LO * pi() / 180.0;
		$p2LA = $p2LA * pi() / 180.0;
		$p2LO = $p2LO * pi() / 180.0;

		$dif_latitude = $p2LA - $p1LA;
		$dif_longitude = $p2LO - $p1LO;

		$a = sin($dif_latitude / 2) * sin($dif_latitude / 2) + cos($p1LA) * cos($p2LA) * sin($dif_longitude / 2) * sin($dif_longitude / 2);
		$aa = sqrt($a);
		$ab = sqrt(1 - $a);
		$c = atan2($aa, $ab) * 2;
		//$metros = round($r * $c * 1000); //em metros
		$km = round($r * $c);
		// em kilometros

		return $km;

	}

	/**
	 * Calcula as restrições pela classe _class_acp.php
	 */
	function calcular_restricoes() {
		$acp = new acp;
		$acp -> calcular_restricoes($this -> cpf);
		$this -> TTrestricoes = $acp -> TTrestricoes;
		$this -> TTrestricoes_vlr = $acp -> TTrestricoes_vlr;
		return (1);
	}

	/**
	 * Faz a soma das pontuações .
	 */
	function calcular_pontuacao() {
		$this -> TTpontos += $this -> pontos_idade();
		$this -> TTpontos += $this -> pontos_genero();
		$this -> TTpontos += $this -> pontos_vlr_restricoes();
		$this -> TTpontos += $this -> pontos_distancia();
		$this -> TTpontos += $this -> pontos_patrimonio();
		$this -> TTpontos += $this -> pontos_renda();
		$this -> TTpontos += $this -> pontos_xp_vendas();
		$this -> TTpontos += $this -> pontos_estado_civil();
		$this -> TTpontos += $this -> pontos_referencia();
		$this -> TTpontos += $this -> pontos_uniao();
		$this -> TTpontos += $this -> pontos_tempo_moradia();
		$this -> TTpontos += $this -> pontos_tempo_emprego();
	}

	/**
	 * Calcula pontos pela idade .
	 */
	function pontos_idade() {
		$peso = $this -> pesos[0];
		if (18 >= $this -> idade and $this -> idade <= 21) {
			$pt = 1 * $peso;
		}
		if (22 >= $this -> idade and $this -> idade <= 30) {
			$pt = 2 * $peso;
		}
		if (31 >= $this -> idade and $this -> idade <= 45) {
			$pt = 3 * $peso;
		}
		if ($this -> idade > 45) {
			$pt = 4 * $peso;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>1</td>
								<td ' . $sty1 . '>Idade</td>
								<td></td>
								<td' . $sty2 . '>' . $this -> idade . '</td>
								<td' . $sty2 . '>anos</td>
								<td' . $sty2 . '>' . $peso . '</td>
								<td' . $sty2 . '>' . $pt / $peso . '</td>
								<td' . $sty2 . '>' . $pt . '</td></tr>';

		return ($pt);
	}

	/**
	 * Calcula total de restrições e valor total das restrições .
	 */
	function pontos_vlr_restricoes() {
		$peso = $this -> pesos[1];
		if ($this -> TTrestricoes_vlr == 0) {
			$pt = 0;
		}
		if ($this -> TTrestricoes_vlr >= 0 and $this -> TTrestricoes_vlr < 100) {
			$pt = 3 * $peso;
		}
		if ($this -> TTrestricoes_vlr >= 100 and $this -> TTrestricoes_vlr < 1000) {
			$pt = 2 * $peso;
		}
		if ($this -> TTrestricoes_vlr >= 1000) {
			$pt = 1 * $peso;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>2 a</td>
									<td ' . $sty1 . '>N restricoes</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> TTrestricoes . '</td>
									<td' . $sty2 . ' colspan="3"></td>
									</tr>';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>2 b</td>
									<td ' . $sty1 . '>Valor das restricoes</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . number_format($this -> TTrestricoes_vlr, 2, ',', '.') . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';

		return ($pt);
	}

	/**
	 * Calcula pontos pela distancia da consultora em relção a Fonzaghi.
	 */
	function pontos_distancia() {
		$peso = $this -> pesos[2];
		if ($this -> dist_moradia > 10) {
			$pt = 1 * $peso;
		}
		if (5 < $this -> dist_moradia and $this -> dist_moradia <= 10) {
			$pt = 2 * $peso;
		}
		if (2 < $this -> dist_moradia and $this -> dist_moradia <= 5) {
			$pt = 3 * $peso;
		}
		if ($this -> dist_moradia < 2) {
			$pt = 4 * $peso;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>3</td>
									<td ' . $sty1 . '>Distancia da moradia</td>
									<td></td>
									<td' . $sty2 . '>' . $this -> dist_moradia . '</td>
									<td' . $sty2 . '>Km</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Calcula pontos pela renda familiar.
	 * Renda familiar é composta pelo salario da futura consultora + renda complementar.
	 */
	function pontos_renda() {
		$peso = $this -> pesos[4];
		$pt = 0;
		$renda = $this -> renda_familiar;
		if ($renda == 0) {
			$pt = 0 * $peso;
		}
		if ($renda > 10000) {
			$pt = 4 * $peso;
		}
		if ($renda > 5000 and $renda <= 10000) {
			$pt = 3 * $peso;
		}
		if ($renda > 2000 and $renda <= 5000) {
			$pt = 2 * $peso;
		}
		if ($renda > 0 and $renda <= 2000) {
			$pt = 1 * $peso;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>5</td>
									<td ' . $sty1 . '>Renda mensal</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . number_format($this -> renda_familiar, 2, ',', '.') . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Calcula pontos pela experiência em vendas.
	 */
	function pontos_xp_vendas() {
		$peso = $this -> pesos[5];

		if ($this -> xp_vendas == 0) {
			$pt = 1 * $peso;
		}
		if (0 < $this -> xp_vendas and $this -> xp_vendas <= 1) {
			$pt = 2 * $peso;
		}
		if (1 < $this -> xp_vendas and $this -> xp_vendas <= 3) {
			$pt = 3 * $peso;
		}
		if (3 < $this -> xp_vendas) {
			$pt = 4 * $peso;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>6</td>
									<td ' . $sty1 . '>Experiencia com vendas</td>
									<td></td>
									<td' . $sty2 . '>' . $this -> xp_vendas . '</td>
									<td' . $sty2 . '>anos</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Calcula pontos pelo tempo de união.
	 */
	function pontos_uniao() {
		$peso = $this -> pesos[6];

		if ($this -> tempo_uniao == 0) {
			$pt = 0 * $peso;
		}
		if (0 < $this -> tempo_uniao and $this -> tempo_uniao <= 1) {
			$pt = 1 * $peso;
		}
		if (1 < $this -> tempo_uniao and $this -> tempo_uniao <= 5) {
			$pt = 2 * $peso;
		}
		if (5 < $this -> tempo_uniao and $this -> tempo_uniao <= 10) {
			$pt = 3 * $peso;
		}
		if (10 < $this -> tempo_uniao) {
			$pt = 4 * $peso;
		}

		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>9 a</td>
									<td ' . $sty1 . '>Tempo de uniao</td>
									<td></td>
									<td' . $sty2 . '>' . $this -> tempo_uniao . '</td>
									<td' . $sty2 . '>anos</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Calcula pontos pelo tempo do emprego atual.
	 */
	function pontos_tempo_emprego() {
		$peso = $this -> pesos[7];
		if ($this -> tempo_emprego == 0) {
			$pt = 0 * $peso;
		}
		if (0 < $this -> tempo_emprego and $this -> tempo_emprego <= 1) {
			$pt = 1 * $peso;
		}
		if (1 < $this -> tempo_emprego and $this -> tempo_emprego <= 3) {
			$pt = 2 * $peso;
		}
		if (3 < $this -> tempo_emprego and $this -> tempo_emprego <= 5) {
			$pt = 3 * $peso;
		}
		if (5 < $this -> tempo_emprego) {
			$pt = 4 * $peso;
		}

		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>9 c</td>
									<td ' . $sty1 . '>Tempo de emprego</td>
									<td></td>
									<td' . $sty2 . '>' . $this -> tempo_emprego . '</td>
									<td' . $sty2 . '>anos</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Calcula pontos pelo estado civil.
	 */
	function pontos_estado_civil() {
		$peso = $this -> pesos[8];
		if ($this -> estado_civil == 'S' or $this -> estado_civil == 'D') {
			$pt = 0 * $peso;
		}
		if ($this -> estado_civil == 'E') {
			$pt = 1 * $peso;
		}
		if ($this -> estado_civil == 'V') {
			$pt = 2 * $peso;
		}
		if ($this -> estado_civil == 'C') {
			$pt = 3 * $peso;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>7</td>
									<td ' . $sty1 . '>Estado civil</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> estado_civil($this -> estado_civil) . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Traduz sigla do estado civil.
	 */
	function estado_civil($sigla) {
		switch ($sigla) {
			case 'C' :
				$sx = 'Casada';
				break;
			case 'S' :
				$sx = 'Solteira';
				break;
			case 'D' :
				$sx = 'Divorciada';
				break;
			case 'V' :
				$sx = 'Viuva';
				break;
			case 'E' :
				$sx = 'Uniao estavel';
				break;
			default :
				$sx = $sigla;
				break;
		}
		return ($sx);
	}

	/**
	 * Calcula pontos pelo tempo de moradia.
	 */
	function pontos_tempo_moradia() {
		$peso = $this -> pesos[9];
		if ($this -> tempo_moradia == 0) {
			$pt = 0 * $peso;
		}
		if (0 < $this -> tempo_moradia and $this -> tempo_moradia <= 1) {
			$pt = 1 * $peso;
		}
		if (1 < $this -> tempo_moradia and $this -> tempo_moradia <= 5) {
			$pt = 2 * $peso;
		}
		if (5 < $this -> tempo_moradia and $this -> tempo_moradia <= 10) {
			$pt = 3 * $peso;
		}
		if (10 < $this -> tempo_moradia) {
			$pt = 4 * $peso;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>9 b</td>
									<td ' . $sty1 . '>Tempo de moradia</td>
									<td></td>
									<td' . $sty2 . '>' . $this -> tempo_moradia . '</td>
									<td' . $sty2 . '>anos</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Calcula pontos pelas referências fornecidas pela futura consultora.
	 */
	function pontos_referencia() {
		$this -> ct = 0;
		foreach ($this->referencias as $key => $value) {
			$grau = $value['ref_grau'];
			$peso = $value['ret_peso'];
			$tipo = $value['ret_nome'];
		
			$sty1 = ' class="pre_tabelaTH"';
			$sty2 = ' class="pre_tabela01"';
			$this -> relatorio .= '<tr><td ' . $sty1 . '>8 &#' . ($this -> ct + 97) . '</td>
										<td ' . $sty1 . '>Tipo de referencia</td>
										<td></td>
										<td' . $sty2 . ' colspan="2">'.$tipo.'</td>
										<td' . $sty2 . '>' . $peso . '</td>
										<td' . $sty2 . '>1</td>
										<td' . $sty2 . '>' . $peso . '</td></tr>';
			$this -> ct++;
			$pt = $peso+$pt;
		}

		return ($pt);
	}

	/**
	 * Calcula pontos pelo tempo de moradia.
	 */
	function pontos_patrimonio() {
		$peso = $this -> pesos[11];

		switch ($this->patrimonio) {
			case '1' :
				$ptx = 1;
				$pt = $ptx * $peso;
				break;
			case '2' :
				$ptx = 2;
				$pt = $ptx * $peso;
				break;
			case '3' :
				$ptx = 3;
				$pt = $ptx * $peso;
				break;
			case '4' :
				$ptx = 4;
				$pt = $ptx * $peso;
				break;
			default :
				break;
		}

		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>4</td>
									<td ' . $sty1 . '>Tempo de moradia</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> sigla_patrimonio($this -> patrimonio) . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $ptx . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	function sigla_patrimonio($sigla) {
		switch ($sigla) {
			case '1' :
				$sig_nome = 'Nao tem';
				break;
			case '2' :
				$sig_nome = 'Auto F';
				break;
			case '3' :
				$sig_nome = 'Imovel F + Auto F/Q';
				break;
			case '4' :
				$sig_nome = 'Imovel Q + Auto Q';
				break;
			default :
				$sig_nome = 'Verificar com TI, novo patrimonio adicionado';
				break;
		}
		return ($sig_nome);
	}

	/**
	 * Calcula pontos pelo genero.
	 */
	function pontos_genero() {
		$peso = $this -> pesos[11];
		switch (trim($this -> genero)) {
			case 'F' :
				$pt = 3 * $peso;
				break;
			case 'M' :
				$pt = 1 * $peso;
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>2</td>
									<td ' . $sty1 . '>Genero</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> genero . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

}
?>