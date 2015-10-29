<?php
include 'auth.php';
include 'lib.php';

$mesn = date("m");
$anon = date("Y");
$sqladm = "SELECT DT_REGISTRO_ATRV, max(NR_QTDE_ATRV) FROM atividade WHERE DT_REGISTRO_ATRV > '$anon-$mesn-01 00:00:00' group by day(DT_REGISTRO_ATRV), hour(DT_REGISTRO_ATRV)";
$stadm = mysql_query($sqladm);

$result = "<chart>   <series>";
$result2 = "";
$result3 = "";
if (mysql_num_rows($stadm) > 0) {
    $x=0;
	while($rowadm = mysql_fetch_row($stadm)){
	   $data = $rowadm[0];
       $semana = date('w',strtotime($data));
       switch ($semana) {
           case 0: $semana = "dom"; break;
           case 1: $semana = "seg"; break;
           case 2: $semana = "ter"; break;
           case 3: $semana = "qua"; break;
           case 4: $semana = "qui"; break;
           case 5: $semana = "sex"; break;
           case 6: $semana = "sab"; break;
       }
       $dataf = date("d/m G:i",strtotime($data));
	   $result .= "<value xid='$x'>$dataf $semana</value>";
	   $result2 .= "<value xid='$x'>".$rowadm[1]."</value>";
       //$result3 .= "<value xid='$x'>".($rowadm[1]+20)."</value>";
       $x++;
    }
}
$result .= "</series><graphs>";
$result .= "<graph gid='1'>".$result2."</graph>";
//$result .= "<graph gid='2'>".$result3."</graph>";
$result .= "</graphs>   </chart>";
?>
<?php include 'topo.php'; ?>
<style>
#chart_plot{
    width: 1100px;
    height: auto;
}
</style>
    <script type="text/javascript" src="chart2/ui.pack.js"></script>
    <script type="text/javascript" src="chart2/framework.pack.js"></script>
    <script type="text/javascript" src="chart2/framework.js"></script>
    <script type="text/javascript" src="chart2/ui.js"></script>
	<script type="text/javascript" src="chart2/swfobject.js"></script>
	<script type="text/javascript" src="chart2/panel.js"></script>
	<script type="text/javascript" src="chart2/prototype-1.6.0.2.js"></script>
    <script language="JavaScript" src="chart2/calendar1.js"></script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="abaGraficos" class="abaativa">GR&Aacute;FICOS</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Atividade M&ecirc;s atual</li>
                      <li id="menuDepo" class="abainativa" onMouseOver='trataMouseAba(this);' onclick="document.location.href='grafico_ticketmed.php'">Cadastros x Ticket</li>
                      <li id="menuDepo" class="abainativa" onMouseOver='trataMouseAba(this);' onclick="document.location.href='grafico_primcompr.php'">Prim.Compra x Ticket</li>
                    </ul>
                </td>
                <td height="20" align="right" valign="middle">
                	&nbsp;
                </td>
            </tr>
            <tr>
            	<td align="left" bgcolor="#FFFFFF" colspan="2">
                <div id="chart_plot"></div>
        		<script>
        		// <![CDATA[
        				generateChart("<?php echo $result ?>");
        		// ]]>
        		</script>
                </td>
            </tr>
        </table>
    
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>