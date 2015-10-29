<?php 

/*
* Função responsável por zeras as palavras buscadas
*
*/
//query de atualizar as quantidades
$srt_busca = "UPDATE 
			  	buscas 
			  SET 
			  	quantidade = 0";
//executo a query
$st_busca = mysql_query($str_busca);

?>