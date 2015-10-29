/* Copyright (c) 2010 Andre Campana (aecampana@gmail.com)
 * Version 2.1.1
 */
$().ready(function() {
    $("#descricao").empty();
    $.ajax({
       type: "POST",
       url: "get_contas_scateg.php",
       success: function(msg){
           $("#descricao").append(msg);
       }
    });
        
    $("#categoria").autocomplete("get_contas_categ.php", {
		width: 380,
		max: 20,
		highlight: false,
		scroll: true,
		scrollHeight: 300,
		formatItem: function(data, i, n, value) {
            var result = value;
            categ = result.split(",")[1];
            return categ;
		},
		formatResult: function(data, value) {
            return data;
		}
	});
        
    $("#categoria").blur(function() {
        var dados = $("#categoria").val();
        var idcateg = dados.split(",")[0];
        var dscateg = dados.split(",")[1];
        var subcateg = dados.split(",")[2];
        var descs = dados.split(",")[3];
        var idsub = dados.split(",")[4];
        $("#idcat").val(idcateg);
        $("#idscat").val(idsub);
        $("#categoria").val(dscateg);
        $("#subcategoria").empty();
        $("#subcategoria").append(subcateg);
    });
    
    $("#btnaddcat").click(function() {
        $.ajax({
           type: "POST",
           url: "contas_cat_inc2.php",
           data: "nome="+$("#catadd").val(),
           success: function(msg){
               if (msg == "-1"){
                  alert('Voce precisa preencher o nome da categoria!');
               }else{
                  $("#idcat").val(msg);
                  $("#categoria").val($("#catadd").val());
                  $("#catadd").val("");
               }
           }
        });
    });
    
    $("#btnaddsub").click(function() {
        if(!isNumeric($("#idcat").val()) || $("#idcat").val() == ""){
            alert('Categoria pai invalida!');
        }else{
            $.ajax({
               type: "POST",
               url: "contas_subcat_inc2.php",
               data: "nome="+$("#subadd").val()+"&cate="+$("#idcat").val(),
               success: function(msg){
                   if (msg == "-1"){
                      alert('Voce precisa preencher o nome da subcategoria!');
                   }else{
                      $("#subcategoria").append(msg);
                      $("#subadd").val("");
                   }
               }
            });
        }
    });  
    
    $("#btnadddesc").click(function() {
       
            $.ajax({
               type: "POST",
               url: "contas_descricao_inc2.php",
               data: "nome="+$("#descadd").val(),
               success: function(msg){
                   if (msg == "-1"){
                      alert('Voce precisa preencher o nome do fornecedor!');
                   }else{
                      $("#descricao").append(msg);
                      $("#descadd").val("");
                   }
               }
            });
     
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