<?php

if(@$_POST["dia"] && @$_POST["mes"] && @$_POST["ano"]) {

    $dia = $_POST["dia"];
    $mes = $_POST["mes"];
    $ano = $_POST["ano"];

    require_once  'codigo-correios.php';

    $objCodigoCorreios= new CodigoCorreios();

    $objCodigoCorreios->dia = $dia;
    $objCodigoCorreios->mes = $mes;
    $objCodigoCorreios->ano = $ano;

    $msgfim = $objCodigoCorreios->innitOrders(true);

} else {
    $msgfim = "'Erro: Inclua uma data valida'";
}
?>
<!DOCTYPE html>
<html>
<body>
<script>

        alert(<?php echo $msgfim; ?>);
        javascript:window.location='config.php';
</script>

</body>
</html>
