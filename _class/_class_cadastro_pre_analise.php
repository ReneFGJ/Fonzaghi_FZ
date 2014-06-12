<?php
/**
 * Pré-Cadastro Analise
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.14.23
 * @package _class
 * @subpackage _class_cadastro_pre_analise.php
 */
require_once ('_class_cadastro_pre.php');

class cadastro_pre_analise extends cadastro_pre {
	var $cpf = '';
	var $idade = '';
	var $genero = '';
	var $avalista = '';
	var $avalista_cod = '';
	var $dist_moradia = '';
	var $TTrestricoes_vlr = '';
	var $TTrestricoes = '';
	var $patrimonio = '';
	var $renda_familiar = '';
	var $xp_vendas = 0;
	var $estado_civil = '';
	var $tipo_referencia = '';
	var $tempo_uniao = '';
	var $tempo_moradia = '';
	var $tempo_emprego = '';
	var $TTpontos = 0;
	/*Latitude e longitude Fonzaghi*/
	var $latF = -25.427985;
	var $longF = -49.27563;
	/*Latitude e longitude Consultora*/
	var $latC = 0;
	var $longC = 0;
	var $pesos = array();
	function __construct(){
		$this->pesos = array(1,1,1,1,1,1,1,1,1,1,1);
	}
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
		$this -> renda_familiar = '';
		$this -> xp_vendas = $this -> line_cmp['cmp_experiencia_vendas'];
		$this -> estado_civil = $this -> line_cmp['cmp_estado_civil'];
		$this -> tipo_referencia = '';
		$this -> tempo_uniao = $this -> line_cmp['cmp_estado_civil_tempo'];
		$this -> tempo_moradia = $this -> line_cmp['cmp_imovel_tempo'];
		$this -> tempo_emprego = $this -> line_cmp['cmp_emprego_tempo'];
		$this -> aluguel = $this -> line_cmp['cmp_valor_aluguel'];
		return (1);
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
		//$metros = round($r * $c * 1000);
		$km = round($r * $c);

		return $km;

	}

	function calcular_restricoes() {
		$acp = new acp;
		$acp -> calcular_restricoes($this -> cpf);
		$this -> TTrestricoes = $acp -> TTrestricoes;
		$this -> TTrestricoes_vlr = $acp -> TTrestricoes_vlr;
		return (1);
	}

	function calcular_pontuacao() {
		$this -> TTpontos += $this -> pontos_idade();
		$this -> TTpontos += $this -> pontos_vlr_restricoes();
		$this -> TTpontos += $this -> pontos_distancia();
		$this -> TTpontos += $this -> pontos_renda();
		$this -> TTpontos += $this -> pontos_xp_vendas();
		$this -> TTpontos += $this -> pontos_uniao();
		$this -> TTpontos += $this -> pontos_tempo_emprego();
	}

	function pontos_idade() {
		$peso = $this ->pesos[0];
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
		return ($pt);
	}

	function pontos_vlr_restricoes() {
		$peso = $this ->pesos[1];
		
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
		return ($pt);
	}

	function pontos_distancia($peso = 2) {
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
		return ($pt);
	}

	function pontos_renda($peso = 3) {
		switch ($this->renda_familiar) {
			case ($this->renda_familiar>10000) :
				$pt = 4 * $peso;
				break;
			case (5000<$this->renda_familiar and $this->renda_familiar<=10000) :
				$pt = 3 * $peso;
				break;
			case (2000>$this->renda_familiar and $this->renda_familiar<=5000) :
				$pt = 2 * $peso;
				break;
			case ($this->renda_familiar<=2000) :
				$pt = 1 * $peso;
				break;
			default :
				break;
		}
		return ($pt);
	}

	function pontos_xp_vendas($peso = 3) {
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
		return ($pt);
	}

	function pontos_uniao($peso = 3) {
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
		return ($pt);
	}

	function pontos_tempo_emprego($peso = 2) {
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
		return ($pt);
	}

}
?>