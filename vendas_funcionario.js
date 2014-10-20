/**
 * @author Willian
 */

function insere_produto(verbo,ean13) {
	$.ajax({
		type : "POST",
		url : "../_ajax/ajax_vendas_funcionario.php",
		data : {
			dd0 : verbo,
			dd1 : ean13,
		}
	})
	.fail(function() { alert("error"); })
	.done(function(data) {
		$("#status").html(data);
	});
}
