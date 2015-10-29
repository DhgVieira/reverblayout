<?php
		$str1 = "";
		$str2 = "";
			
		$sql = "SELECT NR_SEQ_MENU_PERC, DS_LINK_MERC ";
		$sql = $sql . "FROM permissoes, menus WHERE NR_SEQ_MENU_PERC = NR_SEQ_MENU_MERC and NR_SEQ_USUARIO_PERC=" . $SS_logadm;
		$st1 = mysql_query($sql);
		$idmenu = "";
		$paginas = "";
        //echo $sql;
        //exit();
		while($row = mysql_fetch_row($st1)) {
			$idmenu .= $row[0].",";
			$paginas .= $row[1].",";
		}
		$idmenu .= "0";

		$sql = "select DS_ICONE_MERC, DS_DESCRICAO_MERC, DS_LINK_MERC from menus WHERE DS_STATUS_MERC = 'A' and NR_SEQ_MENU_MERC in ($idmenu) order by NM_ORDER_MERC";
		$st = mysql_query($sql);
		if (mysql_num_rows($st) > 0) {
			while($row = mysql_fetch_row($st)) {
				$icone = $row[0];
				$desc = $row[1];
				$link = $row[2];
				
				$str1 .= "<td width=\"53\" align=\"center\"><a target=\"_top\" href=\"$link\"><img src=\"$icone\" border=\"0\" /></a></td>";
				$str2 .= "<td width=\"53\" align=\"center\">$desc</td>";
			}
		}
        
        $sql = "select DS_PAGINA_SMRC from menu_subs WHERE ST_SUBMENU_SMRC = 'A' and NR_NIVEL_SMRC <= $SS_nivel and NR_SEQ_MENU_SMRC in ($idmenu)";
		$st = mysql_query($sql);
		if (mysql_num_rows($st) > 0) {
			while($row = mysql_fetch_row($st)) {
				$paginas .= $row[0].",";
			}
		}	
		?>
        <table class="textostabelas">
        	<tr>
                <?php echo $str1; ?>
                    <!--<td width="53" align="center"><a target="_blank" href="doc/reverbdoc/"><img src="img/dc.png?PageSpeed=off" border="0"  width="53" height="52" /></a></td>-->
                <td width="53"align="center"><a target="_top" href="logout.php"><img src="img/logout.png" border="0"/></a></td>
            </tr>
            <tr>
            	<?php echo $str2; ?>
                <!--<td width="53" align="center">Doc</td>-->
                <td width="53" align="center">Logout</td>
            </tr>
        </table>
        
        <?php
        //bloquear a pagina
		$paginas .= "erro.php";
		$pos = strpos($paginas, $pagina_atual);
		if ($pos === false) {
         exit();
        }
		?>