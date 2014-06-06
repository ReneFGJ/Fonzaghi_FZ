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
	var $idade = '';
	var $genero = '';
	var $avalista = '';
	var $avalista_cod = '';
	var $dist_moradia = '';
	var $vlr_restricao = '';
	var $patrimonio = '';
	var $renda_familiar = '';
	var $xp_vendas = '';
	var $estado_civil = '';
	var $tipo_referencia = '';
	var $tempo_uniao = '';
	var $tempo_moradia = '';
	var $tempo_emprego = '';

	function obter_dados() {
		$this -> recupera_dados_pelo_codigo();
		$this -> idade = $this -> calcular_idade($this -> line['pes_nas']);
		$this -> genero = $this->line['pes_genero'];
		$this -> avalista = $this->line['pes_avalista'];
		$this -> avalista_cod = $this->line['pes_avalista_cod'];
		$this -> dist_moradia = $this->calcular_distancia(); /*necessita ser implementado*/
		$this -> vlr_restricao = '';
		$this -> patrimonio = '';
		$this -> renda_familiar = '';
		$this -> xp_vendas = '';
		$this -> estado_civil = '';
		$this -> tipo_referencia = '';
		$this -> tempo_uniao = '';
		$this -> tempo_moradia = '';
		$this -> tempo_emprego = '';
		
	}

	function calcular_idade($nasc) {
		$date = new DateTime($nasc); // data de nascimento
		$interval = $date -> diff(date('Ymd')); // data definida
		$idade = $interval -> format('%Y');
		return ($idade);
	}
	
	function calcular_distancia(){
		/*verificar APIs do google como calcular distancia atraves do cep ou coordenada*/
	 	return($dist);	
	}
	
	

}
?>