$(function() {

	//fake select
	$('.fake-select select').on('change', function(){
		$(this).parent().find('span').text($(this).val());
	});

	// alteração do endereço (input radio)
	// 04.09.2014 -> Adicionar evento para calculo do frete dentro dessa função
	function addressModify(){
		$('input[name=endereco]').on('change', function() {
			//remove a classe do antigo e volta com texto normal
			$('.mycart-address-item').removeClass('active');
			$('.mycart-use-address span').text('Usar esse endereço');

			// adiciona a classe no selecionado e altera o texto para selecionado
			$('input[name=endereco]:checked').closest('.mycart-address-item').addClass('active');
			$('input[name=endereco]:checked').siblings('span').text('Endereço selecionado');
		});
	}
	addressModify();

	function newAddressLightbox(){
		//popula estados e cidades nos campos
		new dgCidadesEstados({
			estado: $('#newaddress-estado select').get(0),
			cidade: $('#newaddress-cidade select').get(0)
		});

		//mascara para CEP
		$('#newaddress-cep').mask('99.999-999').on('focusout', function(e) {
			$('#newaddress-pesquisa').trigger('click');
		});;

		// busca endereço ao clicar no botão de pesquisa
		$('#newaddress-pesquisa').on('click', function(event) {
			event.preventDefault();

			// armazena o número do cep limpo e monta URL para requisição
			var cep = $('#newaddress-cep').val().replace(/\.*\-*/gi,'');
			var getURL = 'http://cep.republicavirtual.com.br/web_cep.php?cep=' + cep + '&formato=json';

			// faz requisição AJAX
			$.getJSON(getURL, function(ev) {
				if (ev.resultado == 0) {
					alert('Desculpe, mas este cep não existe')
				} else {
					$('#newaddress-endereco').val(ev.tipo_logradouro + ' ' + ev.logradouro);
					$('#newaddress-bairro').val(ev.bairro);
					new dgCidadesEstados({
						estado: $('#newaddress-estado select').get(0),
						cidade: $('#newaddress-cidade select').get(0),
						estadoVal: ev.uf,
						cidadeVal: ev.cidade
					});
					$('#newaddress-estado span').text(ev.uf);
					$('#newaddress-cidade span').text(ev.cidade);
				}
			})
		});
	}
	newAddressLightbox();

	// função para alteração do frete (input radio)
	// 05.09.2014 -> Adicionar evento para recalcular o carrinho dentro dessa função (recalcular de acordo com o frete escolhido)
	function deliveryModify(){
		$('input[name=frete]').on('change', function() {
			//remove a classe do antigo e volta com texto normal
			$('.mycart-delivery-item').removeClass('active');

			// adiciona a classe no selecionado e altera o texto para selecionado
			$('input[name=frete]:checked').closest('.mycart-delivery-item').addClass('active');
		});
	}
	deliveryModify();

	// função para alteração do pagamento (input radio)
	function paymentModify(){
		$('input[name=pagamento]').on('change', function() {
			//remove a classe do antigo e volta com texto normal
			$('.mycart-payment-item').removeClass('active');

			// adiciona a classe no selecionado e altera o texto para selecionado
			$('input[name=pagamento]:checked').closest('.mycart-payment-item').addClass('active');
		});
	}
	paymentModify();
});