$(document).ready(function() {

    $(".full-size").backstretch("/arquivos/default/images/HomeBlack_2.jpg");

    $(".full-size").click(function(event) {
        var link = '/todos-produtos';
        window.location.href = link;
        return false;
    });

});