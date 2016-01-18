reverb.alterarDados = function() {
    $("#imagem_perfil").on("change", function(e) {
        $(this).closest("form").submit()
    });
    $(".edit-info").on({
        click: function(e) {
            e.preventDefault();
            $(this).toggleClass("record");
            if ($(this).hasClass("record")) {
                $(this).text("Gravar");
                $("#reverbme-profile input[readonly]").each(function() {
                    $(this).removeAttr("readonly")
                })
            } else {
                $(this).text("Alterar dados");
                $('#reverbme-profile input[data-readable="true"]').each(function() {
                    $(this).attr("readonly", true)
                });
                var t = {
                    nome: $("#nome").val(),
                    ocupacao: $("#ocupacao").val(),
                    cidade: $("#cidade").val(),
                    bandas: $("#bandas").val(),
                    twitter: $("#twitter").val(),
                    facebook: $("#facebook").val(),
                    json: true
                };
                $.ajax({
                    url: $("#reverbme-profile").attr("action"),
                    type: "POST",
                    dataType: "json",
                    data: t
                }).done(function() {
                    reverb.alertMessage("success", "Dados alterados com sucesso")
                }).fail(function() {
                    reverb.alertMessage("error", "Ocorreu algum erro ao alterar os dados :/")
                })
            }
        }
    })
};
reverb.details = function() {
    var e = $(".xp-bar .progress"),
        t = e.attr("data-value"),
        n = e.css({
            width: t
        });
    $(".label-checkbox input").change(function() {
        $(this).parent().toggleClass("active")
    });
    $(".rvb-my-orders .btn-detail").on("click", function(e) {
        e.preventDefault();
        $(this).toggleClass("opened")
    });
    if (!reverb.isMobile()) {
        tinymce.init({
            selector: "#full-post",
            theme: "modern",
            skin: "light",
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
            menubar: false,
            toolbar: "image media link | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | emoticons",
            theme_advanced_toolbar_location: "bottom",
            statusbar: false
        })
    } else {
        tinymce.init({
            selector: "#full-post",
            theme: "modern",
            skin: "light",
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
            menubar: false,
            toolbar: "image media link | bold italic underline | emoticons",
            theme_advanced_toolbar_location: "bottom",
            statusbar: false
        })
    }
    $("#searchFriendInput").autocomplete({
        source: function(e, t) {
            $.ajax({
                url: document.basePath + "/json/autocompleteamigo/",
                data: {
                    filter: e.term
                },
                dataType: "json",
                success: function(e) {
                    console.log("entrou");
                    t(e)
                }
            })
        },
        appendTo: "#rvb-header-friends",
        delay: 0,
        minLength: 3
    })
};
reverb.resetPagination = function(e, t, n, r) {
    if (n > 8) {
        var i = n - t;
        var s = parseInt(t) - 1;
        var o = parseInt(t) - 2;
        var u = parseInt(t) - 3;
        var a = parseInt(t) - 4;
        var f = parseInt(t) + 1;
        var l = parseInt(t) + 2;
        var c = parseInt(t) + 3;
        var h = parseInt(t) + 4;
        var p = "";
        if (t > 4) {
            if (i > 3) {
                p += "<li>";
                p += '<a href="#" class="prev">◀</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="1">1</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="dots">...</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + s + '">' + s + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + f + '">' + f + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="dots">...</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="next">▶</a>';
                p += "</li>"
            } else if (i == 3) {
                p += "<li>";
                p += '<a href="#" class="prev">◀</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="1">1</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="dots">...</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + s + '">' + s + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + f + '">' + f + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + l + '">' + l + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="next">▶</a>';
                p += "</li>"
            } else if (i == 2) {
                p += "<li>";
                p += '<a href="#" class="prev">◀</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="1">1</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="dots">...</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + o + '">' + o + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + s + '">' + s + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + f + '">' + f + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="next">▶</a>';
                p += "</li>"
            } else if (i == 1) {
                p += "<li>";
                p += '<a href="#" class="prev">◀</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="1">1</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="dots">...</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + u + '">' + u + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + o + '">' + o + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + s + '">' + s + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="next">▶</a>';
                p += "</li>"
            } else if (i == 0) {
                p += "<li>";
                p += '<a href="#" class="prev">◀</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="1">1</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="dots">...</a>';
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + a + '">' + a + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + u + '">' + u + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + o + '">' + o + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page" data-page="' + s + '">' + s + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
                p += "</li>";
                p += "<li>";
                p += '<a href="#" class="next disabled">▶</a>';
                p += "</li>"
            }
        } else if (t == 4) {
            p += "<li>";
            p += '<a href="#" class="prev">◀</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="1">1</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="2">2</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="3">3</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + f + '">' + f + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="dots">...</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="next">▶</a>';
            p += "</li>"
        } else if (t == 3) {
            p += "<li>";
            p += '<a href="#" class="prev">◀</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="1">1</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="2">2</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + f + '">' + f + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + l + '">' + l + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="dots">...</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="next">▶</a>';
            p += "</li>"
        } else if (t == 2) {
            p += "<li>";
            p += '<a href="#" class="prev">◀</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="1">1</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + f + '">' + f + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + l + '">' + l + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + c + '">' + c + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="dots">...</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="next">▶</a>';
            p += "</li>"
        } else if (t == 1) {
            p += "<li>";
            p += '<a href="#" class="prev disabled">◀</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page current" data-page="' + t + '">' + t + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + f + '">' + f + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + l + '">' + l + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + c + '">' + c + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + h + '">' + h + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="dots">...</a>';
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="page" data-page="' + n + '">' + n + "</a>";
            p += "</li>";
            p += "<li>";
            p += '<a href="#" class="next">▶</a>';
            p += "</li>"
        }
    } else if (n <= 8) {}
    e.html(p);
    r()
};
reverb.paginationGallery = function() {
    function i(t) {
        $.ajax({
            url: document.basePath + "/json/listafotos/start/" + t,
            type: "GET",
            error: function() {
                reverb.alertMessage("error", "Ocorreu algum erro ao carregar mais fotos, por favor recarregue a página ou entre em contato com o administrador :/")
            },
            beforeSend: function() {
                e.animate({
                    opacity: 0
                }, 100, function() {
                    e.html(r);
                    e.animate({
                        opacity: 1
                    }, 200)
                })
            },
            success: function(t) {
                var n = "";
                for (var r = 0; r < t.length; r++) {
                    var i = t[r].NR_SEQ_FOTO_FORC + "." + t[r].DS_EXT_FORC;
                    var s = t[r].DS_NOME_CASO;
                    var o = s.replace(/\s/g, "-");
                    var u = t[r].NR_SEQ_FOTO_FORC;
                    var a = "";
                    a += '<li class="rvb-photo-item">';
                    a += '<a href="' + document.basePath + "/people-detalhe/" + o + "/" + u + '" class="photo-thumb">';
                    a += '<img src="' + document.basePath + "/thumb/people/1/140/110/" + i + '" alt="michele...  na  reverb sp">';
                    a += "</a>";
                    a += '<a href="' + document.basePath + "/people-detalhe/" + o + "/" + u + '" class="photo-link">michele...  na  reverb sp</a>';
                    a += '<span class="comments">Comentários: 4</span>';
                    a += '<span class="views">Views: 497</span>';
                    a += '<a href="' + document.basePath + "/remover-foto/" + u + '" data-foto-id="' + u + '" class="md-close ir" title="Excluir foto">Excluir</a>';
                    a += '<ul class="social-share-small">';
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir facebook" target="_blank">Facebook</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir twitter" target="_blank">Twitter</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>';
                    a += "</li>";
                    a += "</ul>";
                    a += "</li>";
                    n += a
                }
                e.animate({
                    opacity: 0
                }, 300, function() {
                    e.html(n);
                    e.animate({
                        opacity: 1
                    }, 300)
                })
            }
        })
    }

    function s() {
        $("#gallery-pagination a.page").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("current")) {
                return false
            }
            e.css("min-height", e.height());
            $("#gallery-pagination a").removeClass("current");
            $(this).addClass("current");
            var o = $(this).data("page") - 1;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#gallery-pagination .pagination"), $(this).data("page"), t, s)
        });
        $("#gallery-pagination a.next").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#gallery-pagination a.current").data("page");
            var u = o * n;
            i(u);
            reverb.resetPagination($("#gallery-pagination .pagination"), o + 1, t, s)
        });
        $("#gallery-pagination a.prev").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#gallery-pagination a.current").data("page") - 2;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#gallery-pagination .pagination"), o + 1, t, s)
        })
    }
    var e = $("#gallery-list");
    var t = $("#gallery-pagination").data("lastpage");
    var n = $("#gallery-pagination").data("size");
    var r = '<span class="loading">Carregando...</span>';
    s()
};
reverb.paginationVideos = function() {
    function i(t) {
        $.ajax({
            url: document.basePath + "/json/listavideos/start/" + t,
            type: "GET",
            error: function() {
                reverb.alertMessage("error", "Ocorreu algum erro ao carregar mais videos, por favor recarregue a página ou entre em contato com o administrador :/")
            },
            beforeSend: function() {
                e.animate({
                    opacity: 0
                }, 100, function() {
                    e.html(r);
                    e.animate({
                        opacity: 1
                    }, 200)
                })
            },
            success: function(t) {
                var n = "";
                for (var r = 0; r < t.length; r++) {
                    var i = t[r].DS_NOME_VIRC;
                    var s = t[r].DS_YOUTUBE_VIRC;
                    var o = reverb.getYoutubeId(s);
                    var u = t[r].NR_SEQ_VIDEO_VIRC;
                    var a = "";
                    a += '<li class="rvb-video-item">';
                    a += '<a href="' + s + '" class="video-thumb">';
                    a += '<img src="http://img.youtube.com/vi/' + o + '/hqdefault.jpg" alt="' + i + '"></a>';
                    a += '<a href="' + s + '" title="' + i + '" class="video-link" target="_blank">' + i + "</a>";
                    a += '<a href="' + document.basePath + "/remover-video/" + u + '" data-video-id="' + u + '" class="md-close ir" title="Excluir vídeo">Excluir</a>';
                    a += '<ul class="social-share-small">';
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir facebook" target="_blank">Facebook</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir twitter" target="_blank">Twitter</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>';
                    a += "</li>";
                    a += "</ul>";
                    a += "</li>";
                    n += a
                }
                e.animate({
                    opacity: 0
                }, 300, function() {
                    e.html(n);
                    e.animate({
                        opacity: 1
                    }, 300)
                })
            }
        })
    }

    function s() {
        $("#videos-pagination a.page").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("current")) {
                return false
            }
            e.css("min-height", e.height());
            $("#videos-pagination a").removeClass("current");
            $(this).addClass("current");
            var o = $(this).data("page") - 1;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#videos-pagination .pagination"), $(this).data("page"), t, s)
        });
        $("#videos-pagination a.next").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#videos-pagination a.current").data("page");
            var u = o * n;
            i(u);
            reverb.resetPagination($("#videos-pagination .pagination"), o + 1, t, s)
        });
        $("#videos-pagination a.prev").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#videos-pagination a.current").data("page") - 2;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#videos-pagination .pagination"), o + 1, t, s)
        })
    }
    var e = $("#videos-list");
    var t = $("#videos-pagination").data("lastpage");
    var n = $("#videos-pagination").data("size");
    var r = '<span class="loading">Carregando...</span>';
    s()
};
reverb.paginationLatestPosts = function() {
    function i(t) {
        $.ajax({
            url: document.basePath + "/json/listaposts/start/" + t,
            type: "GET",
            error: function() {
                reverb.alertMessage("error", "Ocorreu algum erro ao carregar mais posts, por favor recarregue a página ou entre em contato com o administrador :/")
            },
            beforeSend: function() {
                e.animate({
                    opacity: 0
                }, 100, function() {
                    e.html(r);
                    e.animate({
                        opacity: 1
                    }, 200)
                })
            },
            success: function(t) {
                var n = "";
                for (var r = 0; r < t.length; r++) {
                    var i = reverb.getFullDate(t[r].data_publicacao);
                    var s = reverb.getHour(t[r].data_publicacao);
                    var o = t[r].idme_blog;
                    var u = "Testee";
                    var a = t[r].titulo;
                    var f = t[r].post.replace(/<[^>]*>/g, "").substr(0, 220) + "...";
                    var l = "";
                    l += '<div class="latest-post">';
                    l += '<a href="' + document.basePath + "/remover-post/" + o + '" data-post-id="' + o + '" class="md-close ir" title="Remover post">Excluir</a>';
                    l += '<a href="#" class="post-thumb">';
                    l += '<img src="http://dummyimage.com/120x143/888/ccc" alt="' + a + '">';
                    l += "</a>";
                    l += '<a href="#" class="post-title">' + a + "</a>";
                    l += '<p class="post-date">';
                    l += i + " ás  " + s + ' Por: <span class="post-author">' + u + "</span>";
                    l += "</p>";
                    l += '<p class="post-tiny-description"></p>';
                    l += "<p>";
                    l += f;
                    l += "</p>";
                    l += '<a href="#" class"idPost=idPostbutton comments">0 comentários</a>';
                    l += '<a href="#" class="button read-post">Ler post completo</a>';
                    l += "</div>";
                    n += l
                }
                e.animate({
                    opacity: 0
                }, 300, function() {
                    e.html(n);
                    e.animate({
                        opacity: 1
                    }, 300)
                })
            }
        })
    }

    function s() {
        $("#latest-posts-pagination a.page").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("current")) {
                return false
            }
            e.css("min-height", e.height());
            $("#latest-posts-pagination a").removeClass("current");
            $(this).addClass("current");
            var o = $(this).data("page") - 1;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#latest-posts-pagination .pagination"), $(this).data("page"), t, s)
        });
        $("#latest-posts-pagination a.next").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#latest-posts-pagination a.current").data("page");
            var u = o * n;
            i(u);
            reverb.resetPagination($("#latest-posts-pagination .pagination"), o + 1, t, s)
        });
        $("#latest-posts-pagination a.prev").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#latest-posts-pagination a.current").data("page") - 2;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#latest-posts-pagination .pagination"), o + 1, t, s)
        })
    }
    var e = $("#latest-posts-list");
    var t = $("#latest-posts-pagination").data("lastpage");
    var n = $("#latest-posts-pagination").data("size");
    var r = '<span class="loading">Carregando...</span>';
    s()
};
reverb.paginationFriends = function() {
    function i(t) {
        $.ajax({
            url: document.basePath + "/json/listaamigos/start/" + t,
            type: "GET",
            error: function() {
                reverb.alertMessage("error", "Ocorreu algum erro ao carregar mais posts, por favor recarregue a página ou entre em contato com o administrador :/")
            },
            beforeSend: function() {
                e.animate({
                    opacity: 0
                }, 100, function() {
                    e.html(r);
                    e.animate({
                        opacity: 1
                    }, 200)
                })
            },
            success: function(t) {
                var n = "";
                for (var r = 0; r < t.length; r++) {
                    var i = t[r].DS_NOME_CASO;
                    var s = t[r].NR_SEQ_CADASTRO_CASO;
                    var o = document.basePath + "/perfil/" + i.replace(/[^A-Za-z0-9]/, "") + "/" + s;
                    var u = t[r].NR_SEQ_CADASTRO_CASO + "." + t[r].DS_EXT_CACH;
                    var u = document.basePath + "/thumb/reverbme/1/103/90/" + u;
                    if (!reverb.UrlExists(u)) {
                        u = document.basePath + "/arquivos/default/images/sem_foto.jpg"
                    }
                    var a = "";
                    a += "<li>";
                    a += '<a href="' + o + '" class="profile-thumb">';
                    a += '<img src="' + u + '">';
                    a += "</a>";
                    a += '<a href="' + document.basePath + '/perfil/vanessa-virginia/1039" title="Visualizar perfil de " class="profile-link">' + i + "</a>";
                    a += "</li>";
                    n += a
                }
                e.animate({
                    opacity: 0
                }, 300, function() {
                    e.html(n);
                    e.animate({
                        opacity: 1
                    }, 300)
                })
            }
        })
    }

    function s() {
        $("#friends-pagination a.page").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("current")) {
                return false
            }
            e.css("min-height", e.height());
            $("#friends-pagination a").removeClass("current");
            $(this).addClass("current");
            var o = $(this).data("page") - 1;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#friends-pagination .pagination"), $(this).data("page"), t, s)
        });
        $("#friends-pagination a.next").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#friends-pagination a.current").data("page");
            var u = o * n;
            i(u);
            reverb.resetPagination($("#friends-pagination .pagination"), o + 1, t, s)
        });
        $("#friends-pagination a.prev").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#latest-posts-pagination a.current").data("page") - 2;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#latest-posts-pagination .pagination"), o + 1, t, s)
        })
    }
    var e = $("#friends-list");
    var t = $("#friends-pagination").data("lastpage");
    var n = $("#friends-pagination").data("size");
    var r = '<span class="loading">Carregando...</span>';
    s()
};
reverb.paginationScraps = function() {
    function i(t) {
        $.ajax({
            url: document.basePath + "/json/listarecados/start/" + t,
            type: "GET",
            error: function() {
                reverb.alertMessage("error", "Ocorreu algum erro ao carregar mais posts, por favor recarregue a página ou entre em contato com o administrador :/")
            },
            beforeSend: function() {
                e.animate({
                    opacity: 0
                }, 100, function() {
                    e.html(r);
                    e.animate({
                        opacity: 1
                    }, 200)
                })
            },
            success: function(t) {
                var n = "";
                for (var r = 0; r < t.length; r++) {
                    var i = t[r].DS_NOME_CASO;
                    var s = t[r].NR_SEQ_CADASTRO_CASO;
                    var o = t[r].DT_POST_SBRC;
                    var u = t[r].DS_POST_SBRC;
                    var a = t[r].NR_SEQ_SCRAP_SBRC;
                    var f = "";
                    f += '<div class="rvb-comment-box">';
                    f += '<p class="rvb-comment-author-name">';
                    f += i;
                    f += "</p>";
                    f += '<p class="rvb-comment-date">';
                    f += o;
                    f += "</p>";
                    f += '<div class="rvb-comment-message">';
                    f += u;
                    f += "</div>";
                    f += '<div class="rvb-comment-buttons">';
                    f += '<a href="' + document.basePath + "/perfil/" + i.toLowerCase().replace(/[^0-9a-zA-Z]/g, "") + "/" + s + '" class="button">Responder |</a>';
                    f += '<a href="' + document.basePath + "/deletar-recado/" + a + '" class="button">Excluir</a>';
                    f += "</div>";
                    f += "</div>";
                    n += f
                }
                e.animate({
                    opacity: 0
                }, 300, function() {
                    e.html(n);
                    e.animate({
                        opacity: 1
                    }, 300)
                })
            }
        })
    }

    function s() {
        $("#scraps-pagination a.page").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("current")) {
                return false
            }
            e.css("min-height", e.height());
            $("#scraps-pagination a").removeClass("current");
            $(this).addClass("current");
            var o = $(this).data("page") - 1;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#scraps-pagination .pagination"), $(this).data("page"), t, s)
        });
        $("#scraps-pagination a.next").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#scraps-pagination a.current").data("page");
            var u = o * n;
            i(u);
            reverb.resetPagination($("#scraps-pagination .pagination"), o + 1, t, s)
        });
        $("#scraps-pagination a.prev").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#latest-posts-pagination a.current").data("page") - 2;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#latest-posts-pagination .pagination"), o + 1, t, s)
        })
    }
    var e = $("#scraps-list");
    var t = $("#scraps-pagination").data("lastpage");
    var n = $("#scraps-pagination").data("size");
    var r = '<span class="loading">Carregando...</span>';
    s()
};
reverb.paginationWishlist = function() {
    function i(t) {
        $.ajax({
            url: document.basePath + "/json/listarwishlist/start/" + t,
            type: "GET",
            error: function() {
                reverb.alertMessage("error", "Ocorreu algum erro ao carregar mais posts, por favor recarregue a página ou entre em contato com o administrador :/")
            },
            beforeSend: function() {
                e.animate({
                    opacity: 0
                }, 100, function() {
                    e.html(r);
                    e.animate({
                        opacity: 1
                    }, 200)
                })
            },
            success: function(t) {
                var n = "";
                for (var r = 0; r < t.length; r++) {
                    var i = t[r].DS_PRODUTO_PRRC;
                    var s = i.replace(/[^0-9a-zA-Z]/, "").toLowerCase();
                    var o = t[r].NR_SEQ_PRODUTO_PRRC;
                    var u = t[r].NR_SEQ_WISHLIST_WLRC;
                    var a = "";
                    a += '<li class="rvb-photo-item">';
                    a += '<a href="' + document.basePath + "/produto/" + s + "/" + o + '" class="photo-thumb">';
                    a += '<img src="' + document.basePath + "/thumb/produtos/1/140/110/" + o + '.jpg" alt="The Killers - Hot Fuss - Fem"></a>';
                    a += '<a href="' + document.basePath + "/produto/" + s + "/" + o + '" class="photo-link">';
                    a += i;
                    a += "</a>";
                    a += '<a href="' + document.basePath + "/remover-wishlist/" + u + '" class="md-close ir" title="Excluir este produto da minha wishlist">Excluir</a>';
                    a += '<ul class="social-share-small">';
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir facebook" target="_blank">Facebook</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir twitter" target="_blank">Twitter</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>';
                    a += "</li>";
                    a += '<li class="social-item">';
                    a += '<a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>';
                    a += "</li>";
                    a += "</ul>";
                    a += "</li>";
                    n += a
                }
                e.animate({
                    opacity: 0
                }, 300, function() {
                    e.html(n);
                    e.animate({
                        opacity: 1
                    }, 300)
                })
            }
        })
    }

    function s() {
        $("#wishlist-pagination a.page").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("current")) {
                return false
            }
            e.css("min-height", e.height());
            $("#wishlist-pagination a").removeClass("current");
            $(this).addClass("current");
            var o = $(this).data("page") - 1;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#wishlist-pagination .pagination"), $(this).data("page"), t, s)
        });
        $("#wishlist-pagination a.next").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#wishlist-pagination a.current").data("page");
            var u = o * n;
            i(u);
            reverb.resetPagination($("#wishlist-pagination .pagination"), o + 1, t, s)
        });
        $("#wishlist-pagination a.prev").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#latest-posts-pagination a.current").data("page") - 2;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#latest-posts-pagination .pagination"), o + 1, t, s)
        })
    }
    var e = $("#wishlist-list");
    var t = $("#wishlist-pagination").data("lastpage");
    var n = $("#wishlist-pagination").data("size");
    var r = '<span class="loading">Carregando...</span>';
    s()
};
reverb.paginationCycle = function() {
    function i(t) {
        $.ajax({
            url: document.basePath + "/json/listarcycle/start/" + t,
            type: "GET",
            error: function() {
                reverb.alertMessage("error", "Ocorreu algum erro ao carregar mais posts, por favor recarregue a página ou entre em contato com o administrador :/")
            },
            beforeSend: function() {
                e.animate({
                    opacity: 0
                }, 100, function() {
                    e.html(r);
                    e.animate({
                        opacity: 1
                    }, 200)
                })
            },
            success: function(t) {
                console.log(t);
                var n = "";
                for (var r = 0; r < t.length; r++) {
                    var i = t[r].DS_OBJETO_RCRC;
                    var s = t[r].DS_OBJETO_RCRC.replace(/[^0-9a-zA-Z]/).toLowerCase();
                    var o = t[r].NR_SEQ_REVERBCYCLE_RCRC;
                    var u = t[r].NR_SEQ_REVERBCYCLE_RCRC + "." + t[r].DS_EXT_RCRC;
                    var a = t[r].NR_VIEWS_RCRC;
                    var f = t[r].total_coments;
                    var l = "";
                    l += '<li class="rvb-photo-item">';
                    l += '<a href="' + document.basePath + "/cycle-detalhe/" + s + "/" + o + '" class="photo-thumb">';
                    l += '<img src="' + document.basePath + "/thumb/reverbcycle/1/140/110/" + u + '" alt="' + i + '">';
                    l += "</a>";
                    l += '<a href="' + document.basePath + "/cycle-detalhe/" + s + "/" + o + '" class="photo-link">';
                    l += i;
                    l += "</a>";
                    l += '<span class="comments">';
                    l += " Comentários: " + f;
                    l += "</span>";
                    l += '<span class="views">';
                    l += " Views: " + a;
                    l += "</span>";
                    l += '<ul class="social-share-small">';
                    l += '<li class="social-item">';
                    l += '<a href="#" class="social-link ir facebook" target="_blank">Facebook</a>';
                    l += "</li>";
                    l += '<li class="social-item">';
                    l += '<a href="#" class="social-link ir twitter" target="_blank">Twitter</a>';
                    l += "</li>";
                    l += '<li class="social-item">';
                    l += '<a href="#" class="social-link ir tumblr" target="_blank">Tumblr</a>';
                    l += "</li>";
                    l += '<li class="social-item">';
                    l += '<a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>';
                    l += "</li>";
                    l += "</ul>";
                    l += "</li>";
                    n += l
                }
                e.animate({
                    opacity: 0
                }, 300, function() {
                    e.html(n);
                    e.animate({
                        opacity: 1
                    }, 300)
                })
            }
        })
    }

    function s() {
        $("#cycle-pagination a.page").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("current")) {
                return false
            }
            e.css("min-height", e.height());
            $("#cycle-pagination a").removeClass("current");
            $(this).addClass("current");
            var o = $(this).data("page") - 1;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#cycle-pagination .pagination"), $(this).data("page"), t, s)
        });
        $("#cycle-pagination a.next").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#cycle-pagination a.current").data("page");
            var u = o * n;
            i(u);
            reverb.resetPagination($("#cycle-pagination .pagination"), o + 1, t, s)
        });
        $("#cycle-pagination a.prev").on("click", function(r) {
            r.preventDefault();
            if ($(this).hasClass("disabled")) {
                return false
            }
            e.css("min-height", e.height());
            var o = $("#latest-posts-pagination a.current").data("page") - 2;
            var u = o * n;
            i(u);
            reverb.resetPagination($("#latest-posts-pagination .pagination"), o + 1, t, s)
        })
    }
    var e = $("#cycle-list");
    var t = $("#cycle-pagination").data("lastpage");
    var n = $("#cycle-pagination").data("size");
    var r = '<span class="loading">Carregando...</span>';
    s()
};
reverb.paginationSwipe = function() {
    $.each($(".rvb-content-item"), function(e, t) {
        var n = this;
        $(this).touchwipe({
            wipeLeft: function() {
                $(n).find(".rvb-list").animate({
                    "margin-left": "-30px",
                    opacity: 0
                }, 300, function() {
                    $(n).find(".next").trigger("click");
                    $(".rvb-list").attr("style", "")
                })
            },
            wipeRight: function() {
                $(n).find(".rvb-list").animate({
                    "margin-left": "30px",
                    opacity: 0
                }, 300, function() {
                    $(n).find(".prev").trigger("click");
                    $(".rvb-list").attr("style", "")
                })
            },
            min_move_x: 10,
            min_move_y: 10,
            preventDefaultEvents: false
        })
    })
};
reverb.buscarCepSuccess = function(e) {
    if (e.resultado == 0) {
        alert("Desculpe, mas este cep não existe.")
    } else {
        $("#endereco").val(e.tipo_logradouro + " " + e.logradouro);
        $("#bairro").val(e.bairro);
        new dgCidadesEstados({
            estado: $("#estado").get(0),
            cidade: $("#cidade").get(0),
            estadoVal: e.uf,
            cidadeVal: e.cidade
        });
        $("#estado").prev().text(e.uf);
        $("#cidade").prev().text(e.cidade)
    }
};
reverb.formCadastro = function() {
    var e = "Campo obrigatório";
    $("#reverbme-form-cadastro").validate({
        messages: {
            nomecompleto: e,
            sexo: "",
            dia: "",
            mes: "",
            ano: "",
            cpf: e,
            endereco: e,
            alterar_estado: e,
            alterar_cidade: e,
            numero: e,
            bairro: e,
            cep: e,
            usuarioemail: e,
            usuarioemail2: "Os e-mails devem ser iguais",
            usuariosenha: e,
            usuariosenha2: "As senhas devem ser iguais"
        },
        rules: {
            usuarioemail: "required",
            usuarioemail2: {
                equalTo: "#usuarioemail"
            },
            usuariosenha: "required",
            usuariosenha2: {
                equalTo: "#usuariosenha"
            }
        }
    });
    $('#reverbme-form-cadastro button[type="submit"]').on("click", function(e) {
        if (!$("#reverbme-form-cadastro").valid()) {
            e.preventDefault();
            reverb.alertMessage("error", "UM OU MAIS CAMPOS OBRIGATÓRIOS NÃO FORAM PREENCHIDOS!")
        }
    });
    $("#cadastro-dia").on("keyup", function(e) {
        reverb.onlyNumbers(this);
        reverb.tab(this, 2, "cadastro-mes")
    });
    $("#cadastro-mes").on("keyup", function() {
        reverb.onlyNumbers(this);
        reverb.tab(this, 2, "cadastro-ano")
    });
    $("#cadastro-ano").on("keyup", function() {
        reverb.onlyNumbers(this);
        reverb.tab(this, 4, "cadastro-cpf")
    });
    $("#cadastro-cpf").on("keyup", function() {
        reverb.tab(this, 11, "cadastro-cep")
    });
    $("#cadastro-cep").on("keyup", function() {
        reverb.onlyNumbers(this);
        reverb.tab(this, 8, "numero");
        if (this.value.length == 8) {
            $("#buscarCep").trigger("click")
        }
    });
    $("#numero").on("keyup", function(e) {
        reverb.onlyNumbers(this)
    });
    $("#numero").on("keydown", function(e) {
        if (e.keyCode == 9) {
            e.preventDefault();
            document.getElementById("complemento").focus()
        }
    });
    $("#complemento").on("keydown", function(e) {
        if (e.keyCode == 9) {
            e.preventDefault();
            document.getElementById("telefone1").focus()
        }
    });
    $("#buscarCep").on("click", function() {
        var e = $("#cadastro-cep").val();
        if (e.length == 8) {
            var t = "https://www.reverbcity.com/json/busca-cep/cep/" + e;
            $.getJSON(t, function(e) {
                reverb.buscarCepSuccess(e)
            })
        } else {
            $("#cadastro-cep").attr("placeholder", "Preencha o CEP corretamente...")
        }
    });
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
    new dgCidadesEstados({
        estado: $("#alterar_estado").get(0),
        cidade: $("#alterar_cidade").get(0)
    });
    $("#reverbme-form-cadastro .select-box").on("change", function() {
        var e = $(this).find("option:checked").text();
        $(this).parent().find(".select-fake").html(e)
    });
    $(".checkbox-dif input").on("change", function() {
        if ($(this).is(":checked")) {
            $(this).closest("div").addClass("checked")
        } else {
            $(this).closest("div").removeClass("checked")
        }
    })
};
reverb.detailsUser = function() {
    $('.flip-container').click(function() {
        var url = $(this).data('url');
        window.open(url);
    });
};

