	function mascaraData(campoData){
		var data = campoData.value;
		if (data.length == 2){
			data = data + '/';
			campoData.value = data;
			return true;
		}
		if (data.length == 5){
			data = data + '/';
			campoData.value = data;
			return true;
		}
	}
	
	function mascaraCEP(campoCEP){
		var cep = campoCEP.value;
		if (cep.length == 2){
			cep = cep + '.';
			document.formcad.cep.value = cep;
			return true;
		}
		if (cep.length == 6){
			cep = cep + '-';
			document.formcad.cep.value = cep;
			return true;
		}
	}
	
	function mascaraCPF(campoCPF){
		var cpf = campoCPF.value;
		if (cpf.length == 3){
			cpf = cpf + '.';
			document.formcad.cpf.value = cpf;
			return true;
		}
		if (cpf.length == 7){
			cpf = cpf + '.';
			document.formcad.cpf.value = cpf;
			return true;
		}
		if (cpf.length == 11){
			cpf = cpf + '-';
			document.formcad.cpf.value = cpf;
			return true;
		}
		
	}
	
	function mascaraCNPJ(campoCNPJ){
		var cnpj = campoCNPJ.value;
		if (cnpj.length == 2){
			cnpj = cnpj + '.';
			document.forms[0].cnpj.value = cnpj;
			return true;
		}
		if (cnpj.length == 6){
			cnpj = cnpj + '.';
			document.forms[0].cnpj.value = cnpj;
			return true;
		}
		if (cnpj.length == 10){
			cnpj = cnpj + '/';
			document.forms[0].cnpj.value = cnpj;
			return true;
		}
		if (cnpj.length == 15){
			cnpj = cnpj + '-';
			document.forms[0].cnpj.value = cnpj;
			return true;
		}
	}
	
	function jNumerico(e)
	{
		if(document.all) // Internet Explorer
			var tecla = event.keyCode;
			else if(document.layers) // Nestcape
			var tecla = e.which;
			
			if(tecla > 47 && tecla < 58) // numeros de 0 a 9
			return true;
		else
		{
			if (tecla != 8) // backspace
			return false;
			else
			return true;
		}
	}

function Limpajogos(){
	document.getElementById("jogo").value = "";
	document.getElementById('totaldz').innerHTML = "Total de Dezenas: <b>0</b>";
	document.getElementById('totaljg').innerHTML = "SubTotal: R$ 0,00";
}

function AnalizaNumeros(){
	var temp = document.getElementById("jogo").value;
	var qtde = document.getElementById("temp").value;
	if (!temp){
		alert('Voce precisa escolher seus numeros!');
		return false;
	}
	if (parseFloat(qtde) < 6) {
		alert('Escolha pelo menos 06 dezenas para analise!');
		return false;
	}
	var myWin = window.open('','analiza_produto','scrollbars=yes,width=450,height=300,top=100,left=100');
	document.frmDetalhe.jogoanlz.value = temp;
    document.frmDetalhe.action = 'analiza_jogos.php';
	document.frmDetalhe.target = 'analiza_produto';
    document.frmDetalhe.method = 'post';
    document.frmDetalhe.submit();
	myWin.focus();
}

function CapturaNumero(num){
	var temp = document.getElementById("jogo").value;
	var posicao = temp.indexOf(num);
	if (posicao < 0){
		var qtde = 0;
		var vlratual = 0;
		if (temp){
			qtde = document.getElementById("temp").value;
			qtde = parseFloat(qtde) + 1;
			document.getElementById("temp").value = qtde;
			temp = temp + " " + num;
		}else{
			temp = num;
			document.getElementById("temp").value = 1;
			qtde = 1;
		}
		
		if (qtde >= 6 && qtde <= 15) {
			if (qtde == 6) vlratual = '2,75';
			if (qtde == 7) vlratual = '19,00';
			if (qtde == 8) vlratual = '77,00';
			if (qtde == 9) vlratual = '190,00';
			if (qtde == 10) vlratual = '475,00';
			if (qtde == 11) vlratual = '1.050,00';
			if (qtde == 12) vlratual = '1.860,00';
			if (qtde == 13) vlratual = '3.450,00';
			if (qtde == 14) vlratual = '5.940,00';
			if (qtde == 15) vlratual = '9.800,00';
			document.getElementById('totaljg').innerHTML = "SubTotal: R$ " + vlratual;
		}
		
		if (qtde <= 15) {
			document.getElementById("jogo").value = temp;
			document.getElementById('totaldz').innerHTML = "Total de Dezenas: <b>" + qtde + "</b>";
		}
	}
}

	