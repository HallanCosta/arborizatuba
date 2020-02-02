$(document).ready(function() {
	$("#datadenasc").mask('00/00/0000', {reverse: true})
	$("#cpf").mask('000.000.000-00', {reverse: true})
	$("#rg").mask('00.000.000-A', {reverse: true})
	$("#cep").mask('00000-000', {reverse: true})
	$("#telefone").mask('(00) 00000-0000', {reverse: false})
	$("#num").mask('0000', {reverse: false})
});