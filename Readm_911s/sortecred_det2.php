<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$descricao = request("descricao");
$valor = request("valor");
$idc = request("idc");
$tipo = request("tipo");
$datafim = request("datafim");
$comprazo = request("comprazo");

$dataprazo = "";

if ($comprazo == "S"){
    $dataprazo = "'".FormataDataMysql($datafim)."'";
}else{
    $dataprazo = "2060-01-01";
}

$valor = str_replace("R$","",$valor);
$valor = str_replace(".","",$valor);
$valor = str_replace(",",".",$valor);
$valor = str_replace(" ","",$valor);

$tipomovim = "";

if ($tipo == "D") {
    $valor = ($valor * -1);
    $tipomovim = "D&Eacute;BITO";
}else{
    $tipomovim = "CR&Eacute;DITO";
}

$str = "INSERT INTO contacorrente (NR_SEQ_CADASTRO_CRSA, VL_LANCAMENTO_CRSA, TP_LANCAMENTO_CRSA, DT_LANCAMENTO_CRSA, DS_OBSERVACAO_CRSA, DT_VENCIMENTO_CRSA)
			VALUES ($idc, $valor, '$tipo', sysdate(), '$descricao', $dataprazo)";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Efetuou Lancamento para o cliente $idc");

$sql = "select DS_NOME_CASO, DS_EMAIL_CASO from cadastros where NR_SEQ_CADASTRO_CASO = $idc";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $nome = $row[0];
    $email = $row[1];
}

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
            <p>O funcion&aacute;rio <strong>'.utf8_decode($SS_login).'</strong> realizou a seguinte movimenta&ccedil;&atilde;o:</p> 
          </div>    
          <div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
                <strong>Cliente:</strong> '.utf8_decode($nome).'<br />
                <strong>Data:</strong> '.date("d/m/Y G:i").'<br />
                <strong>Tipo:</strong> '.$tipomovim.'<br />
                <strong>Valor:</strong> R$ '.number_format($valor,2,",","").'<br />
                <strong>Descri&ccedil;&atilde;o:</strong> '.utf8_encode($descricao).'
          </div>
          ';
$corpo = IncluiPapelCarta("sistema",$texto,"MOVIMENTA&Ccedil;&Atilde;O DE CR&Eacute;DITO REALIZADA");

EnviaMailer("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","Tony","","Movimentacao nos Creditos",$corpo);
EnviaMailer("atendimento@reverbcity.com","Reverbcity","atendimento@reverbcity.com","Atendimento","janaina@reverbcity.com","Movimentacao nos Creditos",$corpo);
EnviaMailer("atendimento@reverbcity.com","Reverbcity","desenvolvimento@reverbcity.com","Daniel","","Movimentacao nos Creditos",$corpo);

$subject  = utf8_encode("Cr&eacute;dito Reverbcity!");

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
            <p>Ol&aacute; <strong>'.$nome.'</strong>,</p>
                    
            <p>Voc&ecirc; acaba de receber um cr&eacute;dito para uso na sua pr&oacute;xima reverbcompra. Confira abaixo os detalhes:</p> 
          </div>    
          <div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
                <strong>Data:</strong> '.date("d/m/Y G:i").'<br />
                <strong>Valido at&eacute;:</strong> '.date("d/m/Y G:i", strtotime("+90 days")).'<br />
                <strong>Tipo:</strong> '.$tipomovim.'<br />
                <strong>Valor:</strong> R$ '.number_format($valor,2,",","").'<br />
                <strong>Descri&ccedil;&atilde;o:</strong> '.$descricao.' <br />
                <strong>Obs.:</strong> Os cr&eacute;ditos s&atilde;o v&aacute;lidos por 90 dias.
          </div>
          ';
          
$corpo = IncluiPapelCarta("sistema",utf8_encode($texto),utf8_encode("NOVO CR&Eacute;DITO"));
?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0" style="font-size: 10px;">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Enviando E-mail</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">

                         <form action="envia_email_credito.php" method="post">
                         	<input name="email" type="hidden" value="<?php echo $email; ?>" />
                            <input name="nome" type="hidden" value="<?php echo $nome; ?>" />
                            <input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo">
                                       Assunto do E-Mail:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo $subject; ?>" /> <input type="submit" id="postar" name="postar" value="Enviar Email" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conteudo">
                                       Conteudo:<br />
                                       <?php
                                            //$contmala = "<table width=\"600\" align=\"center\" border=\"0\"><tr><td><img src=\"http://www.cheida15.can.br/img/topo_new.jpg\" border=\"0\" /></td></tr><tr><td height=\"150\">&nbsp;</td></tr><tr><td><img src=\"http://www.cheida15.can.br/img/rodape_new.jpg\" border=\"0\" /></td></tr><tr><td align=\"center\">Caso voc&ecirc; n&atilde;o queira mais receber este mailing, <a href=mailto:imprensa@cheida15.can.br?subject=CANCELAR>clique aqui</a></td></tr></table>";
                                            $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                            $oFCKeditor->ToolbarSet = 'MyToolbar';
                                            $oFCKeditor->BasePath = 'fckeditor/' ;
                                            $oFCKeditor->Height = 700 ;
											$oFCKeditor->Width = 670 ;
                                            $oFCKeditor->Value = $corpo ;
                                            $oFCKeditor->Create('conteudo');
                                            ?>
                                     </label>
                                   </li>
                                   </ul>
                             </fieldset>

                         </form>
                    
                    </div> <!-- /criar -->
                    
              

                    <script>
                      defineAba("abaCriar","Criar");
                      defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>