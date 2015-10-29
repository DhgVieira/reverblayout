<!doctype html>
<html>
	<head>
		{$this->headTitle()}
		{$this->headMeta()}
		{$this->headLink()}
		{$this->headScript()}

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		 {*assign var=basePath value="54.94.159.161/reverbcity.com"*}
		<script type="text/javascript">
            document.basePath = '{$basePath}';
			document.openedController = '{$openedController}';
		</script>
	</head>
	<body class="page-body gray page-fade" data-url="http://neon.dev">
		<div class="page-container">
			<div class="sidebar-menu">
				<header class="logo-env">

					<!-- logo -->
					<div class="logo">
						<a href="index.html">
							<img src="{$basePath}/arquivos/user/images/reverb-theme/logo@2x.png" width="220" alt="" />
						</a>
					</div>


					<!-- logo collapse icon -->
					<div class="sidebar-collapse">
						<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
							<i class="entypo-menu"></i>
						</a>
					</div>


					<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
					<div class="sidebar-mobile-menu visible-xs">
						<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
							<i class="entypo-menu"></i>
						</a>
					</div>

				</header>
				<ul id="main-menu" class="">
					<li id="user">
						<span>
							<span>Olá, {$logged_usuario['nome_usuario']|ucfirst}</span>
							<a href="{$this->url(['module'=>"user", 'controller'=>"usuarios", 'action'=>"logout"], "default", TRUE)}" class="fa fa-2x fa-power-off"></a>
						</span>
					</li>
					{foreach from=$menus item=menu}
					{assign var=route value={$menu->url_principal}}
						<li>
							{if $menu->url_principal eq ""}
								<a href="#">
							{else}
								<a href="{$this->url([], "{$route}", TRUE)}">
							{/if}
								<i class="{$menu->icone}"></i>
								<span>{$menu->descricao}</span>
							</a>
							<ul>
								{foreach from=$menu->findDependentRowset('user_Model_Menusitens') item=item}
									<li>
										<a href="{$basePath}/user/{$item->controlador}/{$item->acao}">
											<span>{$item->descricao}</span>
										</a>
									</li>
								{/foreach}
							</ul>
						</li>

					{/foreach}
				</ul>
				<!-- {$this->navigation()->menu()} -->
				
			</div>

			<div class="main-top">

				<div class="col-md-12 clearfix hidden-xs">
					<ul class="list-inline links-list pull-right">
						<li>
							<a href="http://www.reverbcity.com" target="_blank">
								Ir para o site
							</a>
						</li>

						<li class="sep"></li>

						<li>
							<a href="{$this->url(['module'=>"user", 'controller'=>"usuarios", 'action'=>"logout"], "default", TRUE)}">
								Log Out <i class="entypo-logout right"></i>
							</a>
						</li>
					</ul>
				</div>

				<!-- Breadcrumb Principal -->
				<div class="col-md-12 clearfix">
					<ol class="breadcrumb bc-3 main-breadcrumb">
						<li><a href="{$this->url([], "paineladm", TRUE)}">{$logged_usuario['nome_usuario']|ucfirst}</a></li>
						<li>
							<a href="#">
								{if $currentAction eq 'index'}
								 	Início
								{else}
									{$currentAction}
								{/if}
							</a>
						</li>
					</ol>
				</div>

				<hr/>


				<!-- Título da Página -->
				<div class="col-md-8 clearfix">
					<h2 class="main-title">
						{if $currentController eq 'index'}
							Home
						{else}
							{$currentController|ucfirst}
						{/if}
					</h2>
				</div>

				<!-- Ícones de ações -->
				<div class="col-md-4 clearfix main-actions">
					<ul class="list-inline links-list pull-right">
						<li>
							<a href="#" class="fa fa-copy" data-toggle="tooltip" data-placament="top" data-original-title="Copiar Página"></a>
						</li>
						<li>
							<a href="#" class="entypo-mail" data-toggle="tooltip" data-placament="top" data-original-title="Enviar Página"></a>
						</li>
						<li>
							<a href="javascript:self.print()" class="fa fa-print" data-toggle="tooltip" data-placament="top" data-original-title="Imprimir Página"></a>
						</li>
					</ul>
				</div>

				<div class="clear"></div>

			</div><!--/main-top--> 

			{$this->layout()->content}
			
			<!-- <div class="site-contents">
				<div class="site-left-breadcrumb">
					{$this->navigation()->breadcrumbs()->setLinkLast(TRUE)->setSeparator(' - ')->setMinDepth(-1)->render()}
				</div>
				<div class="site-middle">
					<div class="site-content">
						
					</div>
				</div>
			</div>
			
			<div class="site-footer"></div>
		</div>
		
		{if $success|default:"" != ""}
			<div id="msg-box" class="msg-success">
				{$success}
			</div>
		{/if}
		{if $error|default:"" != ""}
			<div id="msg-box" class="msg-error">
				{$error}
			</div>
		{/if} -->
	</body>
</html>