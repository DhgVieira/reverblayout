<?php
//<!-- //***** -->
//<!-- SALVA EM ARQUIVO EMAILS ANIVERSARIANTES DO MES -->
include 'auth.php';
include 'lib.php';

$grupo2 = request("grupo2");
$arq = 'temp/aniversariantes.txt';
$handle = fopen($arq, "w+");

if ($handle) {
    $num = 0;
    $sql = "select Email from rel_aniversariantes_mes";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        while ($row = mysql_fetch_row($st)) {
            $email = $row[0];
            $num++;
            fwrite($handle, $email . ";\n");
        } // FIM WHILE
    }  // FIM IF
    mysql_close($con);
    fclose($handle);
    ?>    <a href="temp/aniversariantes.txt"> Download </a> <?
} // FIM IF
else {
    echo "Falha ao abrir o arquivo!";
}
exit();
//<!-- //***** -->
?>