<?php
include 'lib.php';
$sql = "select NR_SEQ_FUNCIONARIO_FURC, DS_EMAIL_FURC, DS_FUNCIONARIO_FURC from funcionarios where NR_SEQ_LOJA_FURC = 1";
$stfuncs = mysql_query($sql);
$strcorpo = "";
if (mysql_num_rows($stfuncs) > 0) {
while($rowfuncs = mysql_fetch_row($stfuncs)) {
$func	= $rowfuncs[0];
$funcmail	= $rowfuncs[1];
$funcnome	= $rowfuncs[2];

$tembatidas = false;
$strcorpo = "";
$html = "";

$dia1 = 86400;
$ano = date("Y", time() - $dia1);
$mes = date("m", time() - $dia1);
$dia = date("d", time() - $dia1);

$enviar = true;

$str = "select DS_FUNCIONARIO_FURC, NR_HORAS_SEG_FURC, NR_HORAS_TER_FURC, NR_HORAS_QUA_FURC, 
NR_HORAS_QUI_FURC, NR_HORAS_SEX_FURC, NR_HORAS_SAB_FURC, NR_HORAS_DOM_FURC, VL_SALARIO_FURC,
HR_ENTRADA1_FURC, HR_SAIDA1_FURC, HR_ENTRADA2_FURC, HR_SAIDA2_FURC
from funcionarios WHERE NR_SEQ_FUNCIONARIO_FURC = $func";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
$row = mysql_fetch_row($st);
$nome	   	= $row[0];
$horas_seg  = $row[1];
$horas_ter  = $row[2];
$horas_qua  = $row[3];
$horas_qui  = $row[4];
$horas_sex  = $row[5];
$horas_sab  = $row[6];
$horas_dom  = $row[7];
$salario    = $row[8];
$hr_entr1   = $row[9]; 
$hr_said1   = $row[10];
$hr_entr2   = $row[11];
$hr_said2   = $row[12];
}else{
exit();
}

$html = "<table style=\"font: 11px Tahoma;\">\n";
$html .= "    <tr>\n";
$html .= "        <td align=center colspan=2>Hor&aacute;rio Normal:</td>\n";
$html .= "        <td align=center width=\"60\"><strong>$hr_entr1</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>$hr_said1</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>$hr_entr2</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>$hr_said2</strong></td>\n";
$html .= "    </tr>\n";
$html .= " </table>\n";

$strcorpo = $html;

$html = "<table style=\"font: 11px Tahoma;\">\n";
$html .= "    <tr>\n";
$html .= "        <td align=center width=\"30\"><strong>Data</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>Entrada</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>Sa&iacute;da</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>Entrada</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>Sa&iacute;da</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>Total</strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong>Carga Hor.</strong></td>\n";
$html .= "        <td align=center width=\"60\" bgcolor=#cecece><strong><font color=red>Dev</font>/<font color=blue>Extra</font></strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong><font color=red>Atrasos</font></strong></td>\n";
$html .= "        <td align=center width=\"60\"><strong><font color=blue>Extras</font></strong></td>\n";
$html .= "    </tr>\n";
$html .= " </table>\n";
$strcorpo .= $html;
$html = str_replace("align=center ","",$html);
$html = str_replace("\"","",$html);

$saldototal = 0;
$saldototalcarga = 0;
$mk_total_atr = 0;
$mk_total_ext = 0;
$mk_total = 0;
$textosjus = "";
$total_extras = 0;
$total_atrasos = 0;

$f = $dia;

$temexcecao = false;
$sql3 = "SELECT * from funcionarios_ponto_exc WHERE NR_SEQ_FUNCIONARIO_PERC = $func AND DT_EXCESSAO_PERC = '".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT)."'";
$st3 = mysql_query($sql3);
if (mysql_num_rows($st3) > 0) {
$temexcecao = true;
$row3 = mysql_fetch_array($st3);
$motivo = $row3["DS_MOTIVO_PERC"];
$horas  = $row3["DS_TEMPO_PERC"];
$tipoex  = $row3["NR_TIPO_OCORR_PERC"];
}