reverb.friendsPaginator = function() {

    var $container = $('#grid-friends-list');

    $('#more-friends').click(function () {

        var page = $(this).data('page');
        var size = $(this).data('size');

        var novaPagina = size + page;

        $('body').oLoader({
            image: '/arquivos/default/images/loader.gif',
            backgroundColor: '#5fbf98',
            url: '/json/listaamigos/start/' + novaPagina,
            updateContent: false, //this will not update content in #ajax-example-3-1

            complete: function (data) {
                console.log('nova pagina: ' + novaPagina);
                $('#more-friends').data('page', novaPagina);
                $('#more-friends').attr( "data-page", novaPagina);

                var html = "";

                $.each(data, function(index) {

                    var nome = data[index].DS_NOME_CASO;
                    var cod = data[index].NR_SEQ_CADASTRO_CASO;
                    var link = document.basePath + "/perfil/" + nome.replace(/[^A-Za-z0-9]/, "") + "/" + cod;
                    var image = data[index].NR_SEQ_CADASTRO_CASO + "." + data[index].DS_EXT_CACH;
                    var thumb = document.basePath + "/thumb/reverbme/1/103/90/" + image;
                    if (!reverb.UrlExists(thumb)) {
                        thumb = document.basePath + "/arquivos/default/images/sem_foto.jpg";
                    }

                    html += '<li class="grid-item" data-url="' + link + '">';
                        html += '<div class="flip-container"><div class="flipper"><div class="front"><div id="home-front2">';
                        html += '<img src="' + thumb + '" width="117" height="126" >';
                        html += '</div></div><div class="back"><div id="home-back2">';
                        html += '<img src="' + thumb + '" width="117" height="126" >';
                        html += '<div class="image_over"><div class="image_hover_text"><i class="fa fa-play fa-2x"></i> <br />';
                        html += nome + '</div></div></div></div></div></div>';
                    html += '</li>';
                });
                $container.append(html);
            },
            hideAfter: 1500
        });
    });
};

$(function() {
    reverb.alterarDados();
    reverb.details();
    reverb.paginationGallery();
    reverb.paginationVideos();
    reverb.paginationLatestPosts();
    reverb.paginationFriends();
    reverb.paginationScraps();
    reverb.paginationWishlist();
    reverb.paginationCycle();
    reverb.paginationSwipe();
    reverb.formCadastro();
    reverb.detailsUser();
    reverb.friendsPaginator();
})