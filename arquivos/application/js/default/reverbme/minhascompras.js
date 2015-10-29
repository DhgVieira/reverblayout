$(document).ready(function(){
    $('.novo-pagamento').on('click', function(){
        if(!confirm('Se você já pagou o boleto não prossiga com esta operação. \n \nAguarde o email de confirmação de pagamento e caso tenha qualquer dúvida mande email para o atendimento@reverbcity.com')){
            return false;
        }
    });
});