$str = "select DT_REGISTRO_FRRC, NR_SEQ_REGISTRO_FRRC from funcionarios_ponto WHERE NR_SEQ_FUNCIONARIO_FRRC = $func
AND (DAY(DT_REGISTRO_FRRC) = $f AND MONTH(DT_REGISTRO_FRRC) = $mes and YEAR(DT_REGISTRO_FRRC) = $ano) order by DT_REGISTRO_FRRC";

$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
$x = 0;
$soma = 0;
$str_batidas = "";
$saldo1 = 0;
$saldo2 = 0;
$calc_tole = 0;
$mk_extras = 0;
$mk_atrasos = 0;    
$temjus = "&nbsp";                                                                                                        
while($row = mysql_fetch_row($st)) {
$batida	   	= $row[0];
$nrseqbatida= $row[1];
if ($x==0) {
$sqlf = "select DS_JUSTIFICATIVA_JUPO from funcionarios_ponto_just where DS_JUSTIFICATIVA_JUPO is not null and
 NR_SEQ_FUNCIONARIO_JUPO = $func and DT_PONTO_JUPO = '".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT)."'";
$stf = mysql_query($sqlf);
if (mysql_num_rows($stf) > 0) {
$rowf = mysql_fetch_row($stf);
$temjus = $rowf[0];
}
$str_batidas = "<table style=\"font: 11px Tahoma;\"><tr><td align=center><strong>".date("d/m",strtotime($batida))."</strong></td>\n";  
}

$str_batidas .= "<td align=center width=\"60\">".date("G:i",strtotime($batida))." $excluibat</td>\n";

switch($x){
case 0:
$batida1 = $batida;
$hr = date("H",strtotime($batida));
$mi = date("i",strtotime($batida));
$se = date("s",strtotime($batida));
$mkbatida = mktime($hr,$mi,$se);

$hr = date("H",strtotime($hr_entr1));
$mi = date("i",strtotime($hr_entr1));
$se = date("s",strtotime($hr_entr1));
$mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                            
$calc_tole = $mkponto - $mkbatida;
if ($calc_tole >= 0){
$mk_extras += $calc_tole;
}else{
$mk_atrasos += $calc_tole;
}                                                   
$tembatidas = true;                                              
break;
case 1:
$batida2 = $batida;
$saldo1 = Diferenca($batida1,$batida2,"s");

$hr = date("H",strtotime($batida));
$mi = date("i",strtotime($batida));
$se = date("s",strtotime($batida));
$mkbatida = mktime($hr,$mi,$se);

$hr = date("H",strtotime($hr_said1));
$mi = date("i",strtotime($hr_said1));
$se = date("s",strtotime($hr_said1));
$mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                            
$calc_tole = $mkbatida - $mkponto;
if ($calc_tole >= 0){
$mk_extras += $calc_tole;
}else{
$mk_atrasos += $calc_tole;
}
$tembatidas = true;
break;
case 2:
$batida3 = $batida;
$hr = date("H",strtotime($batida));
$mi = date("i",strtotime($batida));
$se = date("s",strtotime($batida));
$mkbatida = mktime($hr,$mi,$se);

$hr = date("H",strtotime($hr_entr2));
$mi = date("i",strtotime($hr_entr2));
$se = date("s",strtotime($hr_entr2));
$mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                            
$calc_tole = $mkponto - $mkbatida;
if ($calc_tole >= 0){
$mk_extras += $calc_tole;
}else{
$mk_atrasos += $calc_tole;
}
$tembatidas = true;
break;
case 3:
$batida4 = $batida;
$saldo2 = Diferenca($batida3,$batida4,"s");

$hr = date("H",strtotime($batida));
$mi = date("i",strtotime($batida));
$se = date("s",strtotime($batida));
$mkbatida = mktime($hr,$mi,$se);

$hr = date("H",strtotime($hr_said2));
$mi = date("i",strtotime($hr_said2));
$se = date("s",strtotime($hr_said2));
$mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                            
$calc_tole = $mkbatida - $mkponto;
if ($calc_tole >= 0){
$mk_extras += $calc_tole;
}else{
$mk_atrasos += $calc_tole;
}
$tembatidas = true;
break;
}
$x++;
}

