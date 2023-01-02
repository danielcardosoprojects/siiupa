$(function () {
	/* voltar */


	$("#abreadministracao").click(function () {
		
		$("#conteudo").load("administracao/paginaadministracao.php");

	});

	$("#sair").click(function () {
		
		$("#conteudo").load($(this).atrr('href'));

	});

	/* voltarsub */

	function subanterior(link) {
		sessionStorage.setItem('linksubanterior', link);
	}
	function subconteudo(link) {
		$('#subconteudo').load(link);
	}

	$("#abrerh").click(function () {
		

		$('#subconteudo').load($(this).attr('href'));
	});

	














	/************************************* */


	$("input[type=submit], button")
		.button()
		.click(function (event) {
			event.preventDefault();
		});

	$(".abreprontuario")
		.button()
		.click(function (event) {

			window.open(this.href, '_blank')
		});

	/*****************cadastro paciente********************/
});