reverb.tabelaMedidas = function() {
    $("#show-sizes").on("click", function(e) {
        e.preventDefault();
        var t = $("#img-preview");
        var n = $("#tabela-medidas-img");
        var r = $("#sizes-list li");
        var i = $(this).data("idproduto");
        var jsonListe;
        $.ajax({
            url: document.basePath + "/loja/jsonmedidas/idproduto/" + i,
            type: "GET",
            error: function() {},
            beforeSend: function() {
                t.css("opacity", "0");
                n.css("opacity", "0");
                r.css("opacity", "0")
            },
            complete: function() {
                t.animate({
                    opacity: "1"
                }, 500);
                n.animate({
                    opacity: "1"
                }, 500);
                r.animate({
                    opacity: "1"
                }, 500)
                
                $("#sizes-list li").removeClass("active");
                $("#sizes-list li").first().addClass("active");
                r.live("click", function(s) {
                    s.preventDefault();
                    var o = document.basePath + "/arquivos/uploads/modelos/" + jsonListe[$(this).data('size')].imagem_modelo;
                    var u = document.basePath + "/arquivos/uploads/medidas/" + jsonListe[$(this).data('size')].imagem_tamanho;
                    $("#sizes-list li").removeClass("active");
                    $(this).addClass("active");
                    t.attr("src", o);
                    n.attr("src", u)
                })
            },
            success: function(e) {
                jsonListe = e;
                count = e.length;
                $("#sizes-list").html('');
                $.each(e, function(indice, tabela_medida) {
                    $('#desc h3').text(tabela_medida.descricao);
                    $('#sizes-list').append('<li data-size="' + indice + '"><span>' + tabela_medida.tamanho + '</span></li>');
                });
                var i = document.basePath + "/arquivos/uploads/modelos/" + e[0].imagem_modelo;
                var s = document.basePath + "/arquivos/uploads/medidas/" + e[0].imagem_tamanho;
                t.attr("src", i);
                n.attr("src", s);
            }
        })
    })
};
$(function() {
    reverb.tabelaMedidas();
    new dgCidadesEstados({
        estado: $("#avise-estado").get(0),
        cidade: $("#avise-cidade").get(0)
    });
    $(".carousel").jcarousel({
        wrap: "last",
        scroll: 1
    });
    $(".carousel").touchwipe({
        wipeDown: function() {
            $(".carousel").jcarousel("scroll", "+=1")
        },
        wipeUp: function() {
            $(".carousel").jcarousel("scroll", "-=1")
        }
    });
    $("#moveprev").on("click", function(e) {
        e.preventDefault();
        $(".carousel").jcarousel("scroll", "-=1")
    });
    $("#movenext").on("click", function(e) {
        e.preventDefault();
        $(".carousel").jcarousel("scroll", "+=1")
    });
    $(".prod-thumbnails-items a img").on("click", function(e) {
        e.preventDefault()
    });
    $(".md-trigger").on("click", function(e) {
        $('select[name=tamanho] option[value=' + $(this).data('idtamanho') + ']').attr('selected', 'selected');
        $('select[name=tamanho]').change();
        e.preventDefault()
    });
    $("#tamanho , #estado, #cidade").change(function(e) {
        e.preventDefault();
        var t = $(this);
        t.find("span").text(t.find("option:selected").text())
    });
    $("#heading-details-product input").on("click", function(e) {
        e.preventDefault()
    });
    $("#trigger-detail").on("click", function(e) {
        e.preventDefault();
        if ($(this).hasClass("aberto")) {
            $(".details-product-heading").css("height", "165px");
            $(this).removeClass("aberto");
            $(this).text("+ info")
        } else {
            $(".details-product-heading").css("height", "initial");
            $(this).addClass("aberto");
            $(this).text("- info")
        }
    });
    $("#troca-btn").on("click", function(e) {
        e.preventDefault();
        if ($("#troca-btn").hasClass("ativo")) {
            $(".troca").stop().fadeOut();
            $("#troca-btn").removeClass("ativo")
        } else {
            $(".troca").stop().fadeIn();
            $("#troca-btn").addClass("ativo")
        }
    });
    $(".prodcurtiu").on("mouseover", function() {
//        
//        var comentarioid = $(this).data('comentarioid');
//        console.log(comentarioid)
//        if (!$(this).hasClass("ativo")) {
//            $(".listacurtiu_" + comentarioid).stop().fadeIn();
//            $(this).addClass("ativo");
//        }
    });
    $(".prodcurtiu").on("mouseout", function() {
        
//        var comentarioid = $(this).data('comentarioid');
//        console.log(comentarioid)
//        if ($(this).hasClass("ativo")) {
//            $(".listacurtiu_" + comentarioid).stop().fadeOut();
//            $(this).removeClass("ativo");
//        }
    });
    $(".calcula-frete, .calcula-prazo").on("click", function(e) {
        e.preventDefault();
        if (!$(this).data("logado")) {
            reverb.alertMessage("error", "Você precisa estar logado para calcular o frete");
            return false
        }
        $.get($(this).attr("href"), function(e) {}).done(function(e) {
            var t = parseFloat(e.Valor);
            var t = reverb.formatNumber(t);
            var n = parseInt(e.PrazoEntrega) + 1;
            $(".calcula-frete").text("R$" + t + "*");
            $(".calcula-prazo").text("Até " + n + " dias*")
        })
    });
    var e = function() {
        $("#zoom_01").elevateZoom({
            gallery: "prod-thumbnails-list",
            cursor: "pointer",
            galleryActiveClass: "active",
            imageCrossfade: true,
            loadingIcon: "/arquivos/default/images/spinner-product.gif"
        })
    };
    //if (!reverb.isMobile()) {
        e()
    //}
    $("#score").raty({
        score: function() {
            return $(this).attr("data-score")
        },
        click: function(e, t) {
            var n = $("#score").data("idproduto");
            var r = $("#score").data("logado");
            if (r) {
                $.get(document.basePath + "/avaliar-produto/" + n + "/" + e, function(e) {
                    reverb.alertMessage("success", "Avaliação enviada com sucesso!")
                })
            } else {
                reverb.alertMessage("error", "Você precisa estar logado para dar uma nota")
            }
        }
    });
    if (!($(".icon").hasClass("female") || $(".icon").hasClass("male"))) {
        $("ul.both").css("width", "90%")
    }
    if (!(parseInt($(".details-product-heading p").css("height")) > 92)) {
        $("#trigger-detail").css("display", "none")
    }
    $(".reply-comment-btn").on("click", function() {
        $(this).toggleClass("active");
        $(this).closest(".comments-item").find(".user-reply-comment").toggleClass("disabled").find("textarea").focus()
    });
    var t = '<input type="checkbox" class="checkbox" id="share-checkbox" />';
    $("#share-social").prepend(t)

    $("input.phonemask").mask("(99) 9999-9999?9").live("focusout", function(e) {
        var t, n, r;
        t = e.currentTarget ? e.currentTarget : e.srcElement;
        n = t.value.replace(/\D/g, "");
        r = $(t);
        r.unmask();
        if (n.length > 10) {
            r.mask("(99) 99999-999?9")
        } else {
            r.mask("(99) 9999-9999?9")
        }
    });
})