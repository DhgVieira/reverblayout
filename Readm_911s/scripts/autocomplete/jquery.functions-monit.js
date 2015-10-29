/* Copyright (c) 2010 Andre Campana (aecampana@gmail.com)
 * Version 2.1.1
 */
$().ready(function() {
	$("#imageSearch").autocomplete("get_prod_mon.php", {
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
       
    $("#Adicionar").click(function() {
        AdicionaProduto();
    });
    
    $("#Adicionar").blur(function() {
        AdicionaProduto();
    });
    
    $("#imageSearch").blur(function() {
        $("#imageSearch").css("border-color","#dad7cf");
    });
    
    function AdicionaProduto(){
        
    }
    
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