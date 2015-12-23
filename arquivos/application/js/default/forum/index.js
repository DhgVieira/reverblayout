reverb.createNewPoll = function() {
    if (!reverb.isMobile()) {
        tinymce.init({
            theme: "modern",
            skin: "light",
            selector: ".tinymce-on",
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
            menubar: false,
            toolbar: "image media link | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | emoticons",
            theme_advanced_toolbar_location: "bottom",
            statusbar: false
        })
    } else {
        tinymce.init({
            theme: "modern",
            skin: "light",
            selector: ".tinymce-on",
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
            menubar: false,
            toolbar: "image media link | bold italic underline | emoticons",
            theme_advanced_toolbar_location: "bottom",
            statusbar: false
        })
    }
    $("#search-post .input-box").autocomplete({
        source: function(e, t) {
            $.ajax({
                url: document.basePath + "/json/autocompleteforum/",
                data: {
                    filter: e.term
                },
                dataType: "json",
                success: function(e) {
                    t(e)
                }
            })
        },
        appendTo: "#search-post",
        delay: 500,
        minLength: 3
    });
    $("#search-poll .input-box").autocomplete({
        source: function(e, t) {
            $.ajax({
                url: document.basePath + "/json/autocompleteenquete/",
                data: {
                    filter: e.term
                },
                dataType: "json",
                success: function(e) {
                    t(e)
                }
            })
        },
        appendTo: "#search-poll",
        delay: 500,
        minLength: 3
    });
    $("#dataselecionada").datepicker();
    $("#data-enquete input").on({
        change: function() {
            var e = $(this).val();
            $(this).prev().text(e)
        }
    });
    $("#datadefinalizacao").on("change", function() {
        var e = $(this).is(":checked");
        if (e) {
            $("#qev").slideUp(500)
        } else {
            $("#qev").slideDown(500)
        }
    });
    $("#cadastrarop").on({
        click: function(e) {
            e.preventDefault();
            var t = $("#inputimagem").val(),
                n = $("#opcao").val();
            if (n == "") {
                $("#opcao").addClass("error").attr("placeholder", "Preencha este campo!");
                return false
            } else {
                $("#opcao").removeClass("error").attr("placeholder", "");
                var r = "";
                r += "<li>";
                r += '<div class="bg-image imagem-op">';
                r += '<a href="#" class="img-remove">REMOVER</a>';
                r += '<div class="img-add">';
                r += "<p>Clique e selecione a imagem</p>";
                r += '<input class="img-input" type="file" name="fotos[]" value="">';
                r += "</div>";
                r += '<div class="img">';
                r += '<img class="img-preview" src="" alt="" width="67" height="67"/>';
                r += "</div>";
                r += "</div>";
                r += '<div class="texto-desc-op">';
                r += n;
                r += '<input type="hidden" name="opcoes[]" value="' + n + '">';
                r += "</div>";
                r += '<a href="#" class="excluir-op"></a>';
                r += "</li>";
                $("#listadeopcoes").animate({
                    opacity: 1,
                    height: 196
                }, 500, function() {
                    $("#listadeopcoes").append(r);
                    $("#opcao").val("");
                    $("#listadeopcoes .excluir-op").on({
                        click: function(e) {
                            e.preventDefault();
                            $(this).parent().fadeOut(400, function() {
                                $(this).remove();
                                var e = $("#listadeopcoes li").length > 0 ? 196 : 0;
                                $("#listadeopcoes").height(e)
                            })
                        }
                    });
                    $(".img-input").on("change", function() {
                        var e = URL.createObjectURL($(this).get(0).files[0]);
                        $(this).closest(".imagem-op").find(".img").fadeIn().find(".img-preview").attr("src", e);
                        $(this).closest(".imagem-op").find(".img-remove").fadeIn()
                    });
                    $(".img-remove").on("click", function(e) {
                        e.preventDefault();
                        $(this).closest(".imagem-op").find(".img-remove").fadeOut();
                        $(this).closest(".imagem-op").find(".img").fadeOut().find(".img-preview").attr("src", "");
                        var t = $(this).closest(".imagem-op").find(".img-input");
                        t.replaceWith(t = t.clone(true))
                    })
                })
            }
        }
    })
};
reverb.showMorePolls = function() {
    $("#show-more-polls").on("click", function(e) {
        e.preventDefault();
        var t = $("#polls-table .row-content").length;
        $.ajax({
            url: document.basePath + "/forum/jsonenquete/start/" + t,
            type: "GET",
            error: function() {
                $("#show-more-polls").parent().append('<p class="text-error text-center">Ocorreu algum erro, por favor contacte o administrador do site</p>');
                $("#show-more-polls").remove()
            },
            beforeSend: function() {
                $("#show-more-polls").hide();
                $("#show-more-polls").next(".forum-loder").show()
            },
            success: function(e) {
                console.log("success");
                for (var t = 0; t < e.length; t++) {
                    var n = {
                        title: reverb.utf8_decode(e[t].titulo_enquete),
                        author: reverb.utf8_decode(e[t].DS_NOME_CASO),
                        date: e[t].data_inicio,
                        votes: e[t].total_votos,
                        linkEnquete: document.basePath + "/enquete/" + e[t].idenquete,
                        linkAuthor: document.basePath + "/perfil/" + e[t].DS_NOME_CASO + "/" + e[t].idautor
                    };
                    var r = "";
                    r += '<tr class="row-content">';
                    r += '<td class="rvb-table-lists-item content content">';
                    r += '<a class="topic-title" href="' + n.linkEnquete + '">' + n.title + "</a>";
                    r += '<p>Post <abbr class="timeago" title="' + n.date + '">' + n.date + '</abbr> by</p>';
                    r += '<a href="' + n.linkAuthor + '">' + n.author + '</a>';
                    r += "</td>";
                    r += '<td class="rvb-table-lists-item posts"><p>' + n.votes + "</p><span> Votos</span></td>";
                    r += "</tr>";

                    //var r = "";
                    //r += '<tr class="row-content">';
                    //r += '<td class="rvb-table-lists-item content">';
                    //r += '<a class="topic-title" href="' + n.linkTopic + '">' + n.title + "</a>";
                    //r += '<p>Post <abbr class="timeago" title="' + n.lastPost + '">' + n.lastPost + '</abbr> by</p>';
                    //r += '<a href="' + n.linkAuthor + '">' + n.author + '</a>';
                    //r += '</p>';
                    //r += "</td>";
                    //r += '<td class="rvb-table-lists-item posts"><p>' + n.numberPosts + "</p><span> Posts</span></td>";
                    //r += "</tr>";
                    $("#polls-table").append(r)
                }
                if (e.length < 1) {
                    $("#show-more-polls").parent().append('<p class="text-warning text-center">Não existem mais enquetes para serem carregadas</p>');
                    $("#show-more-polls").next(".forum-loder").hide();
                    $("#show-more-polls").remove()
                }
                console.log(e.length)
            },
            complete: function() {
                $("#show-more-polls").hide();
                $("#show-more-polls").next(".forum-loder").show()
            }
        })
    })
};
reverb.showMoreTopics = function() {
    $("#show-more-topics").on("click", function(e) {
        e.preventDefault();
        var t = $("#topics-table .row-content").length;
        $.ajax({
            url: document.basePath + "/forum/jsonforum/start/" + t,
            error: function() {
                $("#show-more-topics").parent().append('<p class="text-error text-center">Ocorreu algum erro, por favor contacte o administrador do site</p>');
                $("#show-more-topics").remove()
            },
            beforeSend: function() {
                $("#show-more-topics").hide();
                $("#show-more-topics").next(".forum-loder").show()
            },
            success: function(e) {
                for (var t = 0; t < e.length; t++) {
                    var n = {
                        title: reverb.utf8_decode(e[t].DS_TOPICO_TOSO),
                        author: reverb.utf8_decode(e[t].DS_NOME_CASO),
                        lastPost: e[t].DT_ULTIMOPOST_TOSO,
                        numberPosts: e[t].NR_MSGS_TOSO,
                        linkTopic: document.basePath + "/detalhe-forum/" + e[t].DS_TOPICO_TOSO + "/" + e[t].NR_SEQ_TOPICO_TOSO,
                        linkAuthor: document.basePath + "/perfil/" + e[t].DS_NOME_CASO + "/" + e[t].NR_SEQ_CADASTRO_CASO
                    };
                    var r = "";
                    r += '<tr class="row-content">';
                    r += '<td class="rvb-table-lists-item content">';
                    r += '<a class="topic-title" href="' + n.linkTopic + '">' + n.title + "</a>";
                    r += '<p>Post <abbr class="timeago" title="' + n.lastPost + '">' + n.lastPost + '</abbr> by</p>';
                    r += '<a href="' + n.linkAuthor + '">' + n.author + '</a>';
                    r += '</p>';
                    r += "</td>";
                    r += '<td class="rvb-table-lists-item posts"><p>' + n.numberPosts + "</p><span> Posts</span></td>";
                    r += "</tr>";
                    $("#topics-table").append(r)
                }
                if (e.length < 1) {
                    $("#show-more-topics").parent().append('<p class="text-warning text-center">Não existem mais tópicos para serem carregadas</p>');
                    $("#show-more-topics").next(".forum-loder").hide();
                    $("#show-more-topics").remove()
                }
            },
            complete: function() {
                $("#show-more-topics").show();
                $("#show-more-topics").next(".forum-loder").hide();
                reverb.timeAgo();
            }
        })
    })
};
reverb.timeAgo = function() {
    $("abbr.timeago").timeago();
};
$(function() {
    reverb.createNewPoll();
    reverb.showMorePolls();
    reverb.showMoreTopics();
    reverb.timeAgo();
});