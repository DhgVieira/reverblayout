reverb.classic = function() {
    new dgCidadesEstados({
        estado: $("#avise-estado").get(0),
        cidade: $("#avise-cidade").get(0)
    });
    $("#tamanho , #estado, #cidade").change(function(e) {
        e.preventDefault();
        var t = $(this);
        t.find("span").text(t.find("option:selected").text())
    })
};
$(function() {
    reverb.classic()

    $(".reply-comment-btn").on("click", function() {
        console.log('click')
        $(this).toggleClass("active");
        $(this).closest(".data-content").find(".user-reply-comment").toggleClass("disabled").find("textarea").focus()
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
})