carrinho = {
    quantidade: $("#mycart-subtotal").data("quantidade"),
    subTotal: $("#mycart-subtotal").data("subtotal"),
    frete: $("#mycart-subtotal").data("frete"),
    desconto: $("#mycart-subtotal").data("desconto"),
    total: $("#mycart-subtotal").data("total"),
    cep: $("#mycart-subtotal").data("cep"),
    msgErro: 0,
    totalDescontoPromo: 0
}
function r() {
    carrinho.quantidade = 0, carrinho.subTotal = 0, carrinho.subTotal = 0, carrinho.totalDescontoPromo = 0;
    $.each($(".mycart-content-item"), function(e) {
        var r = $(this).data("valorproduto"),
            de = $(this).data("desconto"),
            a = parseInt($(this).find("select[name=amount]").val()),
            o = (r * a) - de,
            semDe = r * a;
        carrinho.subTotal += o;
        carrinho.quantidade += a;
        carrinho.totalDescontoPromo += de;
        $(this).find(".mycart-content-total p").text("R$ " + reverb.formatNumber(o));
        $(this).find(".mycart-content-value p").text("R$ " + reverb.formatNumber(semDe));

        $($("#mobile-header .flyout-list.my-cart-items li")[e]).find(".product-amount").text("Quantidade " + a);
        $($("#mobile-header .flyout-list.my-cart-items li")[e]).find(".product-price").text("R$ " + reverb.formatNumber(o));
        $($("#desktop-header .flyout-list.my-cart-items li")[e]).find(".product-amount").text("Quantidade " + a);
        $($("#desktop-header .flyout-list.my-cart-items li")[e]).find(".product-price").text("R$ " + reverb.formatNumber(o));
    }).promise().done(function() {
        $('#mycart-subtotal-carrinho p:eq(0) span:last').text(carrinho.quantidade);
        $('#mycart-subtotal-carrinho p:eq(1) span:last').text("R$ " + reverb.formatNumber(carrinho.subTotal));
        $('#mycart-subtotal-carrinho').data('quantidade', carrinho.quantidade);
        $('#mycart-subtotal p:first span:last').text("R$ " + reverb.formatNumber(carrinho.subTotal));

        $('#mycart-subtotal p:eq(1) span:last').text("+ R$ " + reverb.formatNumber(carrinho.frete));
        $('#mycart-subtotal p:eq(2) span:last').text("- R$ " + reverb.formatNumber(carrinho.desconto));
        if(carrinho.totalDescontoPromo){
            $('#mycart-subtotal p:eq(2) span:last').text("- R$ " + reverb.formatNumber(carrinho.totalDescontoPromo));
        }
        $('#mycart-discount-value').html("R$ " + reverb.formatNumber(carrinho.desconto));

        carrinho.total = carrinho.frete + carrinho.subTotal - carrinho.desconto;
        $('#mycart-subtotal p:eq(3) span:last').html("R$ " + reverb.formatNumber(carrinho.total));

        if(carrinho.total > 50 && carrinho.total < 100){
            divisao = 2;
        }else if(carrinho.total > 100 && carrinho.total < 150){
            divisao = 3;
        }else if(carrinho.total > 150){
            divisao = 4;
        }else{
            divisao = 1;
        }

        $('select[name=parcelamento]').html('');
        for(i = 1; i <= divisao; i++){
            if(i == 1){
                $('select[name=parcelamento]').closest('.fake-select').find('span').text(i + 'x de R$ ' + reverb.formatNumber(carrinho.total/i));
                $('select[name=parcelamento]').append('<option value="'+ i +'" selected>' + i + 'x de R$ ' + reverb.formatNumber(carrinho.total/i) + '</option>');
            }else{
                $('select[name=parcelamento]').append('<option value="'+ i +'">' + i + 'x de R$ ' + reverb.formatNumber(carrinho.total/i) + '</option>');
            }
        }

        $("#mycart-subtotal-carrinho p").fadeIn();
    });
}

