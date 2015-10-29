<?php
include 'auth.php';
include 'lib.php';

$func = request("id");
$mes = request("mes");
$ano = request("ano");

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
?>
<?php include 'topo.php'; ?>
<script type='text/javascript' src="calendar1.js"></script>
<script type='text/javascript' src="scripts/autocomplete/jquery.tools.min.js"></script>
<script type="text/javascript">
    $().ready(function() {
        $("#Gerar").click(function() {
            $("#email").val("");
            $("#frmPonto").attr("target","_blank");
            $("#frmPonto").submit();
        });
        $("#Emailbt").click(function() {
            var zemail = $("#email").val();
            if (zemail.length > 2){
                $("#frmPonto").attr("target","_self");
                $("#frmPonto").submit();
            }
        });
    });
</script>
<script language="javascript">
function apagabat(idbat,batida) {
	var confirma = confirm("Tem certeza que voce quer excluir essa batida? Essa operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='ponto_delbat.php?func=<?php echo $func;?>&mes=<?php echo $mes;?>&ano=<?php echo $ano;?>&idb='+idbat+'&bat='+batida;
	} else {
		return false
	} 
}
</script>
<link rel="stylesheet" href="css/tipsy.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery.tipsy.js"></script>
<link rel="stylesheet" type="text/css" href="css/dateskin.css"/>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Ponto</li>
                    </ul>
                </td>
            </tr>
        </table>
        
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);" style="width: 220px;"><?php echo $nome ?></li>
                      <?php if ($SS_nivel > 100 || $SS_logadm == 29) { ?>
                      <li id="abaAdic" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Adicionar Registro</li>
                      <?php } ?>
                      <li id="abasair" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='ponto.php'">Funcionários</li>
                      <li>Gerar em PDF: <input type="button" id="Gerar" value="Gerar" /></li>
                      <li><input type="text" id="email" name="email" size="15" /><input type="button" id="Emailbt" name="Emailbt" value="Email" /></li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                        
						<ul class="compras" style="padding: 0 0 0 10px;">
                        <li>
                        <?php
                        $html = "<table width=\"925\">\n";
                        $html .= "    <tr>\n";
                        $html .= "        <td align=\"left\"><strong>Funcion&aacute;rio: ".$nome." - $mes/2011</strong></td>\n";
                        $html .= "    </tr>\n";
                        $html .= "</table>\n";
                        $html .= "</li>\n";
                        $html .= "<li>\n";
                        
                        echo $html;
                        
                        $html = "<table width=\"925\">\n";
                        $html .= "    <tr>\n";
                        $html .= "        <td align=center colspan=2>Hor&aacute;rio Normal:</td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>$hr_entr1</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>$hr_said1</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>$hr_entr2</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>$hr_said2</strong></td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"25\">&nbsp;</td>\n";
                        $html .= "    </tr>\n";
                        $html .= " </table>\n";
                        echo $html;
                        
                        $html = "<table width=\"925\">\n";
                        $html .= "    <tr>\n";
                        $html .= "        <td align=center width=\"30\">&nbsp;</td>\n";
                        $html .= "        <td align=center><strong>Data</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>Entrada</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>Sa&iacute;da</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>Entrada</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>Sa&iacute;da</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>Total</strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong>Carga Hor.</strong></td>\n";
                        $html .= "        <td align=center width=\"70\" bgcolor=#cecece><strong><font color=red>Dev</font>/<font color=blue>Extra</font></strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong><font color=red>Atrasos</font></strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong><font color=blue>Extras</font></strong></td>\n";
                        $html .= "        <td align=center width=\"70\"><strong><font>C&aacute;lculo com Toler&acirc;ncia</font></strong></td>\n";
                        $html .= "        <td align=center width=\"70\">&nbsp;</td>\n";
                        $html .= "        <td align=center width=\"25\">&nbsp;</td>\n";
                        $html .= "    </tr>\n";
                        $html .= " </table>\n";
                        echo $html;
                        $html = str_replace("align=center ","",$html);
                        $html = str_replace("\"","",$html);
                         ?>
                         </li>
                            <?php
                            $totdias=cal_days_in_month( CAL_GREGORIAN, $mes, $ano);
                            
                            $saldototal = 0;
                            $saldototalcarga = 0;
                            $mk_total_atr = 0;
                            $mk_total_ext = 0;
                            $mk_total = 0;
                            $textosjus = "";
                            $total_extras = 0;
                            $total_atrasos = 0;
                            for ($f=1;$f<=$totdias;$f++){
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
                                                $textosjus .= "$('#func_$f').tipsy();\n";
                                                $temjus = "<a id=\"func_$f\" title=\"$temjus\"><img src=\"img/liberada.png\" width=\"14\" height=\"14\" border=\"0\" /></a>";
                                            }else{
                                                $temjus = "&nbsp";
                                            }
                                            $str_batidas = "<li><table width=\"925\"><tr><td align=center width=\"30\">$temjus</td><td align=center><strong>".date("d/m",strtotime($batida))."</strong></td>\n";  
                                        }
                                        if ($SS_nivel > 100 || $SS_logadm == 29){
                                            $excluibat = "<a href=\"#\" onclick=\"apagabat($nrseqbatida,'$batida');\" title=\"Excluir Batida\"><img src=\"img/cancel_baixa.gif\" align=\"absmiddle\" alt=\"Excluir Batida\"></a>";
                                        }else{
                                            $excluibat = "";
                                        }
                                        $str_batidas .= "<td align=center width=\"70\">".date("G:i",strtotime($batida))." $excluibat</td>\n";
                                        
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
                                                break;
                                        }
                                        $x++;
                                	}
                                    
                                    for ($g=$x;$g<4;$g++){
                                        $str_batidas .= "<td align=center width=\"70\"> - </td>\n";
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
                                    
                                    //if ($exibecarga){
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
                                                $temextra = "<a href=\"ponto_autext.php?f=$func&d=$f&mes=$mes&ano=$ano&a=E\" title=\"Cancelar Extra do Dia\"><img src=img/liberada.png align=absmiddle border=0 hspace=2></a>";
                                                $extra_aut = true;
                                            }else{
                                                $temextra = "<a href=\"ponto_autext.php?f=$func&d=$f&mes=$mes&ano=$ano&a=I\" title=\"Autorizar Extra do Dia\"><img src=img/negada.png align=absmiddle border=0 hspace=2></a>";
                                                $saldototal -= ($horasfeitas - $horasdevidas);
                                            }
                                        }else{
                                            $saldoextra = "<font color=red>".sec_to_time($horasdevidas - $horasfeitas)."</font>";
                                        }
                                    //}else{
                                    //    $horasfeitas = $saldo1+$saldo2;
                                    //    $saldoextra = "<font color=blue>".sec_to_time($horasfeitas)."</font>";
                                    //}
                                    
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
                                                                                                                                
                                    $str_batidas .= "<td align=center width=\"70\">".sec_to_time($saldo1+$saldo2)."</td><td align=center width=\"70\"><strong>$exibecarga</strong></td><td align=center width=\"70\" bgcolor=#cecece>$saldoextra</td>\n";
                                    $str_batidas .= "<td width=\"70\" align=center><font color=red>".$mk_atrasos."</font></td><td width=\"70\" align=center><font color=blue>".$mk_extras."</font></td>\n";
                                    $str_batidas .= "<td align=center width=\"70\"><strong>$exibe_mk</strong></td><td align=center width=\"70\"><a href=ponto_desconto.php?f=$func&d=$f&mes=$mes&ano=$ano title=\"Adicionar Exceção\"><img src=img/ico_mais.gif border=0 hspace=2 align=absmiddle></a>&nbsp;$temextra</td><td width=\"25\">&nbsp;</td></tr></table></li>\n";
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
                                        $mostramais = "<a href=ponto_desconto.php?f=$func&d=$f&mes=$mes&ano=$ano title=\"Adicionar Exceção\"><img src=img/ico_mais.gif border=0 hspace=2></a>";
                                        $mostrafalta = "<a href=ponto_falta.php?f=$func&d=$f&mes=$mes&ano=$ano title=\"Adicionar Falta\"><img src=img/ico_menos.gif border=0 hspace=2></a>";
                                        if ($tipoex == 0) {
                                            $saldototalcarga += $horasdevidas;
                                            $saldoextra = "<font color=red>$exibecarga:00</font>";
                                        }else if ($tipoex == 1) {
                                            $saldoextra = "-";
                                            $exibecarga = "-";
                                            $mostramais = "-";
                                        }
                                        $str_batidas = "<li><table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center><strong>".str_pad($f,2,"0",STR_PAD_LEFT)."/".str_pad($mes,2,"0",STR_PAD_LEFT)."</strong></td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"><strong>$exibecarga</strong></td><td align=center width=\"70\" bgcolor=#cecece>$saldoextra</td><td align=center width=\"70\">$exibe_mk</td><td align=center width=\"70\"> - </td><td align=center width=\"70\"><strong>$exibe_mk</strong></td><td align=center width=\"70\">$mostramais</td><td align=center width=\"25\">$mostrafalta</td></tr></table></li>\n";
                                    }else{
                                        $str_batidas = "<li><table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center><strong>".str_pad($f,2,"0",STR_PAD_LEFT)."/".str_pad($mes,2,"0",STR_PAD_LEFT)."</strong></td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"70\"> - </td><td align=center width=\"25\"> - </td></tr></table></li>\n";   
                                    }
                                }
                                
                                if ($temexcecao && $tipoex == 0){
                                    $mk_total += $horastot;
                                    $mk_total_ext += $horastot;
                                    $str_batidas .= "<li><table bgcolor=#f2f1ed width=925>
                                                            <tr>
                                                                <td align=center width=\"30\">&nbsp;</td>
                                                                <td align=left><img src=img/seta_ponto.gif align=absmiddle></td>
                                                                <td align=left width=\"300\">$motivo</td>
                                                                <td align=center width=\"70\"><font color=blue>".sec_to_time($horastot)."</font></td>
                                                                <td align=center width=\"70\"> - </td>
                                                                <td align=center width=\"70\"> - </td>
                                                                <td align=center width=\"70\"><font color=blue>".sec_to_time($horastot)."</font></td>
                                                                <td align=center width=\"70\"><strong><font color=blue>".sec_to_time($horastot)."</font></strong></td>
                                                                <td align=center width=\"70\">&nbsp;</td>
                                                                <td align=center width=\"25\">&nbsp;</td>
                                                            </tr>
                                                    </table></li>\n";
                                }
                                
                                
                                echo $str_batidas;
                                
                                $str_batidas = str_replace("\"","",$str_batidas);
                                $str_batidas = str_replace("<li>","",$str_batidas);
                                $str_batidas = str_replace("</li>","",$str_batidas);
                                $str_batidas = str_replace("align=center ","",$str_batidas);
                                $html .= $str_batidas;
                            }
                            
                            if ($saldototal > $saldototalcarga){
                                $saldototalextra = "<font color=blue>".sec_to_time($saldototal - $saldototalcarga)."</font>";
                            }else{
                                $saldototalextra = "<font color=red>".sec_to_time($saldototalcarga - $saldototal)."</font>";
                            }
                            
                            $ds_mk = "";
                            
                            if ($mk_total < 0){
                                $ds_mk = "<font color=red>".sec_to_time($mk_total*-1)."</font>";
                            }else{
                                $ds_mk = "<font color=blue>".sec_to_time($mk_total)."</font>";
                            }
                            
                            //$mk_total_atr = "<font color=red>".sec_to_time($mk_total_atr)."</font>";
                            //$mk_total_ext = "<font color=blue>".sec_to_time($mk_total_ext)."</font>";
                            $mk_total_atr = "&nbsp;";
                            $mk_total_ext = "&nbsp;";
                            
                            echo "<li><table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center><strong>SALDO</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\"><strong>".sec_to_time($saldototal)."</strong></td><td align=center width=\"70\"><strong>".sec_to_time($saldototalcarga)."</strong></td><td align=center width=\"70\" bgcolor=#cecece>".$saldototalextra."</td>";
                            echo "<td width=\"70\" align=center>$mk_total_atr</td><td width=\"70\" align=center>$mk_total_ext</td><td align=center width=\"70\"><strong>$ds_mk</strong></td>\n";
                            echo "<td align=center width=\"70\">&nbsp;</td><td align=center width=\"25\">&nbsp;</td></tr></table></li>\n";
                            
                            $html .= str_replace("\"","","<table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center><strong>SALDO</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\"><strong>".sec_to_time($saldototal)."</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\" bgcolor=#cecece>&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\"><strong>$ds_mk</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"25\">&nbsp;</td></tr></table>\n");

                            if ($salario){
                                //$valorsegundo = $salario/($saldototalcarga*60*60);
                                //echo $valorsegundo."<br />";
                                $valorhora = ($salario/30/8)/60/60;
                                $valorsegundo .= $valorhora;
                                //echo $valorsegundo;
                                //exit();
                                //$valortrabalhado = ($saldototalextra*60*60)*$valorsegundo;
                                //$valorextra = ($saldototalextra*60*60)*$valorsegundo;
                                
                                echo "<li><table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center>&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\" colspan=2><strong>Salário Bruto:</strong></td><td align=center width=\"70\"><strong>R$ ".number_format($salario,2,",",".")."</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"25\">&nbsp;</td></tr></table></li>\n";
                                                                
                                if ($saldototal > $saldototalcarga){
                                    //$valorextra = (time_to_sec($saldototal - $saldototalcarga))*$valorsegundo;
                                    //$valorextra = (($saldototal - $saldototalcarga)*60*60)*$valorsegundo;
                                    $valorextra = ($saldototal - $saldototalcarga)*$valorsegundo;
                                   // echo $valorextra;
                                   // exit();                                                                        
                                    $salariofim = $salario+$valorextra;
                                    echo "<li><table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center>&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\" colspan=2><strong>Extra:</strong></td><td align=center width=\"70\"><font color=blue><strong>R$ ".number_format($valorextra,2,",",".")."</strong></font></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"25\">&nbsp;</td></tr></table></li>\n";
                                }else{
                                    //$valorextra = ($saldototalcarga - $saldototal)*$valorsegundo;
                                    $valorextra = ($saldototalcarga - $saldototal)*$valorsegundo;
                                    //echo $valorextra;
                                    //exit();                                    
                                    $salariofim = $salario-$valorextra;
                                    echo "<li><table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center>&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\" colspan=2><strong>Desconto:</strong></td><td align=center width=\"70\"><font color=red><strong>R$ ".number_format($valorextra,2,",",".")."</strong></font></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"25\">&nbsp;</td></tr></table></li>\n";
                                }
                                $valorinss= 0;
                                //CALCULO EM CIMA DAS HROAS TRABALHADAS
                                //if ($valortrabalhado <= 1040.22){
//                                    $percinss = 8;
//                                    $valorinss = $valortrabalhado * $percinss/100; 
//                                }else if ($valortrabalhado > 1040.22 && $valortrabalhado < 1733.7){
//                                    $percinss = 9;
//                                    $valorinss = $valortrabalhado * $percinss/100; 
//                                }else if ($valortrabalhado > 1733.7 && $valortrabalhado < 3467.4){
//                                    $percinss = 11;
//                                    $valorinss = $valortrabalhado * $percinss/100; 
//                                }else{
//                                    $valorinss = 381.41;
//                                }
                                
                                //calculo em cima do salario bruto
                                if ($salario <= 1040.22){
                                    $percinss = 8;
                                    $valorinss = $salario * $percinss/100; 
                                }else if ($salario > 1040.22 && $salario < 1733.7){
                                    $percinss = 9;
                                    $valorinss = $salario * $percinss/100; 
                                }else if ($salario > 1733.7 && $salario < 3467.4){
                                    $percinss = 11;
                                    $valorinss = $salario * $percinss/100; 
                                }else{
                                    $valorinss = 381.41;
                                }
                                //tirando INSS
                                $valorinss = 0;
                                //echo "<li><table width=\"660\"><tr><td align=center>&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\" colspan=2><strong>INSS:</strong></td><td align=center width=\"70\"><strong>R$ ".number_format($valorinss,2,",",".")."</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td></tr></table></li>\n";
                            }
                            if ($total_atrasos<0) $total_atrasos = 0;
                               echo "<li><table width=\"925\"><tr><td align=center width=\"30\">&nbsp;</td><td align=center>&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\" colspan=2><strong>Salário Líquido:</strong></td><td align=center width=\"70\"><strong>R$ ".number_format($salariofim,2,",",".")."</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"70\"><strong style=\"color: red\">".sec_to_time($total_atrasos)."</strong></td><td align=center width=\"70\"><strong style=\"color: blue\">".sec_to_time($total_extras)."</strong></td><td align=center width=\"70\">&nbsp;</td><td align=center width=\"25\">&nbsp;</td></tr></table></li>\n";
                            ?>
                            
                    	</ul>
                    
                    </div> <!-- /ver -->
                    
                    <?php if ($SS_nivel > 100 || $SS_logadm == 29) { 
                    
                    $dataini = "10/".str_pad($mes,2,"0",STR_PAD_LEFT)."/$ano 18:00";
                    ?>
                    <div id="Adic">
                        <form action="ponto3.php" method="post" name="form2">
                        <input type="hidden" name="idf" value="<?php echo $func; ?>" />
                        <input type="hidden" name="mes" value="<?php echo $mes; ?>" />
                        <input type="hidden" name="ano" value="<?php echo $ano; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="data">
                                       Data/hora:<br />
                                       <input value="<?php echo $dataini ?>" style="width:120px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" /> <a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle" /></a>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="   Adicionar Registro   " />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                         <script language="JavaScript">
						<!--
						var cal1 = new calendar1(document.forms['form2'].elements['dataini']);
						cal1.year_scroll = false;
						cal1.time_comp = true;
						-->
						</script>
                    </div>
                    <?php } ?>
                    

                    <script>
                      defineAba("abaVer","Ver");
                      <?php if ($SS_nivel > 100) { ?>
                      defineAba("abaAdic","Adic");
                      <?php } ?>
                      defineAbaAtiva("abaVer");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <form action="ponto_pdf.php" method="post" id="frmPonto">
                <input type="hidden" name="html" value="<?php echo str_replace("\n","",htmlentities($html));?>" />
                </form>
                <br />
              </td>
            </tr>
        </table>
        <script type='text/javascript'>
          $(function() {
             <?php echo $textosjus; ?>
          });
        </script>
<script>
   $(":date").dateinput({ format: 'dd/mm/yyyy' });
</script>
<?php include 'rodape.php'; ?>