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
		//Ajax consulta_cep
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
				$("#cidade").prop('readonly', true)

				$("#cep").val(r.cep);
				$("#tp_logradouro").val(r.tp_logradouro);
				$("#logradouro").val(r.logradouro);
				$("#bairro").val(r.bairro);
				$("#cidade").val(r.cidade);
				$("#num").focus()		

			},
			error: function(r){
				console.log('Error: ' + r)
				$("#tp_logradouro").val("")
				$("#logradouro").val("")
				$("#bairro").val("")
				$("#cidade").val("")

				$("#tp_logradouro").prop('readonly', false)
				$("#logradouro").prop('readonly', false)
				$("#bairro").prop('readonly', false)
				$("#cidade").prop('readonly', false)
			}

		})

	})

	$("#cep").focusout(function () {

        var obj = {
			cep: $(this).val()
			//cep: $("#cep").val() mesma coisa de cima
		}
            
        $.ajax({
			cache: false,
			url: 'action/consulta_cep-uf/consulta_uf.php',
			type: 'POST',
			dataType: 'JSON',
			data: obj,
			success: function(r){
				console.log(r)
				$("#uf").prop('readonly', true)

				$("#uf").val(r.nome);

			},
			error: function(r){
				console.log('Error: ' + r.nome)
				$("#uf").val("")

				$("#uf").prop('readonly', false)
			}

		}) 
                



	})




})