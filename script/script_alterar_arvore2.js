$(document).ready(function(){
	
	/*$("#cep").focusout(function(){
		var cep = {

			cep: $(this).val()
		}

		if (cep.length !== 9) {
			//alert("Formato de CEP inválido.")
			$("#tp_logradouro").prop('readonly', true)
			$("#logradouro").prop('readonly', true)
			$("#bairro").prop('readonly', true)

		}

	})*/


	$("#cep").focusout(function(){
	
		var obj = {
			cep: $(this).val()
			//cep: $("#cep").val() mesma coisa de cima
		}

		$.ajax({
			cache: false,
			url: 'action/consulta_cep-uf/consulta_cep.php',
			type: 'POST',
			dataType: 'JSON',
			data: obj,
			success: function(r){
				console.log(r)
				$("#tp_logradouro").prop('readonly', true)
				$("#logradouro").prop('readonly', true)
				$("#bairro").prop('readonly', true)

				$("#cep").val(r.cep);
				$("#tp_logradouro").val(r.tp_logradouro);
				$("#logradouro").val(r.logradouro);
				$("#bairro").val(r.bairro);
				$("#numero").focus()

				

			},
			error: function(r){
				console.log('Error: ' + r)
				$("#tp_logradouro").val("")
				$("#logradouro").val("")
				$("#bairro").val("")

				$("#tp_logradouro").prop('readonly', false)
				$("#logradouro").prop('readonly', false)
				$("#bairro").prop('readonly', false)
			}

		})

		


	})




})