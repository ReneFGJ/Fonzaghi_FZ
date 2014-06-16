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
	/**
	 * Construtor seta os pesos a serem utilizados pelos m�todos que calculam as pontua��es
	 */
	function __construct() {
		$this -> pesos = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
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
		$this -> calcular_restricoes();
		$this -> cpf = $this -> line['pes_cpf'];
		$nasc = $this -> line['pes_nasc'];
		$this -> idade = idade($nasc, 'en');
		$this -> genero = $this -> line['pes_genero'];
		$this -> avalista = $this -> line['pes_avalista'];
		$this -> avalista_cod = $this -> line['pes_avalista_cod'];
		$this -> dist_moradia = $this -> calcular_distancia();
		$this -> patrimonio = '';
		$this -> renda_familiar = $this -> line_cmp['cmp_salario'] + $this -> line_cmp['cmp_salario_complementar'];
		$this -> xp_vendas = $this -> line_cmp['cmp_experiencia_vendas'];
		$this -> estado_civil = $this -> line_cmp['cmp_estado_civil'];
		$this -> referencia = '';
		$this -> tempo_uniao = $this -> line_cmp['cmp_estado_civil_tempo'];
		$this -> tempo_moradia = $this -> line_cmp['cmp_imovel_tempo'];
		$this -> tempo_emprego = $this -> line_cmp['cmp_emprego_tempo'];
		$this -> aluguel = $this -> line_cmp['cmp_valor_aluguel'];
		return (1);
	}

	function mostrar_relatorio() {
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$sx = '<table>';
		$sx .= '<tr><td' . $sty1 . 'colspan="2">Nome da candidata a consultora</td><td ' . $sty1 . ' colspan="7">' . $this -> nome . '</td></tr>';
		$sx .= '<tr><td' . $sty1 . ' colspan="2">Endereco de moradia</td><td ' . $sty1 . 'colspan="7">Nome da rua</td></tr>';
		$sx .= '<tr><td colspan="2"></td><td' . $sty1 . ' colspan="3">cep</td><td' . $sty1 . 'colspan="4">cidade</td></tr>';
		$sx .= '<tr><td colspan="2"></td><td' . $sty1 . ' colspan="5">Area de risco?</td><td ' . $sty1 . ' colspan="2">Sim/nao</td></tr>';
		$sx .= '<tr><td' . $sty1 . ' colspan="2" >Criterio</td><td' . $sty1 . '>T*</td><td></td><td' . $sty1 . ' colspan="2">Dados do Cadastro</td><td' . $sty1 . '>Peso</td><td' . $sty1 . '>P</td><td' . $sty1 . '>Pontos</td></tr>';
		$sx .= $this -> relatorio;
		$sx .= '</table>';

		//$sx .= '<tr><td '.$sty.'>4 a </td><td '.$sty.'>Veiculo</td><td'.$sty.'>4</td><td></td></tr>';
		//$sx .= '<tr><td '.$sty.'>4 b</td><td '.$sty.'>Imovel</td><td'.$sty.'></td><td></td></tr>';
		//$sx .= '<tr><td '.$sty.'>8</td><td '.$sty.'>Tipo de referencia</td><td'.$sty.'>8</td><td></td></tr>';

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
		return (1);
	}

	/**
	 * Faz a soma das pontua��es .
	 */
	function calcular_pontuacao() {
		$this -> TTpontos += $this -> pontos_idade();
		$this -> TTpontos += $this -> pontos_vlr_restricoes();
		$this -> TTpontos += $this -> pontos_distancia();
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
		switch ($this->idade) {
			case (18>=$this->idade and $this->idade<=21) :
				$pt = 1 * $peso;
				break;
			case (22>=$this->idade and $this->idade<=30) :
				$pt = 2 * $peso;
				break;
			case (31>=$this->idade and $this->idade<=45) :
				$pt = 3 * $peso;
				break;
			case ($this->idade>45) :
				$pt = 4 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>1</td>
								<td ' . $sty1 . '>Idade</td>
								<td' . $sty2 . '>1</td>
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

		switch ($this->TTrestricoes_vlr) {
			case (0<=$this->TTrestricoes_vlr and $this->TTrestricoes_vlr<100) :
				$pt = 3 * $peso;
				break;
			case (100<=$this->TTrestricoes_vlr and $this->TTrestricoes_vlr<1000) :
				$pt = 2 * $peso;
				break;
			case (1000<=$this->TTrestricoes_vlr) :
				$pt = 1 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>2 a</td>
									<td ' . $sty1 . '>N restricoes</td>
									<td' . $sty2 . '>Qtda</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> TTrestricoes . '</td>
									<td' . $sty2 . ' colspan="3"></td></tr>';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>2 b</td>
									<td ' . $sty1 . '>Valor das restricoes</td>
									<td' . $sty2 . '>2</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . number_format($this -> TTrestricoes_vlr, 2, ',', '.') . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';

		return ($pt);
	}

	/**
	 * Calcula pontos pela distancia da consultora em rel��o a Fonzaghi.
	 */
	function pontos_distancia() {
		$peso = $this -> pesos[2];
		switch ($this->dist_moradia) {
			case ($this->dist_moradia>10) :
				$pt = 1 * $peso;
				break;
			case (5<$this->dist_moradia and $this->dist_moradia<=10) :
				$pt = 2 * $peso;
				break;
			case (2<$this->dist_moradia and $this->dist_moradia<=5) :
				$pt = 3 * $peso;
				break;
			case ($this->dist_moradia<2) :
				$pt = 4 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>3</td>
									<td ' . $sty1 . '>Distancia da moradia</td>
									<td' . $sty2 . '>3</td>
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
		echo '-----------------REVER RENDA FAMILIAR, CONDI��ES APLICADAS 
			N�O EST�O FUNCIONANDOS PELO SWITCH-(' . $this -> renda_familiar . ')-----------------';
		if ($this -> renda_familiar > 1000) {
			echo '=======+++aqui+++========';
		}
		$renda = $this -> renda_familiar;
		switch ($renda) {

			case (10000<$renda) :
				$pt = 4 * $peso;
				break;
			case (5000<$renda and $renda<=10000) :
				$pt = 3 * $peso;
				break;
			case (2000>$renda and $renda<=5000) :
				$pt = 2 * $peso;
				break;
			case ($renda<=2000) :
				$pt = 1 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>5</td>
									<td ' . $sty1 . '>Renda mensal</td>
									<td' . $sty2 . '>5</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . number_format($this -> renda_familiar, 2, ',', '.') . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>-----' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Calcula pontos pela experi�ncia em vendas.
	 */
	function pontos_xp_vendas() {
		$peso = $this -> pesos[5];
		switch ($this->xp_vendas) {
			case ($this->xp_vendas==0) :
				$pt = 1 * $peso;
				break;
			case (0<$this->xp_vendas and $this->xp_vendas<=1) :
				$pt = 2 * $peso;
				break;
			case (1<$this->xp_vendas and $this->xp_vendas<=3) :
				$pt = 3 * $peso;
				break;
			case (3<$this->xp_vendas) :
				$pt = 4 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>6</td>
									<td ' . $sty1 . '>Experiencia com vendas</td>
									<td' . $sty2 . '>6</td>
									<td></td>
									<td' . $sty2 . '></td>
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
		switch ($this->tempo_uniao) {
			case ($this->tempo_uniao==0) :
				$pt = 0 * $peso;
				break;
			case (0<$this->tempo_uniao and $this->tempo_uniao<=1) :
				$pt = 1 * $peso;
				break;
			case (1<$this->tempo_uniao and $this->tempo_uniao<=5) :
				$pt = 2 * $peso;
				break;
			case (5<$this->tempo_uniao and $this->tempo_uniao<=10) :
				$pt = 3 * $peso;
				break;
			case (10<$this->tempo_uniao) :
				$pt = 4 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>9 a</td>
									<td ' . $sty1 . '>Tempo de uniao</td>
									<td' . $sty2 . '>9</td>
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
		switch ($this->tempo_emprego) {
			case ($this->tempo_emprego==0) :
				$pt = 0 * $peso;
				break;
			case (0<$this->tempo_emprego and $this->tempo_emprego<=1) :
				$pt = 1 * $peso;
				break;
			case (1<$this->tempo_emprego and $this->tempo_emprego<=3) :
				$pt = 2 * $peso;
				break;
			case (3<$this->tempo_emprego and $this->tempo_emprego<=5) :
				$pt = 3 * $peso;
				break;
			case (5<$this->tempo_emprego) :
				$pt = 4 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>9 c</td>
									<td ' . $sty1 . '>Tempo de emprego</td>
									<td' . $sty2 . '>10</td>
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
		switch ($this->estado_civil) {
			case ($this->estado_civil=='S' or $this->estado_civil=='D') :
				$pt = 0 * $peso;
				break;
			case ($this->estado_civil=='E') :
				$pt = 1 * $peso;
				break;
			case ($this->estado_civil=='V') :
				$pt = 2 * $peso;
				break;
			case ($this->estado_civil=='C') :
				$pt = 3 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>7</td>
									<td ' . $sty1 . '>Estado civil</td>
									<td' . $sty2 . '>7</td>
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
		switch ($this -> tempo_moradia) {
			case ($this->tempo_moradia==0) :
				$pt = 0 * $peso;
				break;
			case (0<$this->tempo_moradia and $this->tempo_moradia<=1) :
				$pt = 1 * $peso;
				break;
			case (1<$this->tempo_moradia and $this->tempo_moradia<=5) :
				$pt = 2 * $peso;
				break;
			case (5<$this->tempo_moradia and $this->tempo_moradia<=10) :
				$pt = 3 * $peso;
				break;
			case (10<$this->tempo_moradia) :
				$pt = 4 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>9 b</td>
									<td ' . $sty1 . '>Tempo de moradia</td>
									<td' . $sty2 . '>9</td>
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
		$peso = $this -> pesos[10];
		switch ($this->referencia) {
			case ($this->referencia=='A') :
				//amigos e parentes
				$pt = 1 * $peso;
				break;
			case ($this->referencia=='V') :
				// vizinhos
				$pt = 2 * $peso;
				break;
			case ($this->referencia=='C') :
				// comercial
				$pt = 3 * $peso;
				break;
			case ($this->referencia=='B') :
				// banc�ria
				$pt = 4 * $peso;
				break;
			default :
				break;
		}
		$sty1 = ' class="pre_tabelaTH"';
		$sty2 = ' class="pre_tabela01"';
		$this -> relatorio .= '<tr><td ' . $sty1 . '>8</td>
									<td ' . $sty1 . '>Tipo de referencia</td>
									<td' . $sty2 . '>8</td>
									<td></td>
									<td' . $sty2 . ' colspan="2">' . $this -> referencia($this -> referencia) . '</td>
									<td' . $sty2 . '>' . $peso . '</td>
									<td' . $sty2 . '>' . $pt / $peso . '</td>
									<td' . $sty2 . '>' . $pt . '</td></tr>';
		return ($pt);
	}

	/**
	 * Traduz nome das refer�ncias pelas siglas.
	 */
	function referencia($sigla) {
		switch ($sigla) {
			case 'A' :
				$sx = 'Amigo/parente';
				break;
			case 'V' :
				$sx = 'Vizinho';
				break;
			case 'C' :
				$sx = 'Comercial';
				break;
			case 'B' :
				$sx = 'Bancario';
				break;
			default :
				$sx = $sigla;
				break;
		}
		return ($sx);
	}

}
?>