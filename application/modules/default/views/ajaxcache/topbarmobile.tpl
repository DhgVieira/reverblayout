<div id="page-nav">
<div class="left-side">
	{if $currentController=="reverbcycle"}
	<span class="logo-topo ir cycle">
		<a accesskey="1" href="{$this->url([], 'reverbcycle', TRUE)}">
			<img src="{$basePath}/arquivos/default/images/reverb-cycle-logo.png" width="88" height="88" alt="Reverbcycle – Música que veste!">
		</a>
		<span class="alt-logo ir">Reverbcity – Música que veste!</span>
	</span>
	{else}
	<span class="logo-topo ir">
		<a accesskey="1" href="{$this->url([], 'inicio', TRUE)}">
			<img src="{$basePath}/arquivos/default/images/logos/reverbcity.png" width="88" height="88" alt="Reverbcity – Música que veste!">
		</a>
		<span class="alt-logo ir">Reverbcity – Música que veste!</span>
	</span>
	{/if}
	<div id="site-menu" role="navigation">
		<span class="btn-open ir">Abrir menu</span>
		<ul class="menu">
			<li class="menu-item home">
				<a class="menu-item-link" href="{$this->url([], 'inicio', TRUE)}">Home</a>
			</li>
			<li class="menu-item loja dropdown">
				<a class="menu-item-link" href="{$this->url([], 'todos-produtos', TRUE)}">Loja</a>
				<ul class="mobile-dropdown-menu drop-loja">
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'novidades', TRUE)}">Novidades</a></li>
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'masculino', TRUE)}">Masculino</a></li>
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'feminino', TRUE)}">Feminino</a></li>
					<!-- <li class="submenu-item"><a class="menu-item-link" href="{$this->url([], 'acessorios', TRUE)}">Acessórios</a></li> -->
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'casa', TRUE)}">Casa</a></li>
					<!-- <li class="submenu-item"><a class="menu-item-link" href="{$this->url([], 'converse', TRUE)}">Converse</a></li> -->
					<!-- <li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'sale', TRUE)}">Sale</a></li> -->
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'valepresente', TRUE)}">Vale Presente</a></li>
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'avisame', TRUE)}">Avise-me</a></li>
					<li class="submenu-item last"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'colecoesantigas', TRUE)}">Classics</a></li>
					<li class="submenu-item last"><a class="menu-item-link" href="{$this->url([], 'todos-produtos', TRUE)}">Todos Produtos</a></li>
				</ul>
			</li>
			<li class="menu-item sale">
				<a class="menu-item-link home c-orange" href="{$this->url([], 'sale', TRUE)}">Sale</a>
			</li>
			<li class="menu-item reverbme dropdown">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'reverbme', TRUE)}">Reverbme</a>
				<ul class="mobile-dropdown-menu drop-reverbme">
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'reverbmedetalhe', TRUE)}">Perfil</a></li>
					<li class="submenu-item"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'people', TRUE)}">Reverbpeople</a></li>
					<li class="submenu-item last"><a rel="nofollow" class="menu-item-link" href="{$this->url([], 'reverbcycle', TRUE)}">Reverbcycle</a></li>
				</ul>
			</li>
			<li class="menu-item blog">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'blog', TRUE)}">Blog</a>
			</li>
			<li class="menu-item forum">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'forum', TRUE)}">Forum</a>
			</li>
			<li class="menu-item wholesale">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'cadastrolojista', TRUE)}">Atacado</a>
			</li>
			<li class="menu-item imprensa">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'imprensa', TRUE)}">Imprensa</a>
			</li>
			<li class="menu-item quem-somos">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'quemsomos', TRUE)}">Quem somos</a>
			</li>
			<li class="menu-item contato">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'contato', TRUE)}">Contato</a>
			</li>
			<li class="menu-item contato">
				<a rel="nofollow" class="menu-item-link" href="{$this->url([], 'ajuda', TRUE)}">Ajuda</a>
			</li>
		</ul>
	</div>