for ($g=$x;$g<4;$g++){
$str_batidas .= "<td align=center width=\"60\"> - </td>\n";
}

$saldototal += ($saldo1+$saldo2);

$saldoextra = 0;
$exibecarga = "";
switch(date('w',strtotime($batida))){
case 0:
$exibecarga = $horas_dom;
break;
case 1:
$exibecarga = $horas_seg;
break;
case 2:
$exibecarga = $horas_ter;
break;
case 3:
$exibecarga = $horas_qua;
break;
case 4:
$exibecarga = $horas_qui;
break;
case 5:
$exibecarga = $horas_sex;
break;
case 6:
$exibecarga = $horas_sab;
break;
}

if ($x == 2){
$mk_extras = 0;
$mk_atrasos = 0;

$horasdevidas = time_to_sec($exibecarga);
$horasfeitas = $saldo1+$saldo2;

if ($horasfeitas > $horasdevidas){
$mk_extras += ($horasfeitas-$horasdevidas);
}else{
$mk_atrasos += ($horasdevidas-$horasfeitas)*-1;
}   
}

$exibe_mk = 0;
$mk_atrasos_inv = $mk_atrasos*-1;
if ($mk_extras > 600 && $mk_atrasos_inv > 600 && $exibecarga){
$mk_total = $mk_total + ($mk_extras-$mk_atrasos_inv);
$exibe_mk = $exibe_mk + ($mk_extras-$mk_atrasos_inv);
if ($mk_extras-$mk_atrasos_inv >= 0){
$mk_total_ext += $mk_extras-$mk_atrasos_inv;
}else{
$mk_total_atr += $mk_atrasos_inv - $mk_extras;
}
}else if ($mk_extras > 600 && $mk_atrasos_inv <= 600 && $exibecarga){
$mk_total = $mk_total + $mk_extras;
$exibe_mk = $exibe_mk + $mk_extras;
$mk_total_ext += $mk_extras;
}else if ($mk_extras <= 600 && $mk_atrasos_inv > 600 && $exibecarga){
$mk_total = $mk_total - $mk_atrasos_inv;
$exibe_mk = $exibe_mk - $mk_atrasos_inv;
$mk_total_atr += $mk_atrasos_inv;
}


$extra_aut = false;
$temextra = "";


$horasdevidas = time_to_sec($exibecarga);
if ($temexcecao && $tipoex == 0){
$horastot = time_to_sec($horas);                                            
$horasdevidas = $horasdevidas - $horastot;
}
$saldototalcarga += $horasdevidas;
$horasfeitas = $saldo1+$saldo2;
if ($horasfeitas > $horasdevidas){
$saldoextra = "<font color=blue>".sec_to_time($horasfeitas - $horasdevidas)."</font>";
$sql3 = "SELECT * from funcionarios_ponto_aut WHERE NR_SEQ_FUNCIONARIO_EARC = $func AND DT_AUTORIZADA_EARC = '".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT)."'";
$st3 = mysql_query($sql3);
if (mysql_num_rows($st3) > 0) {
$extra_aut = true;
}else{
$saldototal -= ($horasfeitas - $horasdevidas);
}
}else{
$saldoextra = "<font color=red>".sec_to_time($horasdevidas - $horasfeitas)."</font>";
}

if (!$exibecarga){
$mk_total += ($saldo1+$saldo2);
$mk_extras = "<font color=blue>".sec_to_time($saldo1+$saldo2)."</font>";  
$exibe_mk = "<font color=blue>".sec_to_time($saldo1+$saldo2)."</font>";       
$mk_total_ext += ($saldo1+$saldo2);
if ($extra_aut) $total_extras += ($saldo1+$saldo2);
}

