function SomenteNumero(e) {
    var t = window.event ? event.keyCode : e.which;
    if (t > 47 && t < 58) return true;
    else {
        if (t != 8) return false;
        else return true
    }
}
var reverb = {
    isMobile: function() {
        var e = false;
        (function(t) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(t) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(t.substr(0, 4))) e = true
        })(navigator.userAgent || navigator.vendor || window.opera);
        return e
    },
    topo: function() {
        var e = "#top-bar .reverb-button";
        $.each($(e), function() {
            var e = $(this);
            if (e.hasClass("opened")) {
                window.setTimeout(function() {
                    e.removeClass("opened")
                }, 5e3)
            }
        });
        $(e).on({
            click: function(t) {
                t.preventDefault();
                $(this).toggleClass("opened");
                $(e).not($(this)).removeClass("opened")
            }
        });
        $("#busca_site").autocomplete({
            source: function(e, t) {
                $.ajax({
                    url: document.basePath + "/index/autocomplete/",
                    data: {
                        search: e.term
                    },
                    dataType: "json",
                    success: function(e) {
                        t(e)
                    }
                })
            },
            appendTo: "#topbar-search-desktop",
            delay: 500,
            minLength: 3,
            select: function(e, t) {
                $("#busca_site").val(t.item.label);
                $("#topbar-search-desktop").submit()
            }
        });
        $("#topbar-search-desktop button").on("click", function(e) {
            if ($("#busca_site").val() == "") {
                e.preventDefault();
                reverb.alertMessage("error", "Digite algo para poder buscar")
            }
        });
        $("#main-content, #topbar-search").on("click", function(t) {
            $(e).removeClass("opened")
        });
        $("body").on("click", function(t) {
            if (this === t.target) {
                $(e).removeClass("opened")
            }
        });
        $(document.documentElement).keyup(function(t) {
            if (t.keyCode == 27) {
                $(e).removeClass("opened")
            }
        });
        $("#topbar-search").on("submit", function(e) {
            if ($(this).find("input").val().length > 0) {
                $(this).submit()
            } else {
                e.preventDefault();
                reverb.alertMessage("error", "Por favor, digite algo para poder pesquisar")
            }
        });
        $("#desktop-header #site-menu .dropdown > .menu-item-link, #desktop-header #site-menu .dropdown > h1").on({
            mouseover: function() {
                $(".dropdown-menu").removeClass("active");
                $(this).siblings(".dropdown-menu").addClass("active")
            },
            focus: function() {
                $(".dropdown-menu").removeClass("active");
                $(this).siblings(".dropdown-menu").addClass("active")
            }
        });
        $("#desktop-header #site-menu .menu-item:not(.dropdown) .menu-item-link, #desktop-header #site-menu .menu-item:not(.dropdown) h1").on({
            mouseover: function() {
                $(".dropdown-menu").removeClass("active")
            },
            focus: function() {
                $(".dropdown-menu").removeClass("active")
            }
        })
    },
    mobileTopo: function() {
        $("#mobile-header #site-menu .btn-open").on("click", function(e) {
            e.preventDefault();
            $(this).toggleClass("active");
            $(this).next(".menu").toggleClass("active")
        });
        $("#mobile-header #site-menu .dropdown > .menu-item-link").on("click", function(e) {
            e.preventDefault();
            if ($(this).hasClass("active")) {
                $("#mobile-header #site-menu .dropdown > .menu-item-link").removeClass("active");
                $(".mobile-dropdown-menu").removeClass("active");
                $(this).removeClass("active");
                $(this).next(".mobile-dropdown-menu").removeClass("active")
            } else {
                $("#mobile-header #site-menu .dropdown > .menu-item-link").removeClass("active");
                $(".mobile-dropdown-menu").removeClass("active");
                $(this).addClass("active");
                $(this).next(".mobile-dropdown-menu").addClass("active")
            }
        });
        $("#mobile-header .mobile-action-btn").on("click", function(e) {
            e.preventDefault();
            var t = $(this).attr("href");
            $("#mobile-header #site-menu .btn-open, #mobile-header #site-menu .menu").removeClass("active");
            if ($(this).hasClass("active")) {
                var n = true
            } else {
                var n = false
            }
            $("#mobile-header .mobile-action-btn").removeClass("active");
            if (n) {
                $(this).removeClass("active")
            } else {
                $(this).addClass("active")
            }
            $(".mobile-action-box").addClass("hidden");
            if (n) {
                $(t).addClass("hidden")
            } else {
                $(t).removeClass("hidden")
            }
            $(t).find("input").first().focus()
        });
        if (document.documentElement.clientWidth < 767) {
            $("#mobile-header #topbar-search-mobile .submit").on("click", function(e) {
                console.log(e);
                if ($("#mobile-header #topbar-search-mobile .input-box").val().length == 0) {
                    e.preventDefault();
                    $("#mobile-header #topbar-search-mobile .input-box").toggle().focus()
                }
            })
        }
        if ($("#buscar_site_mobile")) {
            $("#buscar_site_mobile").autocomplete({
                source: function(e, t) {
                    $.ajax({
                        url: document.basePath + "/index/autocomplete/",
                        data: {
                            search: e.term
                        },
                        dataType: "json",
                        success: function(e) {
                            t(e)
                        }
                    })
                },
                appendTo: "#topbar-search-mobile",
                delay: 500,
                minLength: 3
            })
        }
        if ($("#topbar-search-mobile")) {
            $("#topbar-search-mobile").on("submit", function(e) {
                if ($(this).find("input").val().length > 0) {
                    $(this).submit()
                } else {
                    e.preventDefault();
                    reverb.alertMessage("error", "Por favor, digite algo para poder pesquisar")
                }
            })
        }
    },
    center: function(e) {
        var t = ($(window).height() - e.outerHeight()) / 2 + $(window).scrollTop();
        var n = ($(window).width() - e.outerWidth()) / 2 + $(window).scrollLeft();
        t = t < 0 ? 15 : t;
        n = n < 0 ? 15 : n;
        e.css("position", "absolute");
        e.css("top", t + "px");
        e.css("left", n + "px")
    },
    messages: function() {
        if ($(".banners-advertisement").length > 0) {
            $("#msg-box").insertAfter(".banners-advertisement")
        }
        $("#msg-box").fadeIn(200);
        $(".rvb-icon").on("click", function() {
            $("#msg-box").fadeOut(200);
            setTimeout(function(){
                $("#msg-box").remove();
            }, 200);
        });
    },
    alertMessage: function(e, t) {
        var n = $("body").scrollTop();
        if (n > 150 || $(".md-show").length) {
            var r = '<div id="msg-box" class="msg-' + e + ' fixed"><p><i class="rvb-icon"></i>' + t + "</p></div>"
        } else {
            var r = '<div id="msg-box" class="msg-' + e + '"><p><i class="rvb-icon"></i>' + t + "</p></div>"
        }
        if (!$("#msg-box").length) {
            $("#main-content").prepend(r);
            reverb.messages()
        }
    },
    fullLoader: function() {
        $("body").append('<div id="full-loader"></div>');
        var e = {
            lines: 17,
            length: 13,
            width: 6,
            radius: 19,
            corners: 1,
            rotate: 44,
            direction: 1,
            color: "#000",
            speed: 1.3,
            trail: 100,
            shadow: false,
            hwaccel: false,
            className: "spinner",
            zIndex: 2e9
        };
        var t = document.getElementById("full-loader");
        var n = (new Spinner(e)).spin(t);
        $(t).fadeIn()
    },
    lightbox: function() {
        $(".md-trigger").on("click", function(e) {
            e.preventDefault()
        });
        $(".md-trigger").modalEffects({
            afterOpen: function(e, t) {
                var n = t.selector;
                $(document.documentElement).keyup(function(e) {
                    if (e.keyCode == 27) {
                        $(n).find(".md-close").trigger("click")
                    }
                });
                if (n == "#international-purchases-lightbox") {
                    reverb.internationalPurchases()
                }
                if (n == "#indique-lightbox") {
                    reverb.recommendationPage()
                }
                reverb.center(t)
            },
            afterClose: function(e, t) {}
        })
    },
    internationalPurchases: function() {
        var e = "Required field, please fill.";
        $("#form-international-purchases").validate({
            messages: {
                "name-ip": e,
                "email-ip": e,
                "country-ip": e,
                "city-ip": e,
                "message-ip": e
            }
        })
    },
    recommendationPage: function() {
        var e = "Campos obrigatórios.";
        $("#indique-form").validate({
            messages: {
                indiquenome: e,
                indiquenomeamigo: e,
                indiqueemail: e,
                indiqueemailamigo: e
            }
        })
    },
    tracking: function() {
        var e = "Campo obrigatório";
        $("#form-rastreamento").validate({
            messages: {
                p_codigo: e
            },
            submitHandler: function(e) {
                var t = $("#codigo-rastreamento").val();
                $(e).on("submit", function(e) {
                    e.preventDefault();
                    window.open("http://websro.correios.com.br/sro_bin/txect01$.QueryList?P_LINGUA=001&P_TIPO=001&P_COD_UNI=" + t)
                })
            }
        })
    },
    tooltip: function() {
        $(".has-tooltip").on({
            mouseenter: function() {
                $(this).addClass("active");
                clearTimeout(intervaloTooltip);
                console.log("entrou")
            },
            mouseleave: function() {
                console.log("saiu");
                var e = $(this);
                intervaloTooltip = setTimeout(function() {
                    e.removeClass("active")
                }, 500)
            }
        })
    },
    sidebars: function() {
        $("#staylogged").on("change", function() {
            $(this).parent().toggleClass("active")
        });
        if ($("#rvb-form-login").length > 0) {
            var e = "Campo obrigatório";
            $("#rvb-form-login").validate({
                messages: {
                    email: e,
                    senha: e
                }
            })
        }
        if ($("#form-login-reverbme").length > 0) {
            var e = "Campo obrigatório";
            $("#form-login-reverbme").validate({
                messages: {
                    email: e,
                    senha: e
                }
            })
        }
    },
    tab: function(e, t, n) {
        if (e.value.length >= t) {
            document.getElementById(n).focus()
        }
    },
    onlyNumbers: function(e) {
        e.value = e.value.replace(/[^0-9\.]/g, "")
    },
    filterSidebar: function() {
        function e() {
            if (!$(".open-sub-menu").length) {} else {
                $(".open-sub-menu").on("click", function(e) {
                    e.preventDefault();
                    $("ul." + $(this).data("menu")).slideToggle(300);
                    $(this).toggleClass("closed")
                })
            }
        }
        e();
        $("#form-busca-filtros .search-input").autocomplete({
            source: function(e, t) {
                $.ajax({
                    url: document.basePath + "/json/autocompletesidebar/",
                    data: {
                        filter: e.term
                    },
                    dataType: "json",
                    success: function(e) {
                        t(e)
                    }
                })
            },
            appendTo: "#form-busca-filtros",
            delay: 500,
            minLength: 3
        })
    },
    returnNumbers: function(e) {
        return e.replace(/[^0-9]/g, "")
    },
    floatNumbersPagarme: function(total) {

        var amount = total;
        var amoutString = reverb.formatNumber(amount);

        return accounting.unformat(amoutString, ".");
    },
    formatNumber: function(e) {
        e = Number(e);
        e = e.toFixed(2) + "";
        x = e.split(".");
        x1 = x[0];
        x2 = x.length > 1 ? "," + x[1] : "";
        var t = /(\d+)(\d{3})/;
        while (t.test(x1)) {
            x1 = x1.replace(t, "$1" + "," + "$2")
        }
        return x1 + x2
    },
    utf8_decode: function(e) {
        var t = [],
            n = 0,
            r = 0,
            i = 0,
            s = 0,
            o = 0,
            u = 0;
        e += "";
        while (n < e.length) {
            i = e.charCodeAt(n);
            if (i <= 191) {
                t[r++] = String.fromCharCode(i);
                n++
            } else if (i <= 223) {
                s = e.charCodeAt(n + 1);
                t[r++] = String.fromCharCode((i & 31) << 6 | s & 63);
                n += 2
            } else if (i <= 239) {
                s = e.charCodeAt(n + 1);
                o = e.charCodeAt(n + 2);
                t[r++] = String.fromCharCode((i & 15) << 12 | (s & 63) << 6 | o & 63);
                n += 3
            } else {
                s = e.charCodeAt(n + 1);
                o = e.charCodeAt(n + 2);
                u = e.charCodeAt(n + 3);
                i = (i & 7) << 18 | (s & 63) << 12 | (o & 63) << 6 | u & 63;
                i -= 65536;
                t[r++] = String.fromCharCode(55296 | i >> 10 & 1023);
                t[r++] = String.fromCharCode(56320 | i & 1023);
                n += 4
            }
        }
        return t.join("")
    },
    getYoutubeId: function(e) {
        var t = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var n = e.match(t);
        if (n && n[7].length == 11) {
            return n[7]
        } else {
            alert("Url incorrecta")
        }
    },
    getFullDate: function(e) {
        var t = new Date(e);
        var n = t.getDate();
        var r = t.getMonth();
        r++;
        var i = t.getFullYear();
        return n + "/" + r + "/" + i
    },
    getHour: function(e) {
        var t = new Date(e);
        var n = t.getHours();
        var r = t.getMinutes();
        return n + ":" + r
    },
    UrlExists: function(e) {
        var t = new XMLHttpRequest;
        t.open("HEAD", e, false);
        t.send();
        if (t.status != 404 && t.status != 500) {
            return true
        } else {
            return false
        }
    },
    tinyInit: function() {
        if (!reverb.isMobile()) {
            tinymce.init({
                theme: "modern",
                skin: "light",
                selector: "#comentario",
                plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
                menubar: false,
                toolbar: "image media link | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | emoticons",
                theme_advanced_toolbar_location: "bottom",
                statusbar: false
            });
            tinymce.init({
                theme: "modern",
                skin: "light",
                selector: ".reply-txt",
                plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
                menubar: false,
                toolbar: "image media link | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | emoticons",
                theme_advanced_toolbar_location: "bottom",
                statusbar: false
            })
        } else {
            tinymce.init({
                theme: "modern",
                skin: "light",
                selector: "#comentario",
                plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code emoticons", "insertdatetime media table contextmenu paste"],
                menubar: false,
                toolbar: "image media link | bold italic underline | emoticons",
                theme_advanced_toolbar_location: "bottom",
                statusbar: false
            })
        }
    },
    init: function() {
        reverb.mobileTopo();
        reverb.topo();
        reverb.lightbox();
        reverb.sidebars();
        reverb.filterSidebar();
        reverb.messages();
        reverb.tracking();
        reverb.tooltip();
        if (typeof tinymce != "undefined") {
            reverb.tinyInit()
        }
    }
};
$(function() {
    reverb.init();
    //$.reject({
    //    reject: {
    //        safari: false,
    //        chrome: false,
    //        firefox: false,
    //        msie: true,
    //        opera: false,
    //        konqueror: false,
    //        unknown: false
    //    },
    //    display: ["firefox", "chrome", "opera", "msie"]
    //});
    return false
})