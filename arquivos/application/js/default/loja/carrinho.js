reverb.buscarCepSuccess = function(e) {
    0 == e.resultado ? reverb.alertMessage("error", "Desculpe, mas este cep não foi encontrado.") : ($("#fake_endereco_endereco").val(e.tipo_logradouro + " " + e.logradouro), $("#fake_endereco_bairro").val(e.bairro), new dgCidadesEstados({
        estado: $("#fake_endereco_estado").get(0),
        cidade: $("#fake_endereco_cidade").get(0),
        estadoVal: e.uf,
        cidadeVal: e.cidade
    }), $("#fake_endereco_estado").siblings("span").text(e.uf), $("#fake_endereco_cidade").siblings("span").text(e.cidade), $("#estado").prev().text(e.uf), $("#cidade").prev().text(e.cidade))
}, reverb.cart = function() {
    function e() {
        $("#fake_endereco_buscarCep").on("click", function() {
            var e = reverb.returnNumbers($("#fake_endereco_cep").val());
            if (8 == e.length) {
                var r = "http://cep.republicavirtual.com.br/web_cep.php?cep=" + e + "&formato=json";
                $.getJSON(r, function(e) {
                    reverb.buscarCepSuccess(e)
                }), $("#fake_endereco_cep").removeClass("error")
            } else $("#fake_endereco_cep").attr("placeholder", "Preencha o CEP corretamente...").addClass("error")
        }), $("#fake_endereco_cep").on("blur", function() {
            $("#fake_endereco_buscarCep").trigger("click"), $("#zipcode").val($("#fake_endereco_cep").val())
        }), new dgCidadesEstados({
            estado: $("#fake_endereco_estado").get(0),
            cidade: $("#fake_endereco_cidade").get(0)
        }), $("#delivery-address .select-box").on("change", function() {
            var e = $(this).find("option:checked").text();
            $(this).parent().find("span").html(e)
        }), $("#use_the_same").on("change", function() {
            $(this).is(":checked") ? ($(".rvb-field").addClass("disabled").find("input,select,button").prop("disabled", !0), $("#usar_mesmo").prop("checked", !0)) : ($(".rvb-field").removeClass("disabled").find("input,select,button").prop("disabled", !1), $("#fake_endereco_nome").focus(), $("#usar_mesmo").prop("checked", !1))
        }), $("#delivery-address .rvb-field input, #delivery-address .rvb-field select").on("change", function() {
            $("#endereco_nome").val($("#fake_endereco_nome").val()), $("#endereco_cep").val($("#fake_endereco_cep").val()), $("#endereco_endereco").val($("#fake_endereco_endereco").val()), $("#endereco_numero").val($("#fake_endereco_numero").val()), $("#endereco_complemento").val($("#fake_endereco_complemento").val()), $("#endereco_bairro").val($("#fake_endereco_bairro").val()), $("#endereco_estado").val($("#fake_endereco_estado").val()), $("#endereco_cidade").val($("#fake_endereco_cidade").val()), $("#endereco_telefone").val($("#fake_endereco_telefone").val()), $("#endereco_celular").val($("#fake_endereco_celular").val())
        })
    }

    function r() {
        function e(e, r, a) {
            $("#msg-box").remove();
            var o = {
                json: !0,
                cep: reverb.returnNumbers(e),
                subtotal: r,
                forma_envio: $(".type_delivery:checked").val()
            };
            0 != o.cep.length ? $.ajax({
                url: document.basePath + "/checkout/correios",
                type: "POST",
                dataType: "json",
                data: o,
                error: function() {
                    reverb.alertMessage("error", "Ocorreu um erro ao calcular o frete, por favor contate o administrador do site :/")
                },
                beforeSend: function() {
                    var e = '<div class="loader ir">Carregando</div>';
                    $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando..."), $("#time-delivery").text("Carregando...")
                },
                success: function(e) {
                    carrinho.frete = parseFloat(e.Valor);
                    var r, a = e.PrazoEntrega,
                        t = parseInt(e.Erro),
                        s = e.valor_frete_gratis,
                        c = e.Atacadista,
                        n = e.Brindes;
                    if (a ? (a = parseInt(a) + 1, $("#time-delivery").html("Prazo estimado de <br/> Entrega: <strong>" + a + " dias úteis<s/strong>!")) : $("#time-delivery").empty(), t) {
                        switch (t) {
                            case -3:
                                r = "CEP de destino inválido.", carrinho.msgErro = "CEP de destino inválido.";
                                break;
                            case -6:
                                r = "Serviço de entrega indisponível para o trecho informado. Escolha outra forma de envio.", carrinho.msgErro = "Serviço de entrega indisponível para o trecho informado. Escolha outra forma de envio.";
                                break;
                            case -33:
                                r = "Sistema dos correios temporariamente fora do ar. Favor tentar mais tarde.", carrinho.msgErro = "Sistema dos correios temporariamente fora do ar. Favor tentar mais tarde.";
                                break;
                            case 6:
                                r = "Localidade de origem não abrange o serviço informado.", carrinho.msgErro = "Localidade de origem não abrange o serviço informado.";
                                break;
                            case 7:
                                r = "Localidade de origem não abrange o serviço informado.", carrinho.msgErro = "Localidade de origem não abrange o serviço informado.";
                                break;
                            case 8:
                                r = "Serviço de entrega indisponível para o trecho informado. Escolha outra forma de envio.", carrinho.msgErro = "Serviço de entrega indisponível para o trecho informado. Escolha outra forma de envio.";
                                break;
                            case 9:
                                r = "Este serviço é disponivel apenas para camisetas.", carrinho.msgErro = "Este serviço é disponivel apenas para camisetas.";
                                break;
                            case 10:
                                r = "Informe o CEP de uma agência mais proxima ou entre em contato com o SAC.", carrinho.msgErro = "Informe o CEP de uma agência mais proxima ou entre em contato com o SAC.";
                                break;
                            default:
                                r = "Ocorreu algum erro ao calcular o frete, por favor entre em contato com o administrador.", carrinho.msgErro = "Ocorreu algum erro ao calcular o frete, por favor entre em contato com o administrador."
                        }
                        reverb.alertMessage("error", r), carrinho.frete = 0
                    } else carrinho.cep = o.cep, c || n ? c && ($("#free-delivery").empty().removeClass("text-success"), $(".type_delivery").closest("li").removeClass("hidden")) : 0 == carrinho.frete ? ($("#free-delivery").empty().append("Você pode desfrutar do <br/> <strong>frete grátis!</strong>").removeClass("text-error").addClass("text-success"), $(".type_delivery").closest("label").removeClass("active").closest("li").addClass("hidden"), $("#pac").prop("checked", !0).closest("label").addClass("active").closest("li").removeClass("hidden")) : ($("#free-delivery").empty().append("Faltam <strong>R$ " + reverb.formatNumber(s) + "</strong> para o <br/> <strong>frete grátis!</strong>").addClass("text-error").removeClass("text-success"), $(".type_delivery").closest("li").removeClass("hidden")), carrinho.msgErro = 0
                },
                complete: function() {
                    $("#my-cart-subtotal div").remove(), $("#my-cart-subtotal p, .product-subtotal").fadeIn(), a()
                }
            }) : ($("#my-cart-subtotal div").remove(), $("#my-cart-subtotal p, .product-subtotal").fadeIn(), carrinho.frete = 0, a())
        }

        function r() {
            carrinho.quantidade = 0, carrinho.subTotal = 0, carrinho.subTotal = 0, carrinho.frete = 0, carrinho.total = 0, $.each($(".my-cart-content-item"), function(e) {
                var r = $(this).data("valorproduto"),
                    a = parseInt($(this).find("select[name=amount]").val()),
                    o = r * a;
                carrinho.subTotal += o, carrinho.quantidade += a, $(this).find(".product-subtotal span").text("R$ " + reverb.formatNumber(o)), $($("#mobile-header .flyout-list.my-cart-items li")[e]).find(".product-amount").text("Quantidade " + a), $($("#mobile-header .flyout-list.my-cart-items li")[e]).find(".product-price").text("R$ " + reverb.formatNumber(o)), $($("#desktop-header .flyout-list.my-cart-items li")[e]).find(".product-amount").text("Quantidade " + a), $($("#desktop-header .flyout-list.my-cart-items li")[e]).find(".product-price").text("R$ " + reverb.formatNumber(o))
            }).promise().done(function() {
                e($("#zipcode").val(), carrinho.subTotal, function() {
                    carrinho.total = carrinho.frete + carrinho.subTotal - carrinho.desconto, carrinho.total = carrinho.total < 0 ? 0 : carrinho.total, $(".quantidade .result").text(parseInt(carrinho.quantidade)), $(".subtotal .result").text("R$ " + reverb.formatNumber(carrinho.subTotal)), $(".delivery .result").text("R$ " + reverb.formatNumber(carrinho.frete)), $(".discount .result").text("R$ " + reverb.formatNumber(carrinho.desconto)), $(".total .result").text("R$ " + reverb.formatNumber(carrinho.total)), $(".reverb-flyout.cart").find(".total").text("Total: R$ " + reverb.formatNumber(carrinho.total))
                })
            })
        }
        carrinho = {
            quantidade: $("#my-cart-subtotal").data("quantidade"),
            subTotal: $("#my-cart-subtotal").data("subtotal"),
            frete: $("#my-cart-subtotal").data("frete"),
            desconto: $("#my-cart-subtotal").data("desconto"),
            total: $("#my-cart-subtotal").data("total"),
            cep: $("#my-cart-subtotal").data("cep"),
            msgErro: 0
        }, $("select[name=amount]").on("change", function() {
            var e = {
                idEstoque: $(this).closest(".my-cart-content-item").data("idestoque"),
                qtdEstoque: $(this).val()
            };
            $.ajax({
                url: document.basePath + "/checkout/aumentarquantidade/idestoque/" + e.idEstoque + "/quantidade/" + e.qtdEstoque,
                type: "GET",
                beforeSend: function() {
                    var e = '<div class="loader ir">Carregando</div>';
                    $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando...")
                },
                error: function() {
                    reverb.alertMessage("error", "Ocorreu um erro ao calcular os valores, por favor contate o administrador do site do site :/")
                },
                success: function() {
                    r()
                },
                complete: function() {}
            })
        }), $("#calcular-frete").on("click", function(e) {
            e.preventDefault();
            var a = '<div class="loader ir">Carregando</div>';
            $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(a), $("#free-delivery").text("Carregando..."), 0 != $("#zipcode").val().length ? r() : reverb.alertMessage("error", "Digite o cep para poder calcular!")
        }), $(".type_delivery").on("change", function() {
            0 != $("#zipcode").val().length && r()
        }), $("#calcular-cupom").on("click", function(e) {
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
                        var e = '<div class="loader ir">Carregando</div>';
                        $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando...")
                    },
                    success: function(e) {
                        var r = e.valor_desconto,
                            a = e.erro,
                            o = e.msg_erro;
                        a ? reverb.alertMessage("error", o) : (carrinho.desconto = r, $("#calcular-cupom").text("Desativar"), $("#cupomcode").prop("disabled", !0), reverb.alertMessage("success", "Seu vale desconto foi calculado com sucesso!"))
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
                        r ? reverb.alertMessage("error", a) : (carrinho.desconto = 0, $("#calcular-cupom").text("Utilizar"), $("#cupomcode").val("").prop("disabled", !1), reverb.alertMessage("success", "Você removeu o seu desconto, agora poderá utiliza-lo em outra compra!"))
                    },
                    complete: function() {
                        r()
                    }
                })
            }
        }), $(".icon-rvb-remove").on("click", function(e) {
            e.preventDefault();
            var a = $(this).closest(".my-cart-content-item"),
                o = $(this).closest(".my-cart-content-item").index(),
                t = a.data("idestoque"),
                s = a.data("idproduto");
            if (t) params = {
                idestoque: t
            };
            else {
                if (!s) return reverb.alertMessage("error", "Ocorreu algum erro ao remover seu produto, por favor entre em contato com o administrador :/"), !1;
                params = {
                    idproduto: s
                }
            }
            var c = confirm("Você tem certeza que quer remover esse produto?");
            c && $.ajax({
                url: document.basePath + "/checkout/removercarrinho",
                type: "POST",
                data: params,
                error: function() {
                    reverb.alertMessage("error", "Ocorreu algum erro ao remover seu produto, por favor entre em contato com o administrador :/")
                },
                beforeSend: function() {
                    var e = '<div class="loader ir">Carregando</div>';
                    $("#my-cart-subtotal p, .product-subtotal").fadeOut(), $("#my-cart-subtotal").append(e), $("#free-delivery").text("Carregando...")
                },
                success: function() {
                    a.fadeOut("500", function() {
                        a.remove(), $($(".cart ul li")[o]).remove(), $("#orderCountValue").text($(".my-cart-content-item").length), r()
                    }), reverb.alertMessage("success", "O Produto foi removido com sucesso do seu carrinho!")
                },
                complete: function() {}
            })
        })
    }
    $(".select-item select").on({
        change: function() {
            var e = $(this).val();
            $(this).parent().find("span").html(e)
        }
    }), $(".my-cart-payment-item").on("click", function() {
        return $(this).hasClass("current") ? !1 : ($(".my-cart-payment-item").removeClass("current"), $(this).addClass("current"), $(".radio-icon").removeClass("active"), $(this).find(".radio-icon input").prop("checked", !0), $(this).find(".radio-icon").addClass("active"), $(".my-cart-payment-item").find(".input-card-numbers").val("").prop("disabled", !0), $(this).find(".input-card-numbers").prop("disabled", !1).focus(), $(".my-cart-payment-item").find(".select-option select").prop("disabled", !0), void $(this).find(".select-option select").prop("disabled", !1))
    }), $(".input-card-numbers").on("keyup", function() {
        reverb.onlyNumbers(this)
    }), $(".cep").mask("99.999-999"), $(".delivery-types .footer-ui-button input").on("change", function() {
        $(".delivery-types .footer-ui-button").removeClass("active"), $(this).parent().addClass("active")
    }), $(".label-checkbox input").change(function() {
        $(this).parent().toggleClass("active")
    }), e(), r(), $("#step-1 .next-step").on("click", function(e) {
        e.preventDefault();
        var r = !0;
        "PJ" == $("#my-cart-subtotal").data("usuario") ? carrinho.quantidade < 30 ? (r = !0, reverb.alertMessage("error", "Atacadistas devem ter no mínimo 30 peças para poder continuar")) : $("select[name=amount][data-tipo=142]").length ? $.each($("select[name=amount][data-tipo=142]"), function() {
            var e = $(this);
            return e.val() < 10 ? (r = !0, reverb.alertMessage("error", "A quantidade mínima para bonés é de 10 peças"), !1) : void(r = !1)
        }) : r = !1 : r = !1, window.setTimeout(function() {
            function e() {
                var e = 0,
                    r = 0,
                    a = "";
                switch (!0) {
                    case carrinho.total > 150:
                        r = 4;
                        break;
                    case carrinho.total > 100:
                        r = 3;
                        break;
                    case carrinho.total > 50:
                        r = 2;
                        break;
                    default:
                        r = 1
                }
                for (var o = 1; r >= o; o++) e = reverb.formatNumber(carrinho.total / o), a += "<option value=" + o + ">0" + o + "x de R$ " + e + "</option>";
                $(".select-parcelas").html(a), $(".select-parcelas").siblings("span").text("01x de R$ " + reverb.formatNumber(carrinho.total)), $(".quantidade-parcelas").text(r + "x")
            }

            function a() {
                $(".select-parcelas").on("change", function() {
                    $(this).parent().find("span").text($(this).find("option:checked").text())
                })
            }
            r || (0 === $("#zipcode").val().length && 0 === carrinho.frete ? reverb.alertMessage("error", "Não se esqueça de calcular o frete!") : $("#use_the_same").is(":checked") && reverb.returnNumbers($("#buyer-cep").text()) != carrinho.cep ? reverb.alertMessage("error", "Opss, o CEP calculado é diferente do CEP para entrega.") : $("#use_the_same").is(":checked") || reverb.returnNumbers($("#fake_endereco_cep").val()) == carrinho.cep ? $("#use_the_same").is(":checked") || "" !== $("#fake_endereco_nome").val() ? $("#use_the_same").is(":checked") || "" !== $("#fake_endereco_endereco").val() ? $("#use_the_same").is(":checked") || "" !== $("#fake_endereco_numero").val() ? $("#use_the_same").is(":checked") || "" !== $("#fake_endereco_bairro").val() ? $("#use_the_same").is(":checked") || "" !== $("#fake_endereco_estado").val() ? $("#use_the_same").is(":checked") || "" !== $("#fake_endereco_cidade").val() ? $("#use_the_same").is(":checked") || "" !== $("#fake_endereco_telefone").val() || "" !== $("#fake_endereco_celular").val() ? 0 !== carrinho.msgErro ? reverb.alertMessage("error", carrinho.msgErro) : (e(), a(), $(".my-cart-steps .steps").removeClass("current"), $(".my-cart-steps .step-2").addClass("current"), $("#step-1").addClass("hidden"), $("#step-2").removeClass("hidden"), $("html, body").animate({
                scrollTop: 0
            }, 500)) : reverb.alertMessage("error", "Precisamos de pelo menos um telefone de contato seu") : reverb.alertMessage("error", "Não esqueça de selecionar a cidade") : reverb.alertMessage("error", "Não esqueça de selecionar o estado") : reverb.alertMessage("error", "Não esqueça de insisrir o nome do bairro") : reverb.alertMessage("error", "Não esqueça de insisrir o número da residencia") : reverb.alertMessage("error", "Qual o nome da rua para entregar mesmo?") : reverb.alertMessage("error", "Não esqueça de inserir o nome de quem receberá os produtos ;)") : reverb.alertMessage("error", "Opss, o CEP calculado é diferente do CEP para entrega."))
        }, 300)
    }), $("#step-2 .buy-more-items").on("click", function(e) {
        e.preventDefault(), $(".my-cart-steps .steps").removeClass("current"), $(".my-cart-steps .step-1").addClass("current"), $("#step-2").addClass("hidden"), $("#step-1").removeClass("hidden")
    })
}, $(function() {
    reverb.cart()
});