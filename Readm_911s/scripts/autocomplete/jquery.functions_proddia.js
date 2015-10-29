/* Copyright (c) 2012 Andre Campana (aecampana@gmail.com)
 * Version 2.1.2
 */
$().ready(function() {
	$("#resumo").hide();
    
    var idclien = "";
    
    $("#imageSearch").autocomplete("get_images2.php?cli="+idclien, {
		width: 380,
		max: 20,
		highlight: false,
		scroll: true,
		scrollHeight: 300,
		formatItem: function(data, i, n, value) {
            var result = value;
            var idprod = result.split(",")[0].split(".")[0];
            var exprod = result.split(",")[0].split(".")[1];
            var prod_vl = result.split(",")[2];
            var prod_pr = result.split(",")[4];
            if (prod_pr){
                prod_vl = " - de R$"+parseFloat(prod_vl).toFixed(2);
                prod_pr = " por R$"+parseFloat(result.split(",")[4]).toFixed(2);
            } else {
                prod_vl = " - R$"+parseFloat(prod_vl).toFixed(2);
                prod_pr = "";
            }
            if (exprod == "swf")
                return "<object data='../../arquivos/uploads/produtos/"+idprod+"."+exprod+"' type='application/x-shockwave-flash' width='45' height='52'><param name='quality' value='high' /><param name='flashvars' value='URLname="+idprod+"' /><param name='movie' value='../arquivos/uploads/produtos/"+idprod+"."+exprod+"' /><param name='wmode' value='opaque' /></object> " + result.split(",")[1] + prod_vl + prod_pr;
            return "<img src='/thumb/fotosprodutos/1/45/52/"+result.split(",")[6]+"' width=\"45\" height=\"52\"/> " + result.split(",")[1] + prod_vl + prod_pr;
		},
		formatResult: function(data, value) {
			return data;
		}
	});
       
    $("#Adicionar").click(function() {
        AdicionaProduto();
    });
    
    $("#Adicionar").blur(function() {
        AdicionaProduto();
    });
       
    function checaCampos(){
        if ($("#cestaitens").val().length < 5){
            alert("Você ainda não adicionou algum produto!");
            $("#imageSearch").css("border-color","#FF0000");
            $("#imageSearch").focus();
            return false;
        }
        return true;
    }
    
    $("#imageSearch").blur(function() {
        $("#imageSearch").css("border-color","#dad7cf");
    });
    
    function AdicionaProduto(){
        var conteudo = $("#imageSearch").val();
        var qtdeitens = $("#totalitens").val();
        var dataini = $("#dataini").val();
        var valorempro = $("#valor").val();
        var fretegr = $("#fretegratis").val();
        
        valorempro = valorempro.replace(",",".");
        
        if (!qtdeitens) qtdeitens = 0;
        if (!valorempro) valorempro = 0;
        
        if (qtdeitens > 0){
            alert("Você já adicionou um produto!");
            return false;
        }
        
        var dsfrete = "Sem Frete Gratis";
        
        if (fretegr == "S"){
            dsfrete = "Com Frete Gratis";
        }
        
        qtdeitens = qtdeitens + 1;
        
        if (conteudo.split(",").length == 7){
            var idprod = conteudo.split(",")[0].split(".")[0];
            var exprod = conteudo.split(",")[0].split(".")[1];
            var dsprod = conteudo.split(",")[1];
            var vlprod = parseFloat(conteudo.split(",")[2]).toFixed(2);
            var estoq = conteudo.split(",")[3];
            var frete = conteudo.split(",")[4];
            var promo = conteudo.split(",")[5];

            var linha = "";
            linha = linha + "<table width=100%><tr>";
            if (exprod == "swf"){
                linha = linha + "<td width=50><object data='../arquivos/uploads/produtos/"+idprod+"."+exprod+"' type='application/x-shockwave-flash' width='45' height='52'><param name='quality' value='high' /><param name='flashvars' value='URLname="+idprod+"' /><param name='movie' value='../arquivos/uploads/produtos/"+idprod+"."+exprod+"' /><param name='wmode' value='opaque' /></object></td>";
            }else{
                linha = linha + "<td width=50><img src='/thumb/fotosprodutos/1/45/52/"+ conteudo.split(',')[6] +"' width=\"45\" height=\"52\"/></td>";
            }
            linha = linha + "<td width=120><strong>"+dataini+"</strong></td><td align=left><strong>"+dsprod+"</strong></td>";
            linha = linha + "<td width=150><strong>Novo Valor: R$"+valorempro+"</strong></td>";
            linha = linha + "<td width=150><strong>"+dsfrete+"</strong></td>";
            linha = linha + "<td align=center width=40><a href=# id=remove><img src=../images/cancel.png border=0></a></td>";
            linha = linha + "</tr></table>";
            $("<li id='"+idprod+"'>").html(linha).appendTo(".carrinho");
            
            var basecesta = $("#cestaitens").val();
            basecesta = basecesta + idprod + ";" + exprod + ";" + vlprod + ";" + dataini + ";" + frete + ";" + promo + "|";
            $("#cestaitens").val(basecesta);
            $("#totalitens").val(qtdeitens);
            $("#resumo").show('slow');
        }
        $("#imageSearch").val("");
        $("#imageSearch").focus();
    }
    
    $("#remove").live('click', function() {
        var idlinha = $(this).closest('li').get(0).id;
        var vlritem = parseFloat($("#tot"+idlinha).text()).toFixed(2);
        
        var iditem = idlinha.replace('tot').split('_')[0];
        var idtama = idlinha.replace('tot').split('_')[1];
        
        var basecesta = $("#cestaitens").val();
        basecesta = basecesta.substr(0,basecesta.length - 1);
        var splititens = basecesta.split('|');
        basecesta = "";
        for (itens in splititens){
            if (splititens[itens].split(';')[0] != iditem){
                basecesta = basecesta + splititens[itens] + '|';
            }else{
                iditem = 'xxx';
                idtama = 'xxx';
            }
        }
        $("#cestaitens").val(basecesta);
        $("#totalitens").val(0);
        $("#resumo").hide();

        $(this).closest('li').remove();
    });
    
    function isNumeric(sText)
    {
       var ValidChars = "0123456789.,";
       var IsNumber=true;
       var Char;
     
       for (i = 0; i < sText.length && IsNumber == true; i++) 
       { 
          Char = sText.charAt(i); 
          if (ValidChars.indexOf(Char) == -1) 
          {
             IsNumber = false;
          }
       }
       return IsNumber;
    }

});