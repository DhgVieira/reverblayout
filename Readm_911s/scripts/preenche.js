$(function () {
	$("#estado").change(function () {
		var uf = $(this).val();
		$.ajax({
			type: "GET",
			url: "config_freteuf.php",
			data: "uf="+uf,
			success: function(pessoa){
				informacoesPessoa = pessoa.split("|");
				$("#valorfreteuf").val(informacoesPessoa[0]);
                if (informacoesPessoa[1] == 'A')
                    $("#fretehabufs").attr("checked", "checked");
                else
                    $("#fretehabufn").attr("checked", "checked");
			}
		});
	});
});