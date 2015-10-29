$(document).ready(function(){
    var boletoUrl = $("#form-finalizar").attr("action");
    if(boletoUrl != null){
        $("#modal-boleto").load(boletoUrl);
    }
    
    $("#container-modal-boleto-overlay").click(function(){
        $(this).hide();
        $("#modal-boleto").hide();
    });
});