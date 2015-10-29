/* Copyright (c) 2010 Andre Campana (aecampana@gmail.com)
 * Version 2.1.1
 */
$().ready(function() {
	$("#imageSearch").autocomplete("get_images_boleto.php", {
		width: 380,
		max: 20,
		highlight: false,
		scroll: true,
		scrollHeight: 300,
		formatItem: function(data, i, n, value) {
            var result = value;
            var idprod = result.split(",")[0].split(".")[0];
            var exprod = result.split(",")[0].split(".")[1];
            if (exprod == "swf")
                return "<object data='../arquivos/uploads/produtos/"+idprod+"."+exprod+"' type='application/x-shockwave-flash' width='45' height='52'><param name='quality' value='high' /><param name='flashvars' value='URLname="+idprod+"' /><param name='movie' value='../arquivos/uploads/produtos/"+idprod+"."+exprod+"' /><param name='wmode' value='opaque' /></object> " + result.split(",")[1];
            return "<img src='../arquivos/uploads/produtos/"+idprod+"p."+exprod+"' width=\"45\" height=\"52\"/> " + result.split(",")[1];
		},
		formatResult: function(data, value) {
			return data;
		}
	});
    
    $("#imageSearch2").autocomplete("get_nomes.php", {
		width: 380,
		max: 20,
		highlight: false,
		scroll: true,
		scrollHeight: 300,
		formatItem: function(data, i, n, value) {
            var result = value;
            var nome = result.split(";")[0];
            var dcto = result.split(";")[2];
            idclien = result.split(";")[1];
            return nome+" - "+dcto;
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
    
    $("#REGISTRAR").click(function() {
        if (!checaCampos()) return false;
    });
    
    function checaCampos(){
        if ($("#cestaitens").val().length < 5){
            alert("Você ainda não adicionou itens ao pedido!!");
            $("#imageSearch").css("border-color","#FF0000");
            trataCliqueAba('abaVer');
            $("#imageSearch").focus();
            return false;
        }
        if ($("#nome").val().length < 3){
            alert("Você precisa preencher o Nome do Comprador!!");
            $("#nome").css("border-color","#FF0000");
            $("#nome").focus();
            return false;
        }
        return true;
    }
    
    $("#nome").blur(function() {
        $("#nome").css("border-color","#dad7cf");
    });
   
    $("#imageSearch").blur(function() {
        $("#imageSearch").css("border-color","#dad7cf");
    });
    
    $("#Adicionar2").click(function() {
        var conteudo = $("#imageSearch2").val();
        if (conteudo.split(";").length == 15){
            $.ajax({
               type: "POST",
               url: "get_valor.php",
               data: "c="+conteudo.split(";")[1],
               success: function(msg){
                 //NADA
               }
            });
            $("#idcli").val(conteudo.split(";")[1]);
            $("#nome").val(conteudo.split(";")[0]);
            $("#email").val(conteudo.split(";")[6]);
            $("#docto").val(conteudo.split(";")[2]);
            $("#endereco").val(conteudo.split(";")[7]);
            $("#numero").val(conteudo.split(";")[8]);
            $("#complem").val(conteudo.split(";")[9]);
            $("#bairro").val(conteudo.split(";")[10]);
            $("#sexo").val(conteudo.split(";")[11]);
            $("#cidade").val(conteudo.split(";")[3]);
            $("#estado").val(conteudo.split(";")[4]);
            $("#cep").val(conteudo.split(";")[5]);
            $("#ddd").val(conteudo.split(";")[12]);
            $("#fone").val(conteudo.split(";")[13]);
            $("#twitter").val(conteudo.split(";")[14]);
            $("#formcli").show('slow');
        }else{
            $("#nome").val(conteudo);
            $("#formcli").show('slow');
            $("#docto").focus();
        }
    });
    
    function AdicionaProduto(){
        var conteudo = $("#imageSearch").val();
        if (conteudo.split(",").length == 6 && $("#qtde").val().length > 0){
            var idprod = conteudo.split(",")[0].split(".")[0];
            var exprod = conteudo.split(",")[0].split(".")[1];
            var dsprod = conteudo.split(",")[1];
            var vlprod = parseFloat($("#qtde").val().replace(",",".")).toFixed(2);
            var estoq = conteudo.split(",")[3];
            var dstam = conteudo.split(",")[4];
            var nrtam = conteudo.split(",")[5];
            var qtde = 1;
            var total = parseFloat((vlprod*qtde)).toFixed(2);
            var linha = "";
            linha = linha + "<table width=100%><tr>";
            if (exprod == "swf"){
                linha = linha + "<td width=50><object data='../arquivos/uploads/produtos/"+idprod+"."+exprod+"' type='application/x-shockwave-flash' width='45' height='52'><param name='quality' value='high' /><param name='flashvars' value='URLname="+idprod+"' /><param name='movie' value='../arquivos/uploads/produtos/"+idprod+"."+exprod+"' /><param name='wmode' value='opaque' /></object></td>";
            }else{
                linha = linha + "<td width=50><img src='../arquivos/uploads/produtos/"+idprod+"p."+exprod+"' width=\"45\" height=\"52\"/></td>";
            }
            linha = linha + "<td align=left><strong>"+dsprod+"</strong></td>";
            linha = linha + "<td align=right width=80>R$ "+vlprod+"</td>";
            linha = linha + "<td align=right width=30>"+qtde+"</td>";
            linha = linha + "<td align=right width=80><div style='margin: 0 0 4px 0;' id='tot"+idprod+"_"+nrtam+"'>"+total+"</div><div style='margin: 0 0 4px 0;'>R$ </div></td>";
            linha = linha + "<td align=center width=40><a href=# id=remove><img src=../images/cancel.png border=0></a></td>";
            linha = linha + "</tr></table>";
            $("<li id='"+idprod+"_"+nrtam+"'>").html(linha).appendTo(".carrinho");
            
            var basecesta = $("#cestaitens").val();
            basecesta = basecesta + idprod + ";" + exprod + ";" + vlprod + ";" + qtde + ";" + nrtam + "|";
            $("#cestaitens").val(basecesta);
            
            var vlrfimc = parseFloat(total);
            $("#total").val(vlrfimc.toFixed(2));
        }
        $("#imageSearch").val("");
        $("#qtde").val("");
        $("#imageSearch").focus();
    }
    
    $("#remove").live('click', function() {
        var idlinha = $(this).closest('li').get(0).id;
        var vlritem = parseFloat($("#tot"+idlinha).text()).toFixed(2);
        var vlratual = parseFloat($("#subtotal").val()).toFixed(2);
        var vlrfim = parseFloat(vlratual-vlritem).toFixed(2);
        $("#subtotal").val(vlrfim);
        
        var iditem = idlinha.replace('tot').split('_')[0];
        var idtama = idlinha.replace('tot').split('_')[1];
        
        var basecesta = $("#cestaitens").val();
        basecesta = basecesta.substr(0,basecesta.length - 1);
        var splititens = basecesta.split('|');
        basecesta = "";
        for (itens in splititens){
            if (splititens[itens].split(';')[0] != iditem && splititens[itens].split(';')[4] != idtama){
                basecesta = basecesta + splititens[itens] + '|';
            }else{
                iditem = 'xxx';
                idtama = 'xxx';
            }
        }
        $("#cestaitens").val(basecesta);

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