<?php
include 'auth.php';
include 'lib.php';

$id = request("id");
$testa = VerificaExtraAnt($id);

if ($testa[0]){
    echo "Precisa Justificar: ".$testa[1]." - Extras: ".$testa[2];
}

function VerificaExtraAnt($func){
    $retorna = array();
    $dia1 = 86400;
    $achou = false;
    $xyx = 1;
    while(!$achou && $xyx<=5){
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
        
        $temexcecao = false;
        
        $ano = date("Y", time() - $dia1);
        $mes = date("m", time() - $dia1);
        $f = date("d", time() - $dia1);
        
        $saldototal = 0;
        $saldototalcarga = 0;
        $mk_total_atr = 0;
        $mk_total_ext = 0;
        $mk_total = 0;
        
        $sql3 = "SELECT DS_TEMPO_PERC, NR_TIPO_OCORR_PERC from funcionarios_ponto_exc WHERE NR_SEQ_FUNCIONARIO_PERC = $func AND DT_EXCESSAO_PERC = '".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT)."'";
        $st3 = mysql_query($sql3);
        if (mysql_num_rows($st3) > 0) {
            $temexcecao = true;
            $row3 = mysql_fetch_row($st3);
            $horas  = $row3[0];
            $tipoex  = $row3[1];
        }
        
        $str = "select DT_REGISTRO_FRRC from funcionarios_ponto WHERE NR_SEQ_FUNCIONARIO_FRRC = $func
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
            
            if (!$exibecarga){
                $mk_total += ($saldo1+$saldo2);  
                $mk_total_ext += ($saldo1+$saldo2);
            }
            
            if ($exibecarga){
                $mk_atrasos = sec_to_time($mk_atrasos*-1);
                $mk_extras  = sec_to_time($mk_extras);
            }
            
            $horasdevidas = time_to_sec($exibecarga);
            if ($temexcecao){
                $horastot = time_to_sec($horas);                                            
                $horasdevidas = $horasdevidas - $horastot;
            }
            $saldototalcarga += $horasdevidas;
            $horasfeitas = $saldo1+$saldo2;
            if ($horasfeitas > $horasdevidas){
                $sql3 = "SELECT * from funcionarios_ponto_aut WHERE NR_SEQ_FUNCIONARIO_EARC = $func AND DT_AUTORIZADA_EARC = '".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT)."'";
                $st3 = mysql_query($sql3);
                if (mysql_num_rows($st3) <= 0) {
                    $saldototal -= ($horasfeitas - $horasdevidas);
                }
            }
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
                $mk_total -= time_to_sec($exibecarga);       
                $mk_total_atr += time_to_sec($exibecarga);
                
                $horasdevidas = time_to_sec($exibecarga);
                if ($temexcecao && $tipoex == 0){
                    $horastot = time_to_sec($horas);                                                                  
                    $horasdevidas = $horasdevidas - $horastot;
                }
                
                if ($tipoex == 0) {
                    $saldototalcarga += $horasdevidas;
                }      
            }
        }
        
        if ($temexcecao && $tipoex == 0){
            $mk_total += $horastot;
            $mk_total_ext += $horastot;
        }
        
        $retorna[1] = "";
        $retorna[2] = "";
        
        if (!$saldo1 && !$saldo2){
            //
        }else{
            if ($mk_total_ext > 0){
                $retorna[0] = true;
                $retorna[1] = "$f/$mes/$ano";
                $retorna[2] = $mk_total_ext;
            }else{
                $retorna[0] = false;
            }
            $achou = true;
        }
        $dia1 = $dia1 + 86400;
        $xyx++;
    }
    
    return $retorna;
}

function m2h($minutos) {
    $seconds = $minutos;

    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    
    if (strlen($hours)==1) $hours = "0".$hours;
    if (strlen($minutes)==1) $minutes = "0".$minutes;
    if (strlen($seconds)==1) $seconds = "0".$seconds;
 
    return "$hours:$minutes:$seconds";
}  

function time_to_sec($time) {
    if (strlen($time)==5) $time.=":00";
    $hours = substr($time, 0, -6);
    $minutes = substr($time, -5, 2);
    $seconds = substr($time, -2);
    
    return $hours * 3600 + $minutes * 60 + $seconds;
}

function sec_to_time($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor($seconds % 3600 / 60);
    $seconds = $seconds % 60;
    
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

mysql_close($con);
?>