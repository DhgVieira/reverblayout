<? 
include 'auth.php';
include 'lib.php'; 
include 'topo.php'; ?>
    	<table class="textosjogos">
        	<tr>
            	<td height="20" width="130" align="center" bgcolor="#F7F7F7" class="textostabelas"><strong>ERRO</strong></td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7">
        	<tr>
            	<td align="left" height="18"><strong>Detalhes:</strong></td>
            </tr>
            <tr>
            	<td align="left" height="68" align="center">
                	<table width="99%" bgcolor="#FFFFFF" align="center">
                    	<tr>
                        	<td align="left">
                         		<h2>Erro!</h2>

                                <br /><br />
                                <?
                                $msg = request("msg");
                                ?>
                                <b>Ocorreu um erro na sua ultima operacao:</b>
                                <br />
                                <br />
                                <?echo $msg;?>
                                <br />
                                <br />
                                <a href="javascript:history.back()" /><u>Clique aqui para retornar a pagina anterior</u></a>
                                <br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
