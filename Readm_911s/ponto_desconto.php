<?php
include 'auth.php';
include 'lib.php';

$func = request("f");
$dia = request("d");
$mes = request("mes");
$ano = request("ano");

$str = "select DS_FUNCIONARIO_FURC, NR_HORAS_SEG_FURC, NR_HORAS_TER_FURC, NR_HORAS_QUA_FURC, 
               NR_HORAS_QUI_FURC, NR_HORAS_SEX_FURC, NR_HORAS_SAB_FURC, NR_HORAS_DOM_FURC
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
}else{
    exit();
}
?>
<?php include 'topo.php'; ?>
<script type='text/javascript' src="calendar1.js"></script>
<script type='text/javascript' src="scripts/autocomplete/jquery.tools.min.js"></script>

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
                      <li id="abasair" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='ponto.php'">Funcionários</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                        
                        <form action="ponto_desconto2.php" method="post" name="form2">
                        <input type="hidden" name="idf" value="<?php echo $func; ?>" />
                        <input type="hidden" name="dia" value="<?php echo $dia; ?>" />
                        <input type="hidden" name="mes" value="<?php echo $mes; ?>" />
                        <input type="hidden" name="ano" value="<?php echo $ano; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li><strong>Cadastrando Exceção para Funcionário</strong></li>
                                   <li>Atestado, compensação de horários etc</li>
                                   <li>
                                     <label for="data">
                                       Para o dia: <?php echo "<strong>".str_pad($dia,2,"0",STR_PAD_LEFT)."/".str_pad($mes,2,"0",STR_PAD_LEFT)."/$ano</strong>"; ?>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="desc">
                                       Descrição:<br />
                                       <textarea name="descricao" class="frm_pesq" cols="30" rows="4" style="width:300px;"></textarea>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="tempo">
                                       Tempo (ex.: 04:00:00 (4 horas))<br />
                                       <input style="width:120px;height:14px;text-align:center;" class="frm_pesq" type="text" name="horas" maxlength="8" value="00:00:00" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="   Adicionar Exceção   " />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>

                    </div>

                    <script>
                      defineAba("abaVer","Ver");
                      defineAbaAtiva("abaVer");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                
                <br />
              </td>
            </tr>
        </table>
<?php
mysql_close($con);
include 'rodape.php'; ?>