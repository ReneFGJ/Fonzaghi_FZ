<?php
/**
 *
 */
class relatorio_dinamico {

	var $string = array();
	var $links = array();
	var $js = '';
	var $dados = '';
	var $linha = '';
	var $tipo = array();
	var $double = array();

	/**
	 * verifica se o campo é numerico
	 */
	function tipo_campo(){
		$this->fields .= '<div style="width:100%; text-align:left;">
						 <form >
						 <button id="bt_filtrar" type="button">Filtrar</button>
						 ';
		foreach ($this->string[1] as $key => $value) {
			$v = is_numeric ($value) ? true : false;
			if($v){
				$this->tipo[$key] = true;
				$this->jquery .= '
				$("#id'.$key.'").click(function(){
					var label = linha.shift();
					var ordem'.$key.';
					if(ordem'.$key.'==1){
						ordem'.$key.' = 0;
					}else{
						ordem'.$key.' = 1;
					};
					linha.sort(sort_by(\''.$key.'\', ordem'.$key.', parseInt));
					linha.unshift(label);
					start();
					
		  			});';
				
			}else{
				$this->tipo[$key] = false;
				$this->jquery .= '
				$("#id'.$key.'").click(function(){
					var label = linha.shift();
					var ordem'.$key.';
					if(ordem'.$key.'==1){
						ordem'.$key.' = 0;
					}else{
						ordem'.$key.' = 1;
					};
					linha.sort(sort_by(\''.$key.'\', ordem'.$key.', function(a){return a.toUpperCase()}));
					linha.unshift(label);
					start();
		  			});';
			}	
			
			$d = is_double($value) ? true : false;
			if ($d) {
				$this->double .= " var linha_d['".$key."'] = true;";
			} else {
				$this->double .= " var linha_d['".$key."'] = false;";
			}
			
			
		}
		$this->fields .= '</form></div>';	
	}
	/**
	 * gera array em javascript
	 */
	function formata_string() {
		foreach ($this->string as $key => $value) {
			$vld ='';
			$ddd = '';
			foreach ($value as $k => $v) {
				if(strlen(trim($vld))>0){
					$ddd .= ','.$v;
				}else{
					$ddd .= $v;
					$vld=1;
				}				
			}
			$this -> dados .= ' linha[' . $key . '] = [' . $ddd . '];' . chr(10) . chr(13);
		}
		return ($sx);
	}

	/**
	 * gera tabela 
	 */
	function mostra_relatorio() {
		$this->tipo_campo();
		$this -> formata_string();
		$sx .= $this -> linha . chr(10) . chr(13);
		$sx .= '<script>
		' . chr(10) . chr(13);
		$sx .= 'var linha  = new Array(new Array());' . chr(10) . chr(13);
		$sx .= $this -> dados . chr(10) . chr(13);
		$sx .= $this -> dados1 . chr(10) . chr(13);
		$sx .= '
		
		//FUNÇÃO DE ORDENAÇÃO
 	   	var sort_by = function(field, reverse, primer){

		   var key = primer ? 
		       function(x) {return primer(x[field])} : 
		       function(x) {return x[field]};
		
		   reverse = [-1, 1][+!!reverse];
		
		   return function (a, b) {
		       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		     } 
		}
	
		//FUNÇÃO GERAÇÃO DA TABELA
		function start(){
			// pega referencia do body
			
			var body = document.getElementsByTagName("body")[0];
			// cria <table>;
			$( "table" ).remove();
			var tbl     = document.createElement("table");
			
			// cria <tbody>;
			$( "tbody" ).remove();
			var tblBody = document.createElement("tbody");
	 		
			// creating all cells
			for (var j = 0; j < linha.length; j++) {
					
				// cria <tr>
				var row = document.createElement("tr");
				for (var i = 0; i < linha[j].length; i++) {
					
					if(j==0){
						
						var cell = document.createElement("th");
						
						var lnx = linha[0][i];
						if(lnx.substring(0, 1)=="#"){
							var cellText = document.createTextNode(lnx.substring(1, lnx.length));
						}else{
							var cellText = document.createTextNode(linha[j][i]);
						}
						
						
						cell.id = "id"+i;
						$( "#id"+i ).addClass( "display_none" );
						cell.appendChild(cellText);
						row.appendChild(cell);
					}else{
						// cria <td>;
						var cell = document.createElement("td");
						var lnx = linha[0][i];
						
						if(lnx.substring(0, 1)=="#"){
							//Link
							var link = document.createElement("a");
							link.setAttribute("href", linha[j][i]);
							link.setAttribute("target", "_blank");
							
							//imagem icone
							var imgx = document.createElement("img");
							imgx.setAttribute("src", "../ico/link_hand.png");
							imgx.setAttribute("style", "width:22px;text-align:center;");
							
							//conteudo do <td>;
							link.appendChild(imgx);
							cell.appendChild(link);
							cell.setAttribute("style", "text-align:center;");
								
						}else{
								
							//conteudo do <td>;
							var cellText = document.createTextNode(linha[j][i]);
							cell.appendChild(cellText);
						}
									
						row.appendChild(cell);
						row.id = "id_row"+j;
					}
				}	
				
			
			// add the row to the end of the table body
			tblBody.appendChild(row);
			}
	
			// put the <tbody> in the <table> 
			tbl.appendChild(tblBody);
			
			// appends <table> into <body> e centraliza
			
			var ct = document.createElement("center");
			body.appendChild(ct);
			ct.appendChild(tbl);
			
			// sets the border attribute of tbl to 2;
			tbl.setAttribute("cursor", "pointer");
			$( "th" ).addClass( "th" );
			$( "td" ).addClass( "tabela01" );
			//$( "link" ).addClass( "botao-geral" );
			
	'.$this->jquery.'
		
	}; 
	
	</script>
	<style>
	.ponteiro{
		
	}
	
	th{
		background:gray;
		color:#FFFFFF;
		cursor:pointer;
	}
	
	th:hover{
		background:#C0C0C0;
		color:#000000;
		
	}
	
	th:link{
		background:#C0C0C0;
		
	}
	
	.display_none{
		display:none;
	}
	</style>
	
	<body onload="start()">	</body>
			
				';
					
		return ($sx);
	}

}
?>