</div>
<div class="right-side">
	<ul class="mobile-actions">
		<li>
			<a rel="nofollow" href="#filters" class="ir mobile-action-btn mobile-icon icon-filter">Filtros</a>
			{include file="mobile-filters.tpl"}
		</li>
		<li>
			<a rel="nofollow" href="#login" class="ir mobile-action-btn mobile-icon icon-login">Fazer Login</a>
			<div id="login" class="mobile-action-box hidden">
				<form id="rvb-form-login_m" method="post" action="{$this->url([], 'login', TRUE)}">
					{if $_logado eq 1}
					<div class="rvb-form-field">
						<input disabled value="{$_nome_usuario}" id="quickemail_m" type="email" name="email" placeholder="E-MAIL" required>
					</div>
					<div class="rvb-form-field">
						<input disabled value="111111" id="quicksenha_m" type="password" name="senha" placeholder="SENHA" required>
					</div>
					<div class="send-button">
						<a class="btn" href="{$this->url([], 'logout', TRUE)}">Logout</a>
					</div>
					{else}
					<div class="rvb-form-field">
						<input id="quickemail_m" type="email" name="email" placeholder="E-MAIL" required>
					</div>
					<div class="rvb-form-field">
						<input id="quicksenha_m" type="password" name="senha" placeholder="SENHA" required>
					</div>
					<div class="send-button">
						<button class="btn" type="submit">Login</button>
					</div>
					<div class="rvb-form-field status">
						<label class="checkbox" for="stay_m">
							<input id="stay_m" type="checkbox" name="manter_logado" value="1"> Permanecer logado
						</label>
					</div>
					{/if}
				</form>
			</div>
		</li>
		<li>
			<a href="{$this->url([], 'reverbme')}" class="ir mobile-icon icon-new-user">Criar Conta</a>
		</li>
		<li>
			<a rel="nofollow" href="#cart" class="ir mobile-action-btn mobile-icon icon-cart">Carrinho
				<span class="reverb-count red" id="ordersCountWrapper">
					<span id="orderCountValue">{$_totalprodutos|count}</span>
				</span>
			</a>
			<div id="cart" class="mobile-action-box hidden">
				<p class="flyout-title">Últimos itens adicionados ao seu carrinho:</p>
				<ul class="flyout-list my-cart-items">
					{if $_totalprodutos|count > 0}
					{foreach from=$_totalprodutos item=produto name=prod}
					{assign var="foto" value="{$produto['codigo']}"}
					{assign var="extensao" value="{$produto['path']}"}
					{assign var="foto_completa" value="{$foto}.{$extensao}"}

					{assign var="fotos" value=$this->fotoproduto($produto['codigo'])}
					{assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
					{assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
					{assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
					{if $smarty.foreach.prod.index == 3}
					{break}
					{/if}
					<li>
						<a rel="nofollow" class="my-cart-product-thumb" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
							{if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
							<!-- Polyfill para imagens responsivas-->
							<span data-picture data-alt="{$produto['nome']}" data-title="{$produto['nome']}">
								<span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>88, 'altura'=>103, 'imagem'=>$foto_completa], "imagem", TRUE)}"></span>
								<!-- for hd displays -->
								<span data-width="88" data-height="103" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>196, 'altura'=>206, 'imagem'=>$foto_completa], "imagem", TRUE)}" data-media="(-webkit-min-device-pixel-ratio: 2.0)"></span>

								<noscript>
									<img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>88, 'altura'=>103, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
								</noscript>
							</span>
							{else}
							<!-- Polyfill para imagens responsivas-->
							<span data-picture data-alt="{$produto['nome']}" data-title="{$produto['nome']}">
								<span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>88, 'altura'=>103, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}"></span>
								<!-- for hd displays -->
								<span data-width="88" data-height="103" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>196, 'altura'=>206, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" data-media="(-webkit-min-device-pixel-ratio: 2.0)"></span>

								<noscript>
									<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>88, 'altura'=>103, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
								</noscript>
							</span>
							{/if}
						</a>
						<a class="my-cart-product-name" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
							{utf8_decode($produto['nome'])|truncate:28:"..":true}
						</a>
						<a rel="nofollow" class="my-cart-product-description" href="{$this->url(["titulo"=>{$this->createslug($produto['nome'])}, "idproduto"=>{$produto['codigo']}], 'produto', TRUE)}">
							<span class="product-gender">{utf8_decode($produto['genero'])}</span>
							<span class="product-size">Tamanho {utf8_decode($produto['sigla_tamanho'])}</span>
							<span class="product-amount">Quantidade: {utf8_decode($produto['quantidade'])}</span>
							{if $produto['vl_promo'] neq 0}
							<span class="product-price">R$ {$produto['vl_promo']|number_format:2:",":"."}</span>
							{else}
							<span class="product-price">R$ {$produto['valor']|number_format:2:",":"."}</span>
							{/if}
						</a>
						{if $produto['tipo'] neq 9}
						<a rel="nofollow" href="{$this->url(["idestoque"=>{$produto['idestoque']}], 'removercarrinho', TRUE)}" class="my-cart-remove-item md-close ir">Remover</a>
						{else}
						<a rel="nofollow" href="{$this->url(["idproduto"=>{$produto['codigo']}], 'removercarrinho', TRUE)}" class="my-cart-remove-item md-close ir">Remover</a>
						{/if}
					</li>
					{/foreach}
					{else}
					<li>
						<p class="name" style="text-align: center;">Seu carrinho esta vazio.</p>
					</li>
					{/if}
				</ul>
				<span class="total">Total parcial: R$ {$_total_carrinho|number_format:2:",":"."}</span>
				{if $_totalprodutos|count > 0}
				<a rel="nofollow" href="{$this->url([], 'carrinho', TRUE)}" class="flyout-button see-more">Ver carrinho</a>
				{else}
				<a rel="nofollow" href="{$this->url([], 'inicio', TRUE)}" class="flyout-button see-more">Comprar</a>
				{/if}
			</div>
		</li>
	</ul>
	<form action="{$this->url([], 'busca', TRUE)}" id="topbar-search-mobile" class="topbar-search" method="post">
		<input type="search" id="buscar_site_mobile" name="busca_topo" placeholder="Digite sua busca" class="input-box">
		<button type="submit" class="submit search-icon">Buscar</button>
	</form>
</div>
{literal}
<script type="text/javascript">
        $(function() {
            reverb.init();
            $.reject({
                reject: {
                    safari: false,
                    chrome: false,
                    firefox: false,
                    msie: true,
                    opera: false,
                    konqueror: false,
                    unknown: false
                },
                display: ["firefox", "chrome", "opera", "msie"]
            });
            $('#site-menu').removeClass('hidden');
            return false
        })
</script>
{/literal}