if ($exibecarga){
if ($exibe_mk < 0){
$total_atrasos += $exibe_mk*-1;
$exibe_mk = "<font color=red>".sec_to_time($exibe_mk*-1)."</font>";
}else{
if ($exibe_mk > 0) {
if ($extra_aut) $total_extras += $exibe_mk;
$exibe_mk = "<font color=blue>".sec_to_time($exibe_mk)."</font>";
}else{
$exibe_mk = "&nbsp;";
}
}
$mk_atrasos = sec_to_time($mk_atrasos*-1);
$mk_extras  = sec_to_time($mk_extras);
}

if ($temexcecao && $tipoex == 0){
$total_atrasos -= time_to_sec($horas);
}
                                                                            
$str_batidas .= "<td align=center width=\"60\">".sec_to_time($saldo1+$saldo2)."</td><td align=center width=\"60\"><strong>$exibecarga</strong></td><td align=center width=\"60\" bgcolor=#cecece>$saldoextra</td>\n";
$str_batidas .= "<td width=\"60\" align=center><font color=red>".$mk_atrasos."</font></td><td width=\"60\" align=center><font color=blue>".$mk_extras."</font></td>\n";
$str_batidas .= "</tr></table>\n";
}else{
$montabatida = $ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT);
switch(date('w',strtotime($montabatida))){
case 0:
$exibecarga = $horas_dom;
break;
case 1:
$exibecarga = $horas_seg;
break;
case 2:
$exibecarga = $horas_ter;
break;
case 3:
$exibecarga = $horas_qua;
break;
case 4:
$exibecarga = $horas_qui;
break;
case 5:
$exibecarga = $horas_sex;
break;
case 6:
$exibecarga = $horas_sab;
break;
}
if ($exibecarga){
$tempdeb = time_to_sec($exibecarga);
$mk_total -= time_to_sec($exibecarga);
$total_atrasos += time_to_sec($exibecarga);
$exibe_mk = "<font color=red>".$exibecarga.":00</font>";

$mk_total_atr += time_to_sec($exibecarga);

$horasdevidas = time_to_sec($exibecarga);
if ($temexcecao && $tipoex == 0){
$horastot = time_to_sec($horas);   
$total_atrasos -= $horastot;                                                           
$horasdevidas = $horasdevidas - $horastot;
}else if ($tipoex == 1){
$total_atrasos -= time_to_sec($exibecarga);
}

if ($tipoex == 0) {
$saldototalcarga += $horasdevidas;
$saldoextra = "<font color=red>$exibecarga:00</font>";
}else if ($tipoex == 1) {
$saldoextra = "-";
$exibecarga = "-";
$mostramais = "-";
}
$str_batidas = "<table style=\"font: 11px Tahoma;\"><tr><td align=center><strong>".str_pad($f,2,"0",STR_PAD_LEFT)."/".str_pad($mes,2,"0",STR_PAD_LEFT)."</strong></td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"><strong>$exibecarga</strong></td><td align=center width=\"60\" bgcolor=#cecece>$saldoextra</td><td align=center width=\"60\">$exibe_mk</td><td align=center width=\"60\"> - </td></tr></table>\n";
}else{
$str_batidas = "<table style=\"font: 11px Tahoma;\"><tr><td align=center><strong>".str_pad($f,2,"0",STR_PAD_LEFT)."/".str_pad($mes,2,"0",STR_PAD_LEFT)."</strong></td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td><td align=center width=\"60\"> - </td></tr></table>\n";   
}
}


$strcorpo .= $str_batidas; 

if ($tembatidas) {
$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 25px 25px; width: 550px;">
<strong>Olá, '.$funcnome.'</strong>
<br /><br />
Segue abaixo para o seu controle as suas batidas do ponto do dia útil anterior.
<br />
</div>    
<div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">';

$texto .= $strcorpo;

$texto .= "</div>";
$corpo = IncluiPapelCarta("sistema",$texto,"SUAS BATIDAS DO PONTO DE ONTEM"); 
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$funcmail,"","","Controle do Ponto - Reverbcity", $corpo);
}
}
}
mysql_close($con);
?>