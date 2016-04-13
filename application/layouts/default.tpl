{strip}
<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
<head>
	{$this->headMeta()}
	{if $title}
	<title>{$title}</title>
	{else}
	{$this->headTitle()}
	{/if}
	{literal}
		<link rel="stylesheet" href="arquivos/default/css/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="/arquivos/default/css/site_default.css">
		<link rel="stylesheet" type="text/css" href="/arquivos/default/slick/slick.css"/>
	{/literal}
	<!-- teste123 -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' /><![endif]-->

	{*        {assign var=basePath value="/reverbcity.com"}*}
	<script type="text/javascript">
	document.basePath = '{$basePath}';
	</script>
	
	
	<meta property="fb:app_id" content="713473752042540" />
	<meta property="fb:admins" content="100000451099995"/>
	<meta property="og:title" content="{$title}"/>
	{if $currentController == 'loja'}
	<meta property="og:type" content="product"/>
	{else}
	<meta property="og:type" content="Website"/>
	{/if}

	{if $currentController == 'blog' && $currentAction == 'post'}
	{assign var="foto" value="{$blog->NR_SEQ_BLOG_BLRC}"}
	{assign var="extensao" value="{$blog->DS_EXT_BLRC}"}
	{assign var="foto_completa" value="{$foto}.{$extensao}"}

	<meta property="og:url" content="{$_pagina_atual}"/>
	<meta property="og:image" content="https://www.reverbcity.com{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>0, 'altura'=>0, 'imagem'=>$foto_completa], "imagem", TRUE)}"/>
	<meta property="og:description" content="{$description}" />
	{else}
	<meta property="og:url" content="{$_pagina_atual}"/>
	<meta property="og:image" content="https://www.reverbcity.com/arquivos/default/images/logos/facebook.png"/>
	<meta property="og:description" content="{$description}" />
	{/if}

	<meta name="google-site-verification" content="YfKGClvP1XyMBzOWO75NNO9JkgQVl9enIrCpxo7rL68" />
	<meta name="robots" content="index, follow, all" />
	{if $currentController == 'loja' && $currentAction == 'produto'}
		{if $produto->NR_SEQ_TIPO_PRRC == 6}
			{assign var=preTitle value='Camiseta '}
		{else}
			{assign var=preTitle value=''}
		{/if}
		{assign var=ds_produto_prrc value=' - '|explode:$produto->DS_PRODUTO_PRRC}
		{assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}
		{assign var=urlCanonical value="https://www.reverbcity.com/produto/{$this->createslug($slug)}/{$produto->NR_SEQ_PRODUTO_PRRC}"}

		<link rel="canonical" href="{$urlCanonical}" />
		<link rel="alternate" href="{$urlCanonical}" hreflang="pt-br" />
	{else}
		{if $currentController == 'index' && $currentAction == 'index'}
			<link rel="canonical" href="https://www.reverbcity.com/inicio" />
			<link rel="alternate" href="{$_pagina_atual}" hreflang="pt-br" />
		{else}
			<link rel="canonical" href="{$_pagina_atual}" />
			<link rel="alternate" href="{$_pagina_atual}" hreflang="pt-br" />
		{/if}
	{/if}

	{if $currentController == 'loja' && $currentAction == 'index'}
		{$this->paginationControl($contadores, NULL, 'paginator_loja_head.tpl')}
	{elseif $currentController == 'loja' && $currentAction == 'todos-produtos'}
		{$this->paginationControl($contadores, NULL, 'paginator_loja_head.tpl')}
	{elseif $currentController == 'index' && $currentAction == 'inicio'}
		{$this->paginationControl($contadores, NULL, 'paginator_loja_head.tpl')}
	{/if}

	<meta name="viewport" content="width=device-width, user-scalable=no" />

	<meta name="description" content="{$description}" />
	<meta name="keywords" content="{$keywords}" />
	<!-- Le fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-144-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-114-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-72-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" href="{$basePath}/arquivos/default/images/favicons/apple-touch-icon-57-precomposed.png" />
	<link rel="shortcut icon" href="{$basePath}/arquivos/default/images/favicons/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="{$basePath}/arquivos/default/images/favicons/favicon.ico" type="image/x-icon" />

        <!--[if lt IE 9]>
        <script type="text/javascript" src="{$basePath}/arquivos/default/js/libs/html5shiv.min.js"> </script>
        <![endif]-->

    {$this->headLink()}

    			{literal}
        		<script>
        		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        		ga('create', 'UA-38700671-1', 'auto');
        		ga('require', 'displayfeatures');
        		ga('require', 'ecommerce');
        		ga('require', 'linkid', 'linkid.js');
        		ga('send', 'pageview');

        		</script>
        		{/literal}
        		{if $currentAction eq "finalizar" and ($compra->ST_COMPRA_COSO == 'A' or $compra->ST_COMPRA_COSO == 'P')}
        		<script>
        		ga('ecommerce:addTransaction', {
        			'id': '{$compra->NR_SEQ_COMPRA_COSO}',
        			'affiliation': 'Reverbcity.com',
        			'revenue': '{$compra->VL_TOTAL_COSO}',
        			'shipping': '{$compra->VL_FRETE_COSO}',
        			'tax': '0'
        		});

        		{foreach from=$carrinho item=dadosProduto}
        		ga('ecommerce:addItem', {
        			'id': '{$compra->NR_SEQ_COMPRA_COSO}',
        			'name': '{$dadosProduto['nome']}',
        			'sku': '{$dadosProduto['codigo']}',
        			'price': '{$dadosProduto['valor']|number_format:2:".":""}',
        			'quantity': '{$dadosProduto['quantidade']}'
        		});
        		{/foreach}
        		ga('ecommerce:send');
        		</script>

        		<script type="text/javascript">
        		document.valorCompra = '{$compra->VL_TOTAL_COSO}';
        		</script>
        		{literal}
        		<script type="text/javascript">
        		(function() {
        			var _fbq = window._fbq || (window._fbq = []);
        			if (!_fbq.loaded) {
        				var fbds = document.createElement('script');
        				fbds.async = true;
        				fbds.src = '//connect.facebook.net/en_US/fbds.js';
        				var s = document.getElementsByTagName('script')[0];
        				s.parentNode.insertBefore(fbds, s);
        				_fbq.loaded = true;
        			}
        		})();
        		window._fbq = window._fbq || [];
        		window._fbq.push(['track', '6007459841147', {'value':document.valorCompra,'currency':'BRL'}]);
        		</script>
        		{/literal}
        		<noscript>
        			<img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6007459841147&amp;cd[value]={$compra->VL_TOTAL_COSO}&amp;cd[currency]=BRL&amp;noscript=1" />
        		</noscript>
				{/if}
	
        	</head>
        	<body>

			<div class="full-size" id="full-size"></div>

        		{if $_isMobile eq 1}
        		<header id="mobile-header" role="banner">
        			<div id="top-bar">        				
        				{* LOAD DINAMIC *}
        			</div>
        		</header>
        		{else}
        		<header id="desktop-header" role="banner">
        				<div id="top-bar">
        					<div id="page-nav" class="container">
        						{if $currentController=="reverbcycle"}
        						<span class="logo-topo ir cycle">
        							<a accesskey="1" href="{$this->url([], 'reverbcycle', TRUE)}">
        								<img pagespeed_no_transform src="{$basePath}/arquivos/default/images/reverb-cycle-logo.png" width="88" height="88" alt="Reverbcycle – Música que veste!">
        							</a>
        							<span class="alt-logo ir">Reverbcity – Música que veste!</span>
        						</span>
        						{else}
        						<a accesskey="1" href="{$this->url([], 'inicio', TRUE)}">
        							<span class="logo-topo ir">
        								<span class="alt-logo ir">Reverbcity – Música que veste!</span>
        							</span>
        						</a>
        						{/if}
        						<div class="left-side">
        							<ul class="actions-user">
        								{if $_logado eq 1}
        								<li>
        									<a href="#" class="reverb-button ir user" aria-labelledby="requestsCountWrapper" rel="nofollow">
        										<span class="reverb-count green" id="requestsCountWrapper">
        											{if $_amigos|count > 0}
        											<span id="requestsCountValue">{$_amigos|count}</span>
        											{/if}
        											<i class="accessible-elem"> Solicitações</i>
        										</span>
        									</a>
        									<div class="reverb-flyout">
        										<div class="flyout-header"></div>
        										<div class="flyout-container">
        											<p class="flyout-title">Solicitações de amizade:</p>
        											<ul class="flyout-list friend-requests">
        												{if $_amigos|count}
        												{foreach from=$_amigos item=amigo name=friends}
        												{assign var="foto" value="{$amigo['NR_SEQ_CADASTRO_CASO']}"}
        												{assign var="extensao" value="{$amigo['DS_EXT_CACH']}"}
        												{assign var="foto_completa" value="{$foto}.{$extensao}"}
        												{if $smarty.foreach.friends.index == 3}
        												{break}
        												{/if}
        												<li class="request-item clearfix">
        													<a rel="nofollow" href="{$this->url(["nome"=>{$this->createslug($amigo['DS_NOME_CASO'])}, "idperfil"=>{$amigo['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}" >
        														{if file_exists("arquivos/upload/reverbme/$foto_completa")}
        														<img class="thumb" alt="nome" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>38, 'altura'=>43, 'imagem'=>$foto_completa],"imagem", TRUE)}"/>
        														{else}
        														<img class="thumb" alt="nome" src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>38, 'altura'=>43, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"/>
        														{/if}
        													</a>
        													<p class="name">{utf8_decode($amigo['DS_NOME_CASO'])}</p>
        													<div class="buttons">
        														<a rel="nofollow" href="{$this->url(["idsolicitacao"=>{$amigo['NR_SEQ_AUT_AURC']}, "idamigo"=>{$amigo['NR_SEQ_CADASTRO_CASO']}], 'aceitaramigo', TRUE)}" class="button accept">Aceitar</a>
        														<a rel="nofollow" href="{$this->url(["idamigo"=>{$amigo['NR_SEQ_AUT_AURC']}], 'recusaramigo', TRUE)}" class="button decline">Rejeitar</a>
        													</div>
        												</li>
        												{/foreach}
        												{else}
        												<center> <p class="name">Você não possui solicitações no momento.</p> </center>
        												{/if}
        											</ul>
        											<a rel="nofollow" href="{$this->url([], 'reverbmedetalhe')}" class="flyout-button see-more">Ver mais</a>
        										</div>
        										<div class="flyout-footer"></div>
        									</div>
        								</li>
        								<li>
        									<a href="#" class="reverb-button ir messages" aria-labelledby="messagesCountWrapper" rel="nofollow">
        										<span class="reverb-count green" id="messagesCountWrapper">
        											{if $_privados|count > 0}
        											<span id="mercurymessagesCountValue">{$_privados|count}</span>
        											{/if}
        											<i class="accessible-elem"> Mensagens</i>
        										</span>
        									</a>
        									<div class="reverb-flyout">
        										<div class="flyout-header"></div>
        										<div class="flyout-container">
        											<p class="flyout-title">Mensagens privadas:</p>
        											<ul class="flyout-list private-messages">
        												{if $_privados|count > 0}
        												{foreach from=$_privados item=privado name=private}
        												{assign var="foto" value="{$privado['NR_SEQ_CADASTRO_CASO']}"}
        												{assign var="extensao" value="{$privado['DS_EXT_CACH']}"}
        												{assign var="foto_completa" value="{$foto}.{$extensao}"}
        												{if $smarty.foreach.private.index == 3}
        												{break}
        												{/if}
        												<li class="request-item clearfix">
        													<p class="name">{utf8_decode($privado['DS_NOME_CASO'])}</p>
        													<div class="details-column-left">
        														{if file_exists("arquivos/upload/reverbme/$foto_completa")}
        														<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>$foto_completa],"imagem", TRUE)}"/>
        														{else}
        														<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"/>
        														{/if}
        														<span class="date">em {$privado['DT_POST_SBRC']|date_format:"%d/%m"}</span>
        													</div>
        													<p class="message"> {utf8_decode($privado['DS_POST_SBRC']|truncate:40:"...":TRUE)}</p>
        													<div class="buttons">
        														<a href="{$this->url([], 'reverbmedetalhe')}" class="button accept" rel="nofollow">Ler tudo</a>
        														<a href="{$this->url(["idrecado"=>{$privado->NR_SEQ_SCRAP_SBRC}], 'deletarrecado', TRUE)}" class="button decline" rel="nofollow">Deletar</a>
        													</div>
        												</li>
        												{/foreach}
        												{else}
        												<center> <p class="name">Você não possui mensagens privadas no momento.</p> </center>
        												{/if}
        											</ul>
        											<a href="{$this->url([], 'reverbmedetalhe')}" class="flyout-button see-more" rel="nofollow">Ver todas</a>
        										</div>
        										<div class="flyout-footer"></div>
        									</div>
        								</li>
        								<li>
        									<a href="#" class="reverb-button ir notifications" aria-labelledby="notificationsCountWrapper" rel="nofollow">
        										<span class="reverb-count green" id="notificationsCountWrapper">
        											{if $_publicos|count > 0}
        											<span id="notificationsCountValue">{$_publicos|count}</span>
        											{/if}
        											<i class="accessible-elem"> Notificações</i>
        										</span>
        									</a>
        									<div class="reverb-flyout">
        										<div class="flyout-header"></div>
        										<div class="flyout-container">
        											<p class="flyout-title">Meus scraps:</p>
        											<ul class="flyout-list scrap-wall">
        												{if $_publicos|count > 0}
        												{foreach from=$_publicos item=publico name=public}
        												{assign var="foto" value="{$publico['NR_SEQ_CADASTRO_CASO']}"}
        												{assign var="extensao" value="{$publico['DS_EXT_CACH']}"}
        												{assign var="foto_completa" value="{$foto}.{$extensao}"}
        												{if $smarty.foreach.public.index == 3}
        												{break}
        												{/if}
        												<li class="request-item clearfix">
        													<p class="name"> {$publico['DS_NOME_CASO']}</p>
        													<div class="details-column-left">
        														{if file_exists("arquivos/upload/reverbme/$foto_completa")}
        														<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>$foto_completa],"imagem", TRUE)}"/>
        														{else}
        														<img class="thumb" alt="{utf8_decode($privado['DS_NOME_CASO'])}" src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>41, 'altura'=>46, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"/>
        														{/if}
        														<span class="date">em {$publico['DT_POST_SBRC']|date_format:"%d/%m"}</span>
        													</div>
        													{assign var=mensagemScrap value=$publico['DS_POST_SBRC']|strip_tags}
        													<p class="message">{$mensagemScrap|truncate:40:"...":TRUE}</p>
        													<div class="buttons">
        														<a href="{$this->url([], 'reverbmedetalhe')}" class="button accept" rel="nofollow">Ler tudo</a>
        														<a href="{$this->url(["idrecado"=>{$publico->NR_SEQ_SCRAP_SBRC}], 'deletarrecado', TRUE)}" class="button decline" rel="nofollow">Deletar</a>
        													</div>
        												</li>
        												{/foreach}
        												{else}
        												<center> <p class="name">Você não possui recados no momento.</p> </center>
        												{/if}
        											</ul>
        											<a href="{$this->url([], 'reverbmedetalhe')}" class="flyout-button see-more" rel="nofollow">Ver todos</a>
        										</div>
        										<div class="flyout-footer"></div>
        									</div>
        								</li>
        								{/if}
        							</ul>
        						</div>
        						<div class="right-side">
        							<ul class="actions-site">
        								{if $_logado eq 1}
        								<li>
        									<a class="ac-action ac-io" href="{$this->url([], "minhascompras", TRUE)}" rel="nofollow">MINHAS COMPRAS</a>
        								</li>
        								{/if}
        								<li>
        									{if $_logado eq 1}
        									<a class="ac-action ac-io" href="{$this->url([], 'logout', TRUE)}" rel="nofollow">LOGOUT</a>
        									{else}
        									<a href="#" class="reverb-button {if $email_error}opened{/if}" rel="nofollow">Login</a>
        									<div class="reverb-flyout login">
        										<div class="flyout-header"></div>
        										<div class="flyout-container">
        											<form id="rvb-form-login" method="post" action="{$this->url([], 'login', TRUE)}">
        												<div class="rvb-form-field">
        													<label class="legend" for="quickemail">E-mail</label>
        													<input id="quickemail" type="email" name="email" required value="{$email_error}">
        												</div>
        												<div class="rvb-form-field">
        													<label class="legend"  for="quicksenha">Senha</label>
        													<input id="quicksenha" type="password" name="senha" required>
        												</div>
        												<div class="rvb-form-field status">
        													<label class="checkbox" for="stay">
        														<input id="stay" type="checkbox" name="manter_logado" value="1"> Permanecer logado
        													</label>
        												</div>
        												<a class="forgot-pwd md-trigger" data-modal="lightbox-recuperar-senha" href="#" rel="nofollow">Esqueceu a senha?</a>
        												<div class="send-button">
        													<button type="submit" class="btn">Login</button>
        												</div>
        											</form>
        										</div>
        										<div class="flyout-footer"></div>
        									</div>
        									{/if}
        								</li>
        								<li>
        									<a href="{$this->url([], 'novome')}" rel="nofollow">
        										{if $_logado eq 1}
        										{$_nome_usuario|truncate:10:"..":true}
        										- Meu Perfil
        										{else}
        										Novo Cadastro
        										{/if}
        									</a>
        								</li>
        								<li class="no-border cart">
        									{*                                    {if $_ultima_action eq 'produto'}*}
        									{*                                        <a href="#" class="reverb-button my-cart opened" aria-labelledby="ordersCountWrapper" rel="nofollow">*}
        									{*                                    {else}*}
        									<a href="#" class="reverb-button my-cart" aria-labelledby="ordersCountWrapper" rel="nofollow">
        										{*  {/if}*}
        										Carrinho
        										<span class="reverb-count red" id="ordersCountWrapper">
        											<span id="orderCountValue">{$_totalprodutos|count}</span>
        										</span>
        									</a>
        									<div class="reverb-flyout cart">
        										<a href="#" class="my-cart-close reverb-button" rel="nofollow"></a>
        										<div class="flyout-header"></div>
        										<div class="flyout-container">
        											<p class="flyout-title">Últimos itens do seu carrinho:</p>
        											<ul class="flyout-list my-cart-items">
        												{if $_totalprodutos|count > 0}
        												{foreach from=$_totalprodutos item=produto name=prod}
        												{assign var="foto" value="{$produto['codigo']}"}
        												{assign var="extensao" value="{$produto['path']}"}
        												{assign var="foto_completa1" value="{$foto}.{$extensao}"}

        												{assign var="fotos" value=$this->fotoproduto($produto['codigo'])}
        												{assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
        												{assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
        												{assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
        												{if $smarty.foreach.prod.index == 3}
        												{break}
        												{/if}
        												<li>
        													<a class="my-cart-product-thumb" rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
        														{if file_exists("arquivos/uploads/fotosprodutos/$foto_completa") and $foto_completa != '.'}
        														<img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>54, 'altura'=>64, 'imagem'=>$foto_completa], "imagem", TRUE)}" width="54" height="64" alt="{$produto['nome']}" />
        														{elseif file_exists("arquivos/uploads/produtos/$foto_completa1")}
        														<img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>54, 'altura'=>64, 'imagem'=>$foto_completa1], "imagem", TRUE)}" width="54" height="64" alt="{$produto['nome']}" />
        														{else}
        														<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>54, 'altura'=>64, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" width="54" height="64" alt="{$produto['nome']}" />
        														{/if}
        													</a>
        													<a class="my-cart-product-name" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
        														{utf8_decode($produto['nome'])|truncate:13:"..":true}
        													</a>
        													{if $produto['tipo'] neq 9}
        													<a href="{$this->url(["idestoque"=>{$produto['idestoque']}], 'removercarrinho', TRUE)}" rel="nofollow" class="my-cart-remove-item ir">Remover</a>
        													{else}
        													<a href="{$this->url(["idproduto"=>{$produto['codigo']}], 'removercarrinho', TRUE)}" rel="nofollow" class="my-cart-remove-item ir">Remover</a>
        													{/if}
        													<a rel="nofollow" class="my-cart-product-description" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
        														<span class="product-gender">{if $produto['genero'] == 'm'}masculino{else}feminino{/if}</span>
        														<span class="product-size">Tamanho {utf8_decode($produto['sigla'])}</span>
        														<span class="product-amount">Quantidade {utf8_decode($produto['quantidade'])}</span>

        														{assign var="vl_lojista_tmp" value="{math equation="x * y" x=$produto['valor'] y=0.6}"}

        														{if $produto['vl_promo'] neq 0 and $vl_lojista_tmp > $produto['vl_promo']}
        														<span class="product-price">R$ {$produto['vl_promo']|number_format:2:",":"."}</span>
        														{else}
        														<span class="product-price">R$ {$produto['total_produto']|number_format:2:",":"."}</span>
        														{/if}
        													</a>
        												</li>
        												{/foreach}

        												{if $exibeBrindeCanecaPoster == 1}
        												<li>
        													<a href="{$this->url([], 'casa', TRUE)}" rel="nofollow" class="my-cart-product-thumb">
        														<img src="{$basePath}/arquivos/default/images/reverb-gift.png" />
        													</a>
        													<a class="my-cart-product-name" href="{$this->url([], 'casa', TRUE)}" rel="nofollow">
        														Brinde!
        													</a>
        													<a href="{$this->url([], 'casa', TRUE)}" class="my-cart-product-description" rel="nofollow">
        														<span class="product-gender">Brinde liberado! Escolha uma caneca ou um poster de brinde!</span>
        													</a>
        												</li>
        												{/if}
        												{else}
        												<li>
        													<p class="name" style="text-align: center;">Seu carrinho esta vazio.</p>
        												</li>
        												{/if}
        											</ul>
        											<span class="total">Total: R$ {$_total_carrinho|number_format:2:",":"."}</span>
        											{if $_totalprodutos|count > 0}
        											<a href="#" class="flyout-button see-more" rel="nofollow">{$_totalprodutos|count} itens</a>
        											<a href="{$this->url([], 'carrinho', TRUE)}" class="flyout-button see-more" rel="nofollow">Ver carrinho</a>
        											{*<a href="{$this->url([], 'loja', TRUE)}" class="flyout-button see-more">Continuar comprando</a>*}
        											{else}
        											<a href="{$this->url([], 'loja', TRUE)}" class="flyout-button see-more">Comprar</a>
        											{/if}
        										</div>
        										<div class="flyout-footer"></div>
        									</div>
        								</li>
        								<li class="no-border last international">
        									<a href="#" class="reverb-button ir international md-trigger" data-modal="international-purchases-lightbox" title="International Purchases" rel="nofollow">
        										Compras Internacionais
        									</a>
        								</li>
        							</ul>
        						</div>
        					</div>
        				</div>
        				<div id="site-menu" class="hidden" role="navigation">
        					<ul>
        						<li class="menu-item home">
        							<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'inicio', TRUE)}">Home</a>
        						</li>
        						<li class="menu-item loja dropdown">
        							<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'todos-produtos', TRUE)}">Loja</a>
        							<ul class="dropdown-menu drop-loja">
        								{*<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'lollapalooza', TRUE)}" style="color: #5fbf98;">Lollapalooza 2015</a></h2></li>*}
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'novidades', TRUE)}">Novidades</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'masculino', TRUE)}">Masculino</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'feminino', TRUE)}">Feminino</a></h2></li>
        								<!-- <li class="submenu-item"><a class="menu-item-link" href="{$this->url([], 'acessorios', TRUE)}">Acessórios</a></li> -->

        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'casa', TRUE)}">Casa</a></h2></li>
        								<!-- <li class="submenu-item"><a class="menu-item-link" href="{$this->url([], 'converse', TRUE)}">Converse</a></li> -->
        								<!-- <li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'sale', TRUE)}">Sale</a></h2></li> -->
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'valepresente', TRUE)}">Vale Presente</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'avisame', TRUE)}">Avise-me</a></h2></li>
        								<li class="submenu-item"><h2><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'colecoesantigas', TRUE)}">Classics</a></h2></li>
        								{*<li class="submenu-item last"><h2><a class="menu-item-link" href="{$this->url([], 'todos-produtos', TRUE)}">Todos Produtos</a></h2></li>*}
        							</ul>
        						</li>
        						<li class="menu-item sale">
        							<a class="menu-item-link home c-orange" href="{$this->url([], 'sale', TRUE)}">Sale</a>
        						</li>
        						<li class="menu-item reverbme dropdown">
        							<a class="menu-item-link" href="{$this->url([], 'reverbme', TRUE)}" rel="nofollow">Reverbme</a>
        							<ul class="dropdown-menu drop-reverbme">
        								<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'reverbmedetalhe', TRUE)}" rel="nofollow">Perfil</a></h2></li>
        								<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'people', TRUE)}" rel="nofollow">Reverbpeople</a></h2></li>
        								<li class="submenu-item"><h2><a class="menu-item-link" href="{$this->url([], 'reverbcycle', TRUE)}" rel="nofollow">Reverbcycle</a></h2></li>
        							</ul>
        						</li>
        						<li class="menu-item blog">
        							<a class="menu-item-link" href="{$this->url([], 'blog', TRUE)}" rel="nofollow">Blog</a>
        						</li>
        						<li class="menu-item forum">
        							<a class="menu-item-link" href="{$this->url([], 'forum', TRUE)}" rel="nofollow">Forum</a>
        						</li>
        						<li class="menu-item wholesale">
        							<a class="menu-item-link" href="{$this->url([], 'cadastrolojista', TRUE)}" rel="nofollow">Atacado</a>
        						</li>
        						<li class="menu-item imprensa">
        							<a class="menu-item-link" href="{$this->url([], 'imprensa', TRUE)}" rel="nofollow">Imprensa</a>
        						</li>
        						<li class="menu-item quem-somos">
        							<a class="menu-item-link" href="{$this->url([], 'quemsomos', TRUE)}" rel="nofollow">Quem somos</a>
        						</li>
        						<li class="menu-item contato">
        							<a class="menu-item-link" href="{$this->url([], 'contato', TRUE)}" rel="nofollow">Contato</a>
        						</li>
								<li class="menu-item busca">
									<form action="{$this->url([], 'busca', TRUE)}" id="topbar-search-desktop" class="topbar-search" method="post">
										<input type="text" name="busca_topo" id="busca_site" placeholder="Busca" class="input-box">
										<hr class="separador"></hr>
										<button type="submit" class="submit search-icon">Buscar</button>
									</form>
								</li>

        					</ul>
        				</div>
        				<div class="header container">

        					{*<div id="sac">*}
        						{*<p>SAC | seg-sex - 8:30 -17:30<br>*}
        							{*Fone: (43) 3322-8852 <br>*}
        							{*{if substr_count($_email_usuario, "@reverbcity.com")}*}
        							{*Usuários online: {$_totalusers}*}
                                                                {*{else}*}
                                                                {**}
        							{*{/if}*}
        						{*</p>*}
        					{*</div>*}
        				</div>
        			</header>
        			{/if}
        			<div id="main-content" role="main" class="container">
        				{if $success|default:"" != ""}
        				<!-- mensagem de sucesso -->
        				<div id="msg-box" class="msg-success">
        					<p><i class="rvb-icon"></i> {$success}</p>
        				</div>
        				{/if}
        				{if $error|default:"" != ""}
        				<!-- mensagem de erro -->
        				<div id="msg-box" class="msg-error">
        					<p><i class="rvb-icon"></i> {$error}</p>
        				</div>
        				{/if}
        				{$opennedController}
        				{$this->layout()->content}
        			</div>
        			<footer role="contentinfo">
        				{*{if $_isMobile neq 1}*}
        				{*{if $_chat_online eq 1}*}
        				{*<div class="chat_fixo" style="bottom: 0px; right: 0px; position: fixed; z-index: 99999; width: 80px; height: 185px ; background-color: #5fbf98; margin-bottom: 360px;-moz-border-radius: 10px;">*}
        				{*<a href="javascript:void(window.open('https://reverbcity.com/livezilla/chat.php?a=bc2a1','','width=590,height=760,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))" style="text-align:center; text-decoration: none; vertical-align: middle; color: #FFF; font-size: 11px; transform: rotate(90deg); transform-origin: left top 0; float: left; margin-left: 78px; margin-top: 50px;">*}
        				{*<img src="{$basePath}/arquivos/default/images/chat_icon.png" alt="Chat">   *}
        				{*ATENDIMENTO ONLINE*}
        				{*</a>*}
        				{*</div>*}
        				{*<!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">*}
        				{*var script = document.createElement("script");script.async=true;script.type="text/javascript";var src = "https://www.reverbcity.com/livezilla/server.php?a=bc2a1&request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img pagespeed_no_transform src="https://www.reverbcity.com/livezilla/server.php?a=bc2a1&amp;request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt="Chat" title="Chat"></noscript><!-- http://www.LiveZilla.net Tracking Code -->*}
        				{*{else}*}
        				{*<div class="chat_fixo" style="bottom: 0px; right: 0px; position: fixed; z-index: 99999; width: 80px; height: 185px ; background-color: #8f8f8f; margin-bottom: 360px;-moz-border-radius: 10px;">*}
        				{*<a href="javascript:void(window.open('https://reverbcity.com/livezilla/chat.php?a=bc2a1','','width=590,height=760,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))" style="text-align:center; text-decoration: none; vertical-align: middle; color: #FFF; font-size: 11px; transform: rotate(90deg); transform-origin: left top 0; float: left; margin-left: 78px; margin-top: 50px;">*}
        				{*<img src="{$basePath}/arquivos/default/images/chat_icon_off.png"  alt="Chat">   *}
        				{*ATENDIMENTO OFFLINE*}
        				{*</a>*}
        				{*</div>*}
        				{*{/if}*}
        				{*{/if}*}
        				<div id="base-bar">
        					<div class="container">
        						<div class="links-information">
        							<a href="{$this->url([], 'inicio', TRUE)}" title="Reverbcity" class="logo-footer ir" rel="nofollow">Reverbcity</a>
        							<a href="{$this->url([], "politicaprivacidade", TRUE)}" class="footer-link" rel="nofollow">Política de privacidade |</a>
        							<a href="{$this->url([], "termosuso", TRUE)}" class="footer-link" rel="nofollow">Termos de uso</a>
        							<p>&copy; {$smarty.now|date_format:"%Y"}, Reverbcity. All rights reserved.</p>
        							<a class="selo-trustsign" href="https://security.trustsign.com.br/?url=www.reverbcity.com" target="_blank">
        								<img name="trustseal" alt="Site Autêntico" src="https://security.trustsign.com.br/static/seals/selo-basic-98f7ad5ed4f3ef46935c5790190e837e-pt.png" border="0" title="Clique para Validar"/>
        							</a>
									<a href="http://trustedcompany.com/br/reverbcity.com-opiniões" target="_blank" title="Reverbcity avaliações no TrustedCompany.com">
										<img src="//trustedcompany.s3.amazonaws.com/sites/all/modules/custom/tc_site_integrations_seal/images/seal.png" alt="Reverbcity avaliações no TrustedCompany.com" class="selo-trustedcompany" />
									</a>
									<a class="selo-google" href="https://google.com/safebrowsing/diagnostic?hl=pt-PT&site=reverbcity.com" target="_blank">
										<img name="selo-google" alt="Site Autêntico" src="{$basePath}/arquivos/default/images/google-safe-browsing-transparent.png" border="0" title="Clique para Validar"/>
									</a>
									<div id="sustainable_website"></div>
									<div class="address">
										<span>Rua Ibiporã, 995 Jd. Aurora CEP - 86060-510 Londrina PR CNPJ: 08.345.875/0001-37 | Insc. Est.: 90385677-70</span>
									</div>
{*=======*}

{*>>>>>>> 32147427d9962ee265deb06d1114a180b4f5a38b*}
        						</div>
        						<div id="links-footer">
        							<div class="links-nav-footer first">
        								<p class="title">Home</p>
        								<ul>
        									<li><a href="{$this->url([], 'inicio', TRUE)}" rel="nofollow">Loja</a></li>
        									<li><a href="{$this->url([], 'colecoesantigas', TRUE)}" rel="nofollow">Classics</a></li>
        									<li><a href="{$this->url([], 'valepresente', TRUE)}" rel="nofollow">Vale-presente</a></li>
        									<li><a href="#" class="md-trigger" data-modal="tracking-lightbox" rel="nofollow">Rastreamento</a></li>
        									<li><a href="{$this->url([], 'avisame', TRUE)}" rel="nofollow">Avise-me</a></li>
        									<li><a href="{$this->url([], 'atacado', TRUE)}" rel="nofollow">Atacado</a></li>
        								</ul>
        							</div>
        							<div class="links-nav-footer">
        								<p class="title">Reverb Me</p>
        								<ul>
        									<li><a href="{$this->url([], 'novome', TRUE)}" rel="nofollow">Rede Social</a></li>
        									<li><a href="{$this->url([], 'blog', TRUE)}" rel="nofollow">Blog</a></li>
        									<li><a href="{$this->url([], 'forum', TRUE)}" rel="nofollow">Fórum</a></li>
        									<li><a href="{$this->url([], 'reverbcycle', TRUE)}" rel="nofollow">Reverbcycle</a></li>
        									<li><a href="{$this->url([], 'people', TRUE)}" rel="nofollow">Reverb People</a></li>
        								</ul>
        							</div>
        							<div class="links-nav-footer">
        								<p class="title">Info</p>
        								<ul>
        									<li><a href="{$this->url([], 'ajuda', TRUE)}" rel="nofollow">Ajuda</a></li>
        									<li><a href="{$this->url([], 'contato', TRUE)}" rel="nofollow">Contato</a></li>
        									<li><a href="{$this->url([], 'quemsomos', TRUE)}" rel="nofollow">Quem Somos</a></li>
        									<li><a href="{$this->url([], 'imprensa', TRUE)}" rel="nofollow">Imprensa</a></li>
        									<li class="has-tooltip">
        										<a href="#" class="hover-me">Trocas &amp; Devoluções</a>
        										<div class="tooltip">
        											A Reverbcity garante a troca de qualquer um de seus produtos,
        											sem ônus para o cliente, caso seja constatado defeito na peça.
        											Se o cliente quiser trocar uma peça (sem uso) por qualquer
        											outro motivo, ele deverá cobrir despesas de frete.
        											<a class="tooltip-link" href="{$this->url([], 'contato', TRUE)}">Clique aqui em fale conosco.</a>
        										</div>
        									</li>
        								</ul>
        							</div>
        							<div class="links-social">
										<p class="title">Siga-nos:</p>
        								<ul class="clearfix">
        									<li>
        										<a href="https://www.facebook.com/Reverbcity" title="Abrir a página de Facebook" target="_blank"><i class="fa fa-facebook fa-2x"></i></a>
        									</li>
        									<li>
        										<a href="https://twitter.com/reverbcity" title="Abrir a página de Twitter" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>
        									</li>
        									<li>
        										<a href="http://reverbcity.tumblr.com/" title="Abrir a página de Tumblr" target="_blank"><i class="fa fa-tumblr fa-2x"></i></a>
        									</li>
        									{*<li>*}
        										{*<a href="https://plus.google.com/+reverbcity" rel="publisher" title="Abrir a página de Flickr" target="_blank" class="icon flickr ir">Google+</a>*}
        									{*</li>*}
        									{*<li>*}
        										{*<a href="https://www.youtube.com/user/reverbcity" title="Abrir a página de Youtube" target="_blank" class="icon youtube ir">Youtube</a>*}
        									{*</li>*}
        									<li>
        										<a href="https://instagram.com/reverbcity" title="Abrir a página de Instagram" target="_blank"><i class="fa fa-instagram fa-2x"></i></a>
        									</li>
        									<li class="last">
        										<a href="https://pinterest.com/reverbcity/" title="Abrir a página de Pinterest" target="_blank"><i class="fa fa-pinterest fa-2x"></i></a>
        									</li>
        								</ul>
        							</div>
									<div class="footer-newsletter clearfix">
										<p class="title">Newsletter</p>
										<form action="{$this->url([], 'assinanews', TRUE)}" method="POST">
											<div class="form-field" >
												<input type="email" name="newsletter-email" id="newsletter-email" placeholder="E-MAIL">
												<button type="submit" class="btn">Enviar</button>
											</div>
										</form>
										<p class="subtitle">Receba notícias, novidades, promoções...</p>
										{*<address class="clearfix">*}
											{*<span>Rua Ibiporã, 995 Jardim Aurora</span>*}
											{*<span>CEP:  86060-510 Londrina/PR – F: (43) 3322-8852</span>*}
											{*<span>CNPJ: 08.345.875/0001-37 | Insc. Est.: 90385677-70</span>*}
											{*<span>WhatsApp: (43) 9834-4166</span>*}
										{*</address>*}
									</div>

        							<div class="payments">
										<p class="title">Aceitamos:</p>
										<ul class="clearfix">
											<li> <a class="visa ir">visa</a></li>
											<li> <a class="master ir">master</a></li>
											<li> <a class="amex ir">amex</a></li>
											<li> <a class="boleto ir">boleto</a></li>
										</ul>
										<span class="subtitle">Fone(43) 3322-8852 e WhatsApp(43) 9834 4166
										<br>
										<br>
										das 8:30 as 17:30 hs de Segunda a Sexta</span>
									</div>


        						</div>
        					</div>
        				</div>
        			</footer>
        			<!-- lightbox de compras internacionais -->
        			<div class="md-modal md-effect-1" id="international-purchases-lightbox">
        				<div class="md-content">
        					<p class="md-title">For international purchase, contact us:</p>
        					<div class="mg-bg">
        						<button class="md-close ir">Fechar</button>
        						<p>Fill up the form for international purchase</p>
        						<form action="{$this->url([], 'international', TRUE)}" method="post" id="form-international-purchases">
        							<div class="input-text left">
        								<input type="text" name="name-ip" id="name-ip" placeholder="Name" required>
        							</div>
        							<div class="input-text right">
        								<input type="email" name="email-ip" id="email-ip" placeholder="E-mail" required>
        							</div>
        							<div class="input-text left">
        								<input type="text" name="country-ip" id="country-ip" placeholder="Country" required>
        							</div>
        							<div class="input-text right">
        								<input type="text" name="city-ip" id="city-ip" placeholder="City" required>
        							</div>
        							<div class="text-box">
        								<textarea name="message-ip" id="message-ip" cols="1" rows="5" placeholder="Message" required></textarea>
        							</div>
        							{*<div class="insert-captcha">*}
        							{*<label>*}
        							{*<img src="{$basePath}/thumb/captcha/1/115/45/{$this->idCaptcha}.png" alt="captcha" height="45" width="115">*}
        							{*<!--  <input class="input-box" type="text" id="contato-captcha-code" name="captcha"> -->*}
        							{*<input name="captcha[input]" type="text" class="input-box" maxlength="3" title="Digite os caracteres da imagem" id="contato-captcha-code">*}
        							{*</label>*}
        							{*<input id="captcha" name="captcha[id]" value="{$this->idCaptcha}" type="hidden">*}
        							{*<span>Captcha</span>*}
        							{*</div>*}
        							<div class="send-button">
        								<button type="submit" class="btn">Send</button>
        							</div>
        						</form>
        					</div>
        				</div>
        			</div>
        			<!-- lightbox de rastreamento -->
        			<div class="md-modal md-effect-1" id="tracking-lightbox">
        				<div class="md-content">
        					<p class="md-title">Rastreamento de pedidos</p>
        					<div>
        						<button class="md-close ir">Fechar</button>
        						<p>Quer saber onde anda o seu pedido antes de chegar na sua casa? Digite o código de rastreamento no campo abaixo para descobrir:</p>
        						<form action="https://www.correios.com.br/servicos/rastreamento/remoto.cfm" name="rastreamento" target="_blank" method="post" id="form-rastreamento" class="md-bg" >
        							<label class="rvb-label" for="codigo-rastreamento">Código dos correios</label>
        							<input class="rvb-input-txt" name="p_codigo" id="codigo-rastreamento" type="text" required>
        							<p class="tam-p">Se o seu pedido for <b style="color: #5fbf98; font-weight: bold;">TAM</b>, <a href="https://www.tamcargo.com.br/vgn/v/index.jsp?vgnextoid=151b0943ede32310VgnVCM1000009508020aRCRD" target="_blank">clique aqui</a></p>
        							<div class="send-button">
        								<button type="submit" class="btn">Rastrear</button>
        							</div>
        						</form>
        						<p>Caso haja algum problema, entre em contato através do <a class="simple-anchor" href="mailto:atendimento@reverbcity.com">atendimento@reverbcity.com</a></p>
        					</div>
        				</div>
        			</div>
        			<!-- lightbox recuperar senha -->
        			<div class="md-modal md-effect-1" id="lightbox-recuperar-senha">
        				<div class="md-content">
        					<p class="md-title">Recuperar senha</p>
        					<div>
        						<button class="md-close ir">Fechar</button>
        						<p>Digite seu email receber uma nova senha:</p>
        						<form action="{$this->url([], "recuperarsenha", TRUE)}" name="recuperarsenha" method="post" id="form-recuperar" class="rvb-form" >
        							<label class="rvb-label" for="recuperar_email">Email:</label>
        							<input class="rvb-input-txt" name="email" id="recuperar_email" type="text" required>
        							<div class="send-button">
        								<button type="submit" class="btn">Recuperar</button>
        							</div>
        						</form>
        						<p>Caso haja algum problema, entre em contato através do atendimento@reverbcity.com</p>
        					</div>
        				</div>
        			</div>
        			{$this->headScript()}

        			{if $popupNiver}
        			<!-- lightbox aniversariante -->
        			<div class="md-modal md-effect-1" id="lightbox-aniversariante">
        				<div class="md-content" style="width: 503px;">
        					<div>
        						<button class="md-close ir">Fechar</button>
        						<a href="{$basePath}/todos-produtos">
        							<img src="{$basePath}/arquivos/default/images/banner_niver.jpg" />
        						</a>
        					</div>
        				</div>
        			</div>
        			<a href="#" id="md-aniversariante" data-modal="lightbox-aniversariante" class="md-trigger"></a>
        			<script type="text/javascript">
        			$(window).load(function(){
        				if(/bot|googlebot|crawler|spider|robot|crawling/i.test(navigator.userAgent) == false){
        					$('#md-aniversariante').click();
        				}
        			});
        			</script>
        			{/if}

        			<!-- lightbox primera -->
        <!-- {if $popupPrimeira}
            <div class="md-modal md-effect-1" id="lightbox-primeira">
                <div class="md-content" style="width: auto;">
                    <div>
                        <button class="md-close ir">Fechar</button>
                        <img src="{$basePath}/arquivos/default/images/banner_primeira.png" style="width: 100%" />
                        <form action="{$this->url([], 'assinanews', TRUE)}" method="POST">
                            <input type="email" required placeholder="E-MAIL" name="newsletter-email" style="position: absolute;margin-left: 25%;bottom: 20px;width: 25%;;height: 30px;" />
                            <button type="submit" style="position: absolute;margin-left: 51%;bottom: 20px;width: 165px;height: 30px;background-color: #000000;color: #ffffff; border: solid 1px #55bf9d;-webkit-border-radius: 7px;-moz-border-radius: 7px;border-radius: 7px; font-weight: bold; cursor: pointer;">QUERO ME CADASTRAR!</button>
                        </form>
                    </div>
                </div>
            </div>
            <a href="#" id="md-primeira" data-modal="lightbox-primeira" class="md-trigger"></a>
            <script type="text/javascript">
                $(window).load(function(){
                    if(/bot|googlebot|crawler|spider|robot|crawling/i.test(navigator.userAgent) == false) {
                        $('#md-primeira').click();
                    }
                });
            </script>
            {/if} -->

            <div class="md-overlay"></div>
            <!-- scripts -->
            
            <div id="fb-root"></div>
       		<script>(function(d, s, id) {
            	var js, fjs = d.getElementsByTagName(s)[0];
            	if (d.getElementById(id)) return;
            	js = d.createElement(s); js.id = id;
            	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=237745386316222";
            	fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

            

          {*<script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-1277643-30']);
          _gaq.push(['_trackPageview']);
          _gaq('require', 'displayfeatures');

          (function() {
          	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
          	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
      </script>*}
      {if $currentController == 'loja' && $currentAction == 'produto'}
      <script type="text/javascript">
      var google_tag_params = {
      	ecomm_prodid: "{$produto->NR_SEQ_PRODUTO_PRRC}",
      	ecomm_pagetype: "product",
      	ecomm_totalvalue: "{$produto->VL_PRODUTO_PRRC}"
      };
      </script>
      {/if}
      {literal}
      <script>
      (function() {
      	var _fbq = window._fbq || (window._fbq = []);
      	if (!_fbq.loaded) {
      		var fbds = document.createElement('script');
      		fbds.async = true;
      		fbds.src = '//connect.facebook.net/en_US/fbds.js';
      		var s = document.getElementsByTagName('script')[0];
      		s.parentNode.insertBefore(fbds, s);
      		_fbq.loaded = true;
      	}
      	_fbq.push(['addPixelId', '533464170121834']);
      })();
      window._fbq = window._fbq || [];
      window._fbq.push(['track', 'PixelInitialized', {}]);
      </script>
      <noscript>
      	<img height="1" width="1" alt="Facebook Pixel" style="display:none" src="https://www.facebook.com/tr?id=533464170121834&amp;ev=PixelInitialized" />
      </noscript>
      <!-- Código do Google para tag de remarketing teste-->
      <!--
        As tags de remarketing não podem ser associadas a informações pessoais de identificação nem inseridas em páginas relacionadas a categorias de confidencialidade. Veja mais informações e instruções sobre como configurar a tag em: http://google.com/ads/remarketingsetup
        -->
      <script type="text/javascript">
      /* <![CDATA[ */
      var google_conversion_id = 1047813471;
      var google_custom_params = window.google_tag_params;
      var google_remarketing_only = true;
      /* ]]> */
      </script>
      {/literal}

      {*<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">*}
      {*</script>*}
      {*<noscript>*}
      {*<div style="display:inline;">*}
      {*<img height="1" width="1" style="border-style:none;" alt="Double Click" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1047813471/?value=0&amp;guid=ON&amp;script=0"/>*}
      {*</div>*}
      {*</noscript>*}

      {*<script type="text/javascript" src="https://reverbcity.com/clickheat/js/clickheat.js"></script><script type="text/javascript"><!--*}
      {*clickHeatSite = 'www.reverbcity.com';*}
      {*clickHeatGroup = '{$currentController}/{$currentAction}';*}
            {*clickHeatServer = 'https://reverbcity.com/clickheat/click.php';initClickHeat(); //-->*}
            {*</script>*}
            <!-- Código do Google para tag de remarketing teste-->
        <!--------------------------------------------------
        As tags de remarketing não podem ser associadas a informações pessoais de identificação nem inseridas em páginas relacionadas a categorias de confidencialidade. Veja mais informações e instruções sobre como configurar a tag em: http://google.com/ads/remarketingsetup
        --------------------------------------------------->

        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 1047813471;
            var google_custom_params = window.google_tag_params;
            var google_remarketing_only = true;
            /* ]]> */

			WebFontConfig = {
				google: { families: [ 'Roboto:400,700:latin' ] }
			};
			(function() {
				var wf = document.createElement('script');
				wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
						'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
				wf.type = 'text/javascript';
				wf.async = 'true';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(wf, s);
			})();

        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1047813471/?value=0&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>
        <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
        <script type="text/javascript">twttr.conversion.trackPid('l5zln', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
        <noscript>
            <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l5zln&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
            <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l5zln&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
        </noscript>
      


		{* BUSCAR O MENU TOPO *}
		
		<script type="text/javascript">
			var isMobile = {if $_isMobile eq 1} 1 {else} 0 {/if};
			
			{literal}               			
			$('#top-bar').load('/ajaxcache/top?isMobile=' + isMobile.toString());
			$('#load-login-sidebar').load('/ajaxcache/sidebar-login');
			{/literal}
		</script>		
		

    </body>
</html>
{/strip}
