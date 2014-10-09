/**
 * @author Willian
 */
function acao_pre_cad(id,verbo) {
	$.ajax({
		type : "POST",
		url : "../_ajax/ajax_pre_cad.php",
		data : {
			dd0 : id,
			dd1 : verbo,
		}
	}).done(function(data) {
		$("#acao_pre_cad").html(data);
	});
}

function lista_status_pre_cad(status,verbo) {
	$.ajax({
		type : "POST",
		url : "../_ajax/ajax_pre_cad.php",
		data : {
			dd0 : status,
			dd1 : verbo,
		}
	}).done(function(data) {
		$("#lista_status_pre_cad").html(data);
	});
}

function mostra_dados_pre_cad(id,verbo) {
	$.ajax({
		type : "POST",
		url : "../_ajax/ajax_pre_cad.php",
		data : {
			dd0 : id,
			dd1 : verbo,
		}
	}).done(function(data) {
		$("#mostra_dados_pre_cad").html(data);
	});
}

function mailing(id,verbo) {
	$.ajax({
		type : "POST",
		url : "../_ajax/ajax_pre_cad.php",
		data : {
			dd0 : id,
			dd1 : verbo,
		}
	}).done(function(data) {
		$("#mailing_status").html(data);
	});
}

function progress(id){
	var img = $('<img />',
             { id: 'progress_id',
               src: '../img/plug_carregando.gif', 
               alt:'Carregando'})
              .appendTo($('#'+id));
}


