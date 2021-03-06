<?php
/**
 * Pr�-Cadastro Analise - extend da classe cadastro_pre
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
	/**Gen�ro da consultora. @name $genero */
	var $genero = '';
	/**Se � avalista proprio ou n�o. @name $avalista */
	var $avalista = '';
	/**C�digo do avalista, caso n�o possua avalista recebera seu pr�prio c�digo. @name $avalista_cod */
	var $avalista_cod = '';
	/**Dist�ncia da moradia da consultora em rel��o a Fonzaghi. @name $dist_moradia */
	var $dist_moradia = '';
	/**Patrim�nio da consultora. @name $patrimonio */
	var $patrimonio = '';
	/**Renda familiar soma do sal�rio com outros complementos. @name $renda_familiar */
	var $renda_familiar = 0;
	/**Experi�ncia em vendas. @name $xp_vendas */
	var $xp_vendas = 0;
	/**Estado civil da consultora. @name $estado_civil */
	var $estado_civil = '';
	/**Referencias da consultora. @name $referencia */
	var $referencia = '';
	/**Tempo de uni�o em anos. @name $tempo_uniao */
	var $tempo_uniao = 0;
	/**Tempo de moradia em anos. @name $tempo_moradia */
	var $tempo_moradia = 0;
	/**Tempo de emprego no atual emprego. @name $tempo_emprego */
	var $tempo_emprego = 0;
	/**Valor total das restri��es. @name $TTrestricoes_vlr */
	var $TTrestricoes_vlr = '';
	/**Total de restri��es CHQs e SPCs. @name $TTrestricoes */
	var $TTrestricoes = '';
	/**Restri��es acp*/
	var $restricoes = '';
	/**Restri��es acp*/
	var $restricoesACP = array();
	/**Consultantes acp*/
	var $informantesACP = array();
	/**Total dos pontos calculados segundo criterios de avali��o. @name $TTpontos */
	var $TTpontos = 0;
	/**Latitude da Fonzaghi para ser utilizado no calculo da dist�ncia. @name $latF*/
	var $latF = -25.427985;
	/**Longitude da Fonzaghi para ser utilizado no calculo da dist�ncia. @name $longF*/
	var $longF = -49.27563;
	/**Latitude da Consultora para ser utilizado no calculo da dist�ncia. @name $latC*/
	var $latC = 0;
	/**Longitude da Consultora para ser utilizado no calculo da dist�ncia. @name $longC*/
	var $longC = 0;
	/**Pesos utilizados no calculo dos pontos. @name $pesos */
	var $pesos = array();
	/**Contador auxiliar nas fun��es. @name $ct */
	var $ct = 0;
	/**
	 * Construtor seta os pesos a serem utilizados pelos m�todos que calculam as pontua��es
	 */
	function __construct() {
		$this -> pesos = array(1,4,2,1,3,3,3,2,1,4,1,4);
	}

	/**
	 * Seta atributos do objeto pelo c�digo do cliente e sequencia
	 */

	function obter_dados($cliente = '', $seq = '') {
		if (strlen($cliente) > 0) {
			$this -> cliente = $cliente;
			$this -> seq = $seq;
		}
		$this -> recupera_dados_pelo_codigo();
		$this -> recuperar_codigo_complemento();
		$this -> recupera_referencia_pelo_codigo();
		$this->ultimo_endereco_cliente();
		$this -> calcular_restricoes();
		$this -> cpf = $this -> line['pes_cpf'];
		$nasc = $this -> line['pes_nasc'];
		$this -> idade = $this->mostra_idade($nasc);
		$this -> genero = $this -> line['pes_genero'];
		$this -> avalista = $this -> line['pes_avalista'];
		$this -> avalista_cod = $this -> line['pes_avalista_cod'];
		$this -> dist_moradia = $this -> calcular_distancia($this->latC,$this->longC);
		$this -> patrimonio = $this -> line_cmp['cmp_patrimonio'];
		$this -> patrimonio2 = $this -> line_cmp['cmp_patrimonio2'];
		$this -> renda_familiar = $this -> line_cmp['cmp_salario'] + $this -> line_cmp['cmp_salario_complementar']+ $this -> line_cmp['cmp_conjuge_salario'];
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
		$sx .= '<tr><td' . $sty1 . ' colspan="2">Endereco de moradia</td><td></td><td ' . $sty1 . 'colspan="5">'.$this->rua.' , '.$this->rua_num.' - '.$this->bairro.'</td></tr>';
		$sx .= '<tr><td class="pre_tabelaPT" rowspan="2" colspan="2">Pontuacao<br>' . $this -> TTpontos . '</td><td></td><td' . $sty1 . ' colspan="2">CEP : '.$this->cep.'</td><td' . $sty1 . 'colspan="3">'.$this->cidade.' - '.$this->estado.'</td></tr>';
		$sx .= '<tr><td></td><td' . $sty1 . ' colspan="3">Area de risco?</td><td ' . $sty1 . ' colspan="2">Sim/nao</td></tr>';
		$sx .= '<tr><td' . $sty1 . ' colspan="2" >Criterio</td><td></td><td' . $sty1 . ' colspan="2">Dados do Cadastro</td><td' . $sty1 . '>Peso</td><td' . $sty1 . '>P</td><td' . $sty1 . '>Pontos</td></tr>';
		$sx .= $this -> relatorio;
		$sx .= '</table></center>';
		$sx .= $this->aluguel_por_renda();
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
	 * Calcula as restri��es pela classe _class_acp.php
	 */
	function calcular_restricoes() {
		$acp = new acp;
		$acp -> calcular_restricoes($this -> cpf);
		$this -> TTrestricoes = $acp -> TTrestricoes;
		$this -> TTrestricoes_vlr = $acp -> TTrestricoes_vlr;
		$this -> restricoesACP = $acp->restricoesSPC;
		$this -> informantesACP = $acp->informantesSPC;
		$this -> complementarACP = $acp->complementarSPC;
		$this->restricoesACP();
		$this->informantesACP();
		$this->complementarACP();
		return (1);
	}
	
	function restricoesACP(){
		$sx = '<table class="left radius5 margin5 pad5 border1 orange_light" width="100%">';
		$sx .= '<tr><th width="10%" align="center">Data</th>
					<th width="10%" align="center">Valor</th>
					<th width="80%" align="left">Informante</th></tr>';
		foreach ($this -> restricoesACP as $key => $value) {
			$sx .= '<tr><td align="center" class="left radius5 margin5 pad5 border1 orange_light">'.stodbr($value[0]).'</td>
						<td align="center" class="left radius5 margin5 pad5 border1 orange_light">'.$value[1].'</td>
						<td align="left" class="left radius5 margin5 pad5 border1 orange_light">'.$value[2].'</td></tr>';	
		}
		$sx .= '</table>';
		$this -> restricoes = $sx;
		return($sx);
	}
	
	function informantesACP(){
		$sx = '<table class="left radius5 margin5 pad5 border1 orange_light" width="100%">';
		$sx .= '<tr><th width="10%" align="center">Tipo</th>
					<th width="10%" align="center">Data</th>
					<th width="80%" align="left">Consultante</th></tr>';
		foreach ($this -> informantesACP as $key => $value) {
			$sx .= '<tr><td align="center" class="left radius5 margin5 pad5 border1 orange_light">'.$value[0].'</td>
						<td align="center" class="left radius5 margin5 pad5 border1 orange_light">'.stodbr($value[1]).'</td>
						<td align="left" class="left radius5 margin5 pad5 border1 orange_light">'.$value[2].'</td></tr>';	
		}
		$sx .= '</table>';
		return($sx);
	}
	
	function complementarACP(){
		$sx = '<table class="left radius5 margin5 pad5 border1 orange_light" width="100%">';
		$sx .= '<tr><th width="100%" align="left">Complementar</th></tr>';
		foreach ($this -> complementarACP as $key => $value) {
			$sx .= '<tr><td align="left" class="pad5  orange_light">'.$value[0].'</td></tr>';	
		}
		$sx .= '</table>';
		 
		return($sx);
	}
	
	

	/**
	 * Faz a soma das pontua��es .
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
	 * Calcula total de restri��es e valor total das restri��es .
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
		$this -> relatorio .= '<tr><td ' . $sty1 . '>2</td>
									<td ' . $sty1 . '>Restricoes</td>
									<td></td>
									<td' . $sty2 . '>' . $this -> TTrestricoes .'   / R$ '.number_format($this -> TTrestricoes_vlr, 2, ',', '.') . '</td>
									<td' . $sty2 . '>Qtda/valor</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';

		return ($pt);
	}
	/**
	 * Alguel tem que ser inferior a 30% da renda familiar 
	 */
	function aluguel_por_renda(){
		
			if(($this->aluguel/$this->renda_familiar)<=0.3){
				return('');
			}else{
				$sx = '<br><a style="color:red;">***Valor do aluguel equivale a mais de 30% da renda familiar!!!</a>';
				return ($sx);	
			}
	}		
	

	/**
	 * Calcula pontos pela distancia da consultora em rel��o a Fonzaghi.
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
	 * Renda familiar � composta pelo salario da futura consultora + renda complementar.
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
	 * Calcula pontos pela experi�ncia em vendas.
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
	 * Calcula pontos pelo tempo de uni�o.
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
	 * Calcula pontos pelas refer�ncias fornecidas pela futura consultora.
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

		if($this->patrimonio==1 and $this->patrimonio2==1){
			$ptx = 1;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==1 and $this->patrimonio2==2){
			$ptx = 1;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==1 and $this->patrimonio2==3){
			$ptx = 2;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==2 and $this->patrimonio2==1){
			$ptx = 2;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==2 and $this->patrimonio2==2){
			$ptx = 3;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==2 and $this->patrimonio2==3){
			$ptx = 3;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==3 and $this->patrimonio2==1){
			$ptx = 4;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==3 and $this->patrimonio2==2){
			$ptx = 4;
			$pt = $ptx * $peso;
		}elseif($this->patrimonio==3 and $this->patrimonio2==3){
			$ptx = 4;
			$pt = $ptx * $peso;
		}else{
			$ptx = 0;
			$pt = $ptx * $peso;
		}
		
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>4 a</td>
									<td ' . $sty1 . '>Im�vel</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> sigla_patrimonio($this -> patrimonio) . '</td>
									<td' . $sty2 . ' rowspan="2">' . $peso . '</td>
									<td' . $sty2 . ' rowspan="2">' . $ptx . '</td>
									<td' . $sty2 . ' rowspan="2">' . $pt . '</td></tr>
								<tr><td ' . $sty1 . '>4 b</td>
									<td ' . $sty1 . '>Ve�culo</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> sigla_patrimonio($this -> patrimonio2) . '</td>
									';
		return ($pt);
	}

	function sigla_patrimonio($sigla) {
		switch ($sigla) {
			case '1' :
				$sig_nome = 'Nao tem/Alugado';
				break;
			case '2' :
				$sig_nome = 'Financiado';
				break;
			case '3' :
				$sig_nome = 'Quitado';
				break;
		}
		return ($sig_nome);
	}

	/**
	 * Calcula pontos pelo genero.
	 */
	function pontos_genero() {
		$peso = $this -> pesos[3];
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