function detectCardType(number) {
    var re = {
        electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
        maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
        dankort: /^(5019)\d+$/,
        interpayment: /^(636)\d+$/,
        unionpay: /^(62|88)\d+$/,
        visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
        mastercard: /^5[1-5][0-9]{14}$/,
        amex: /^3[47][0-9]{13}$/,
        diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
        discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
        jcb: /^(?:2131|1800|35\d{3})\d{11}$/,
        elo: /^((((636368)|(438935)|(504175)|(451416)|(636297))\d{0,10})|((5067)|(4576)|(4011))\d{0,12})$/
    };
    if (re.electron.test(number)) {
        //return 'electron';
        return false;
    } else if (re.maestro.test(number)) {
        //return 'maestro';
        return false;
    } else if (re.dankort.test(number)) {
        //return 'dankort';
        return false;
    } else if (re.interpayment.test(number)) {
        //return 'interpayment';
        return false;
    } else if (re.unionpay.test(number)) {
        //return 'unionpay';
        return false;
    } else if (re.visa.test(number)) {
        return 'visa';
    } else if (re.mastercard.test(number)) {
        return 'mastercard';
    } else if (re.amex.test(number)) {
        return 'amex';
    } else if (re.elo.test(number)) {
        return 'elo';
    } else if (re.diners.test(number)) {
        //return 'diners';
    } else if (re.discover.test(number)) {
        //return 'discover';
        return false;
    } else if (re.jcb.test(number)) {
        //return 'jcb';
        return false;
    } else {
        return false;
    }
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$(document).ready(function(){
    r();
    $('#numero_cartao').keyup(function(){
        var bandeira = detectCardType($(this).val());

        $('.mycart-payment-flags.cards img').attr('style', 'opacity: 0.2');
        if(bandeira == 'visa'){
            $('.mycart-payment-flags').find('img[data-cartao=visa]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'mastercard'){
            $('.mycart-payment-flags').find('img[data-cartao=mastercard]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'amex'){
            $('.mycart-payment-flags').find('img[data-cartao=amex]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'diners'){
            $('.mycart-payment-flags').find('img[data-cartao=diners]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'elo'){
            $('.mycart-payment-flags').find('img[data-cartao=elo]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }

        if(bandeira){
            $('input[name=formapagto]').eq(1).val(bandeira);
        }else{
            $('input[name=formapagto]').eq(1).val('');
        }
    });

    $('#numero_cartao').focusout(function(){
        var bandeira = detectCardType($(this).val());

        $('.mycart-payment-flags.cards img').attr('style', 'opacity: 0.2');
        if(bandeira == 'visa'){
            $('.mycart-payment-flags').find('img[data-cartao=visa]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'mastercard'){
            $('.mycart-payment-flags').find('img[data-cartao=mastercard]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'amex'){
            $('.mycart-payment-flags').find('img[data-cartao=amex]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'diners'){
            $('.mycart-payment-flags').find('img[data-cartao=diners]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }else if(bandeira == 'elo'){
            $('.mycart-payment-flags').find('img[data-cartao=elo]').attr('style', 'box-shadow: 0px 0px 3px #e85238;');
        }

        if(bandeira){
            $('input[name=formapagto]').eq(1).val(bandeira);
        }else{
            $('input[name=formapagto]').eq(1).val('');
        }
    });

    $('#mycart-delivery-list li:eq(0)').show();

    $("select[name=amount]").on("change", function() {
        var e = {
            idEstoque: $(this).closest(".mycart-content-item").data("idestoque"),
            qtdEstoque: $(this).val()
        };
        $(this).prev().text($(this).val());
        $.ajax({
            url: document.basePath + "/checkout/aumentarquantidade/idestoque/" + e.idEstoque + "/quantidade/" + e.qtdEstoque,
            type: "GET",
            beforeSend: function() {
                $("#mycart-subtotal-carrinho p").fadeOut();
            },
            error: function() {
                reverb.alertMessage("error", "Ocorreu um erro ao calcular os valores, por favor contate o administrador do site do site :/")
            },
            success: function() {
                location.reload();
                //r();
                //carregaFretes(1);
            },
            complete: function() {}
        })
    });

    $('#btn-cadastrar-end').on('click', function(e){
        e.preventDefault();

        if($('#newaddress-nome').val() == "" || $('#newaddress-endereco').val() == "" || $('#newaddress-numero').val() == "" || $('#newaddress-cidade span').text() == "Cidade*" || $('#newaddress-estado span').text() == "Estado*" || $('#newaddress-cep').val() == ""){
            reverb.alertMessage("error", "Preencha todos os campos obrigatórios!");
        }else{
            $('#newaddress-lightbox').attr('style', '');
            $('#newaddress-lightbox').removeClass('md-show');

            $.ajax({
                url: document.basePath + "/carrinho/novo-endereco",
                type: "POST",
                data: $('#newaddress-lightbox :input').serialize(),
                beforeSend: function() {

                },
                error: function() {
                    reverb.alertMessage("error", "Ocorreu um erro cadastrar o endereço :/");
                },
                success: function(result) {
                    if(result.status){
                        var htmlEnd = '<li class="mycart-address-item active" data-endereco_id="' + result.endereco_id + '" data-cep="' + $('#newaddress-cep').val() + '"><p class="mycart-address-text"><strong>'+ $('#newaddress-nome').val() +'</strong> <br>'+ $('#newaddress-endereco').val() +', '+ $('#newaddress-numero').val() +' ' + $('#newaddress-complemento').val() + ' <br>'+ $('#newaddress-bairro').val() +' <br>'+ $('#newaddress-cidade span').text() +' '+ $('#newaddress-estado span').text() +' - '+ $('#newaddress-cep').val() +'</p><label class="mycart-use-address"><span>Endereço selecionado</span></label><a href="#" class="mycart-edit-address"> Editar </a></li>';
                        $('#mycart-address-list li').removeClass('active');
                        $('#mycart-address-list li').find('.mycart-use-address span').html('USAR ESSE ENDEREÇO');

                        if($('li[data-endereco_id=' + result.endereco_id + ']')){
                            $('li[data-endereco_id=' + result.endereco_id + ']').remove();
                        }
                        carrinho.cep = $('#newaddress-cep').val();
                        $('#mycart-address-list li.new-address').before(htmlEnd);

                        $('#newaddress-lightbox :input').val('');
                        $('input[name=usar_mesmo]').val(result.endereco_id)
                        r();
                        carregaFretes(1);
                    }else{
                        reverb.alertMessage("error", "Ocorreu um erro cadastrar o endereço :/");
                    }
                },
                complete: function() {}
            });
        }
    });

//    $('#btn-cadastrar-end').on('click', function(){
//       $('#newaddress-lightbox').attr('style', '');
//       $('#newaddress-lightbox').removeClass('md-show');
//       if($('input[name=endereco_endereco]').val() != ""){
//            $('input[name=usar_mesmo]').val('0');
//            $('#mycart-address-list li:first').find('.mycart-use-address span').html('USAR ESSE ENDEREÇO');
//            var htmlEnd = '<li class="mycart-address-item active"><p class="mycart-address-text"><strong>'+ $('#newaddress-nome').val() +'</strong> <br>'+ $('#newaddress-endereco').val() +', '+ $('#newaddress-numero').val() +' ' + $('#newaddress-complemento').val() + ' <br>'+ $('#newaddress-bairro').val() +' <br>'+ $('#newaddress-cidade span').text() +' '+ $('#newaddress-estado span').text() +' - '+ $('#newaddress-cep').val() +'</p><label class="mycart-use-address"><span>Endereço selecionado</span></label><a href="#" class="mycart-edit-address"> Editar </a></li>';
//            $('#mycart-address-list li').removeClass('active');
//            if($('#mycart-address-list li').length == 3){
//                $('#mycart-address-list li').eq(1).remove();
//            }
//            $('#mycart-address-list li.new-address').before(htmlEnd);
//
//            cep = $('#newaddress-cep').val();
//            $('.mycart-address-item.new-address').hide();
//            carregaFretes(1);
//       }
//    });

    $('.md-close.ir').on('click', function(e){
        e.preventDefault();
    });

    $('.pedido.avancar').on('click', function(e){
        e.preventDefault();

        if(!$("input[name=forma_envio]").is(':checked')){
            $('#carregando-lightbox').attr('style', '');
            $('#carregando-lightbox').removeClass('md-show');
            reverb.alertMessage("error", "Escolha uma forma de envio");
            $('html, body').animate({
                scrollTop: $(".rvb-title.frete-title").offset().top - 45
            }, 1000);
        }else if($('input[name=formapagto]:checked').val() == "boleto") {
            $('#mycart-payment').submit();
            $('.md-overlay').off();
            $("#msg-box").fadeOut(200);
            setTimeout(function(){
                $("#msg-box").remove();
            }, 200);
        }else if($('input[name=formapagto]:checked').val() == undefined){
            reverb.alertMessage("error", "Escolha uma forma de pagamento");
            $('#carregando-lightbox').attr('style', '');
            $('#carregando-lightbox').removeClass('md-show');
            $('html, body').animate({
                scrollTop: $(".rvb-title.pagamento-title").offset().top - 45
            }, 1000);
        }else if($('#nome_portador').val() == "" || $('#numero_cartao').val() == "" || $('#select_mes').val() == "" || $('#select_ano').val() == "" || $('#cod_seguranca').val() == "" || $('#cod_seguranca').val() == ""){
            reverb.alertMessage("error", "Preencha todos os dados do seu cartão");
            $('#carregando-lightbox').attr('style', '');
            $('#carregando-lightbox').removeClass('md-show');
            $('html, body').animate({
                scrollTop: $(".rvb-title.pagamento-title").offset().top - 45
            }, 1000);
        }else{
            var currentDate = new Date();
            var currentMonth = currentDate.getMonth() + 1;
            var currentYear = currentDate.getFullYear();
            if (currentMonth < 10) { currentMonth = '0' + currentMonth; }

            if(currentMonth > parseInt($('#select_mes').val()) && currentYear == parseInt($('#select_ano').val())){
                $('#carregando-lightbox').attr('style', '');
                $('#carregando-lightbox').removeClass('md-show');
                reverb.alertMessage("error", "Vencimento inválido!");
            }else{
                $('#mycart-payment').submit();
                $('.md-overlay').off();
                $("#msg-box").fadeOut(200);
                setTimeout(function(){
                    $("#msg-box").remove();
                }, 200);
            }
        }
    });

    $('.carrinho.avancar').on('click', function(e){
        e.preventDefault();
        $('.carrinho-lista').hide('slide', {direction: 'left'}, 350, function(){$('.carrinho-pagamento').show('slide', {direction: 'right'}, 350)});
        $('.steps').removeClass('current');
        $('.step-2').addClass('current');
    })

    $('.pedido.voltar').on('click', function(e){
        e.preventDefault();
        $('.carrinho-pagamento').hide('slide', {direction: 'right'}, 350, function(){$('.carrinho-lista').show('slide', {direction: 'left'}, 350)});
        $('.steps').removeClass('current');
        $('.step-1').addClass('current');
    });

    $('input[name=forma_envio]').on('click', function(){
        if($(this).val() != ""){
            if($('#msg-box p').text() == "Escolha uma forma de envio"){
                $("#msg-box").fadeOut(200);
                setTimeout(function(){
                    $("#msg-box").remove();
                }, 200);
            }
            var o = {
                json: !0,
                cep: reverb.returnNumbers(cep),
                subtotal: carrinho.subTotal,
                forma_envio: $(this).val()
            };

            $.ajax({
                url: document.basePath + "/checkout2/correios",
                type: "POST",
                dataType: "json",
                data: o,
                error: function() {
                    reverb.alertMessage("error", "Ocorreu um erro ao calcular o frete, por favor contate o administrador do site :/")
                },
                beforeSend: function() {
                    //            var e = '<div class="loader ir">Carregando</div>';
                    //            $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando..."), $("#time-delivery").text("Carregando...")
                },
                success: function(e) {
                    carrinho.frete = parseFloat(e.Valor);
                },
                complete: function() {
                }
            });
        }else{
            carrinho.frete = 0;
        }
    })

    var cep = String(carrinho.cep);
    var elementosDisponiveis = [];
    var temGratis = false;
    var valor_frete_gratis = 0;
    function carregaFretes(forma){
        $(".mycart-delivery-item").hide();
        $(".mycart-delivery-item").eq(0).show();
        cep = String(carrinho.cep);

        var o = {
            json: !0,
            cep: reverb.returnNumbers(cep),
            subtotal: carrinho.subTotal,
            forma_envio: forma
        };

        $.ajax({
            url: document.basePath + "/checkout2/correios",
            type: "POST",
            dataType: "json",
            data: o,
            error: function() {
                reverb.alertMessage("error", "Ocorreu um erro ao calcular o frete, por favor contate o administrador do site :/")
            },
            success: function(e) {
                carrinho.frete = parseFloat(e.Valor);
                if(carrinho.frete == "0" && (e.Erro == "0" || e.Erro == "010")){
                    temGratis = true;
                }
                var a = e.PrazoEntrega,
                    t = parseInt(e.Erro),
                    s = e.valor_frete_gratis,
                    c = e.Atacadista,
                    n = e.Brindes;

                if(s != 0){
                    valor_frete_gratis = s;
                }else{
                    valor_frete_gratis = 0;
                }

                //                if (a ? (a = parseInt(a) + 1, $(".mycart-delivery-item").eq(e.forma - 1).find('p:first').html(a + " DIAS ÚTEIS")) : $(".mycart-delivery-item").eq(i).find('p:first').html('--'), t) {
                if(a){
                    a = parseInt(a) + 1;
                    $('[name=forma_envio][value="' + e.forma +'"]').closest('li').find('p:first').html(a + " DIAS ÚTEIS");
                    $('[name=forma_envio][value="' + e.forma +'"]').closest('li').find('p:last').html("R$ " + reverb.formatNumber(carrinho.frete));
                    if(t == 0 || e.Erro == 'Não houve erro!' || e.Erro == '010'){
                        elementosDisponiveis.push(e.forma);
                    }


                    //                    reverb.alertMessage("error", r), carrinho.frete = 0
                }

                if(e.Erro == 'Cep invalido'){
                    reverb.alertMessage("error", "CEP inválido, por favor verifique o endereço de entrega!");
                }
            },
            complete: function() {
                //$("#my-cart-subtotal div").remove(), $("#my-cart-subtotal p, .product-subtotal").fadeIn();
                if(forma != 5){
                    carregaFretes(forma+1);
                }else{
                    if(temGratis){
                        $(".mycart-delivery-item").eq(6).addClass('active');
                        $(".mycart-delivery-item").eq(6).find('input[name=forma_envio]').attr('checked', true);
                        $(".mycart-delivery-item").eq(6).show();
                        carrinho.frete = 0;

                        r();
                    }else{
                        elementosDisponiveis.forEach(function(index){
                            $('[name=forma_envio][value="' + index +'"]').closest('li').show();
                        });

                        $(".mycart-delivery-item").removeClass('active');
                        $('input[name=forma_envio]').removeAttr('checked');
                    }

                    temGratis = false;
                    $(".mycart-delivery-item").eq(0).hide();
                    elementosDisponiveis = [];

                    if(valor_frete_gratis != 0){
//                            $('.frete-title').html('FRETE - Faltam <strong>R$ ' + reverb.formatNumber(valor_frete_gratis) + '</strong> para o frete grátis!');
                        $('.frete-title').html('FRETE');
                    }else{
                        $('.frete-title').html('FRETE');
                    }
                }
            }
        });
        //}
    }

    carregaFretes(1);

    $("#mycart-discount-button").on("click", function(e) {
        if (e.preventDefault(), 0 == carrinho.desconto) {
            var a = {
                cupom: $("#cupomcode").val(),
                json: !0,
                desativa: 0
            };
            $.ajax({
                url: document.basePath + "/carrinho-compras",
                type: "POST",
                dataType: "json",
                data: a,
                error: function() {
                    reverb.alertMessage("error", "Ocorreu algum erro ao verificar o vale desconto, por favor entre em contato com o administrador :/")
                },
                beforeSend: function() {
//                    var e = '<div class="loader ir">Carregando</div>';
//                    $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando...")
                },
                success: function(e) {
                    var r = e.valor_desconto,
                        a = e.erro,
                        o = e.msg_erro;
                    a ? reverb.alertMessage("error", o) : (carrinho.desconto = r, $("#mycart-discount-button").text("DESATIVAR"), $("#cupomcode").prop("disabled", !0), reverb.alertMessage("success", "Seu vale desconto foi calculado com sucesso!"))
                },
                complete: function() {
                    r()
                }
            })
        } else {
            var a = {
                cupom: $("#cupomcode").val(),
                json: !0,
                desativa: 1
            };
            $.ajax({
                url: document.basePath + "/carrinho-compras",
                type: "POST",
                dataType: "json",
                data: a,
                error: function() {
                    reverb.alertMessage("error", "Ocorreu algum erro ao desativar o vale desconto, por favor entre em contato com o administrador :/")
                },
                beforeSend: function() {
                    var e = '<div class="loader ir">Carregando</div>';
                    $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando...")
                },
                success: function(e) {
                    var r = (e.valor_desconto, e.erro),
                        a = e.msg_erro;
                    r ? reverb.alertMessage("error", a) : (carrinho.desconto = 0, $("#mycart-discount-button").text("ATUALIZAR"), $("#cupomcode").val("").prop("disabled", !1), reverb.alertMessage("success", "Você removeu o seu desconto, agora poderá utiliza-lo em outra compra!"))
                },
                complete: function() {
                    r()
                }
            })
        }
    });
    carregaFretes(1);
    //$('.mycart-payment-item input').on('change', function () {
    //    setTimeout(function () {
    //        $("#msg-box").remove();
    //    }, 200);
    //    var a = {
    //        paymentSelected: $('input[name=formapagto]:checked', '.mycart-payment-item').val(),
    //        json: !0,
    //        selecPayment: 1
    //    };
    //    $.ajax({
    //        url: document.basePath + "/carrinho-compras",
    //        type: "POST",
    //        dataType: "json",
    //        data: a,
    //        error: function (e) {
    //            setTimeout(function () {
    //                $("#msg-box").remove();
    //            }, 200);
    //            return;
    //        },
    //        beforeSend: function () {
    //            var e = '<div class="loader ir">Carregando</div>';
    //            $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando...")
    //        },
    //        success: function (e) {
    //            var r = e.valor_desconto, a = e.erro, o = e.msg_erro;
    //            a ? reverb.alertMessage("error", o) : (carrinho.desconto = r, reverb.alertMessage("success", o));
    //        },
    //        complete: function () {
    //            r();
    //            setTimeout(function () {
    //                $("#msg-box").remove();
    //            }, 2000);
    //        }
    //    });
    //});


    $('.mycart-edit-address').live('click', function (e) {
        e.preventDefault();

        $('input[name=endereco_id]').val($(this).closest('li').data('endereco_id'));

        $.ajax({
            url: document.basePath + "/carrinho/lista-endereco/endereco_id/" + $(this).closest('li').data('endereco_id'),
            type: "POST",
            beforeSend: function() {

            },
            error: function() {

            },
            success: function(result) {
                $('#newaddress-nome').val(result.endereco.DS_DESTINATARIO_ENRC);
                $('#newaddress-cep').val(result.endereco.DS_CEP_ENRC);
                $('#newaddress-pesquisa').click();
                $('#newaddress-endereco').val(result.endereco.DS_ENDERECO_ENRC);
                $('#newaddress-numero').val(result.endereco.DS_NUMERO_ENRC);
                $('#newaddress-complemento').val(result.endereco.DS_COMPLEMENTO_ENRC);
                $('#newaddress-bairro').val(result.endereco.DS_BAIRRO_ENRC);
                $('#newaddress-bairro').val(result.endereco.DS_BAIRRO_ENRC);
            },
            complete: function() {}
        });

        $('.mycart-new-address').click();
    });

    //fake select
    $('.fake-select select').on('change', function(){
        $(this).parent().find('span').text($(this).find('option:selected').text());
    });

    // alteração do endereço (input radio)
    // 04.09.2014 -> Adicionar evento para calculo do frete dentro dessa função
    function addressModify(){
        $('.mycart-use-address').live('click', function() {

            //remove a classe do antigo e volta com texto normal
            $('.mycart-address-item').removeClass('active');
            $('.mycart-use-address span').text('Usar esse endereço');

            // adiciona a classe no selecionado e altera o texto para selecionado
            $(this).closest('.mycart-address-item').addClass('active');
            $(this).find('span').text('Endereço selecionado');

            if($(this).closest('li').index() != 0){
                $('input[name=usar_mesmo]').val($(this).closest('li').data('endereco_id'));
                cep = $(this).closest('li').data('cep');
                carrinho.cep = cep;
            }else{
                $('input[name=usar_mesmo]').val(1);
                //cep = String(carrinho.cep);
                cep = $(this).closest('li').data('cep');
                carrinho.cep = cep;
            }

            carregaFretes(1);
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
            //var getURL = 'http://cep.republicavirtual.com.br/web_cep.php?cep=' + cep + '&formato=json';
            var getURL = document.basePath + '/json/busca-cep/cep/' + cep + '';

            // faz requisição AJAX
            $.getJSON(getURL, function(ev) {
                if (ev.resultado == 0) {
                    //alert('Desculpe, mas este cep não existe')
                } else {
                    //$('#newaddress-endereco').val() == "" ? $('#newaddress-endereco').val(ev.tipo_logradouro + ' ' + ev.logradouro) : '';
                    //$('#newaddress-bairro').val() == "" ? $('#newaddress-bairro').val(ev.bairro) : '';
                    $('#newaddress-endereco').val(ev.tipo_logradouro + ' ' + ev.logradouro);
                    $('#newaddress-bairro').val(ev.bairro)
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
        $('input[name=forma_envio]').on('change', function() {
            //remove a classe do antigo e volta com texto normal
            $('.mycart-delivery-item').removeClass('active');

            // adiciona a classe no selecionado e altera o texto para selecionado
            $('input[name=forma_envio]:checked').closest('.mycart-delivery-item').addClass('active');

            var valorFrete = $(this).closest('li').find('.mycart-delivery-value').html();

            $('#mycart-subtotal p:eq(1) span:last').html(valorFrete);

            //valorFrete = reverb.returnNumbers(valorFrete);
            valorFrete = valorFrete.replace('R$ ', '');
            carrinho.frete = parseFloat(valorFrete.replace(',', '.'));
            r();
        });
    }
    deliveryModify();

    // função para alteração do pagamento (input radio)
    function paymentModify(){
        $('input[name=formapagto]').on('change', function() {
            if($('#msg-box p').text() == "Escolha uma forma de pagamento" || $('#msg-box p').text() == "Preencha todos os dados do seu cartão"){
                $("#msg-box").fadeOut(200);
                setTimeout(function(){
                    $("#msg-box").remove();
                }, 200);
            }
            //remove a classe do antigo e volta com texto normal
            $('.mycart-payment-item').removeClass('active');

            // adiciona a classe no selecionado e altera o texto para selecionado
            $('input[name=formapagto]:checked').closest('.mycart-payment-item').addClass('active');
        });
    }
    paymentModify();
});
