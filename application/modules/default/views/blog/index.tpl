<div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="false"
     data-cycle-pause-on-hover="true">
      {foreach from=$banners_topo item=banner}
        {assign var="foto" value="{$banner['NR_SEQ_BANNER_BARC']}"}
        {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <a href="{$banner['DS_LINK_BARC']}">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
              <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {else}
              <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {/if}
        </a>
    {/foreach}
</div>

<section id="conteudo-blog">

    <h2 class="posreflole">reverb<span class="negrito">blog</span></h2>

    <form action="" id="search-blog-form" method="post">
        <div class="input-text">
            <input placeholder="Data - DD/MM/AAAA" type="search" name="search-date">
            <input placeholder="Título" type="search" name="search-text" class="search-input">
        </div>
        <div class="send-button search-icon">
            <button class="search-icon ir" type="submit">Pesquisar</button>
        </div>
    </form>

    <div id="conteudo-esquerda" class="posreflole">
        <ul id="lista-novidades">
            {foreach from=$contadores item=blog}
                {assign var="foto" value="{$blog['NR_SEQ_BLOG_BLRC']}"}
                {assign var="extensao" value="{$blog['DS_EXT_BLRC']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <li>
                    <div class="imagem-lista-novidades posreflole">
                        <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($blog['DS_TITULO_BLRC'])}, "idpost"=>{$blog['NR_SEQ_BLOG_BLRC']}], 'post', TRUE)}">
                            {if file_exists("arquivos/uploads/blog/$foto_completa")}
                                <img pagespeed_no_transform src="{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>150, 'altura'=>150, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$blog['DS_TITULO_BLRC']}" width="150" height="150" />
                            {else}
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>150, 'altura'=>150, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$blog['DS_TITULO_BLRC']}" width="150" height="150" />
                            {/if}
                        </a>
                    </div>

                    <div class="conteudo-postagem posreflole">
                        <a href="{$this->url(["titulo"=>{$this->createslug($blog['DS_TITULO_BLRC'])}, "idpost"=>{$blog['NR_SEQ_BLOG_BLRC']}], 'post', TRUE)}"><span class="posreflole titulo-post">{$blog['DS_TITULO_BLRC']|truncate:50:"...":TRUE}</span></a>
                        <span class="posreflori comentarios">({$blog['total_comentarios']}) comentários</span>
                        <span class="posreflole datahora">{$blog['DT_PUBLICACAO_BLRC']|date_format:"%d/%m/%Y"} ás {$blog['DT_PUBLICACAO_BLRC']|date_format:"%H:%M"} Por: <span class="quempostou">{$blog['DS_COLUNISTA_CORC']}</span></span>
                        <p class="posreflole texto-postagem">{$blog['DS_TEXTO_BLRC']|strip_tags|truncate:200:"...":TRUE}</p>

                        <div class="clearfix"></div>


						<a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($blog['DS_TITULO_BLRC'])}, "idpost"=>{$blog['NR_SEQ_BLOG_BLRC']}], 'post', TRUE)}" class="leiacompleto posreflole">Ler Mais +</a>
					</div>
				</li>
			{/foreach}
		</ul>
		<div id="paginacao" class="posreflole">
			<ul>
				{if $categoria neq ""}
					{if $pages.previous}
						<li class="tofirst">
								<a rel="nofollow" class="linkpagination" title="Página Anterior" rel="prev" href="{$this->url(["module"=>"default", "controller"=>"blog", "action"=>"index", "page"=>{$pages.previous}, "categoria"=>$categoria, "titulo"=>{$titulo}], "blog", TRUE)}"></a>
						</li>
					{/if}
					{section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}
						<li>
							<a rel="nofollow" class="linkpagination" rel="canonical" href="{$this->url(["module"=>"default","controller"=>"blog",  "action"=>"index", "page"=>$smarty.section.page_loop.index+1, "categoria"=>$categoria, "titulo"=>{$titulo}], 'blog', TRUE)}">
								{$smarty.section.page_loop.index+1}
							</a>
						</li>
					{/section}
					{if $pages.next}
						<li class="tolast">
							<a rel="nofollow" class="linkpagination" title="Próxima Página" rel="next" href="{$this->url(["module"=>"default", "controller"=>"blog", "action"=>"index", "page"=>{$pages.next}, "categoria"=>$categoria, "titulo"=>{$titulo}], "blog", TRUE)}">></a>
						</li>
					{/if}
				{else}
					{if $pages.previous}
						<li class="tofirst">
								<a rel="nofollow" class="linkpagination" title="Página Anterior" rel="prev" href="{$this->url(["module"=>"default", "controller"=>"blog", "action"=>"index", "page"=>{$pages.previous}], "blog", TRUE)}"><</a>
						</li>
					{/if}
					{section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}
						<li>
							<a rel="nofollow" class="linkpagination" rel="canonical" href="{$this->url(["module"=>"default","controller"=>"blog",  "action"=>"index", "page"=>$smarty.section.page_loop.index+1], 'blog', TRUE)}">
								{$smarty.section.page_loop.index+1}
							</a>
						</li>
					{/section}
					{if $pages.next}
						<li class="tolast">
							<a rel="nofollow" class="linkpagination" rel="next" title="Próxima Página" href="{$this->url(["module"=>"default", "controller"=>"blog", "action"=>"index", "page"=>{$pages.next}], "blog", TRUE)}">></a>
						</li>
					{/if}
				{/if}
			</ul>
		</div>
	</div>

    <div id="conteudo-direita" class="posreflole">

        <ul class="socials-network-dark">
            <li><a rel="nofollow" href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>
            <li><a rel="nofollow" href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>
            <li><a rel="nofollow" href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>
            <li><a rel="nofollow" href="http://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>
            <li><a rel="nofollow" href="http://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>
            {*<li class="last"><a rel="nofollow" href="https://plus.google.com/+reverbcity/posts" target="_blank" class="icon rss ir">Google Plus</a></li>*}
        </ul>

        <div class="banners-sidebar cycle-slideshow">
            {assign var="foto" value="{$_produto_dia->NR_SEQ_PRODUTO_PRRC}"}
            {assign var="extensao" value="{$_produto_dia->DS_EXT_PRRC}"}
            {assign var="foto_completa_dia" value="{$foto}.{$extensao}"}
            
            {assign var="fotos" value=$this->fotoproduto($_produto_dia->NR_SEQ_PRODUTO_PRRC)}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

            <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($_produto_dia->DS_PRODUTO_PRRC)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" class="product-photo">
                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$foto_completa_dia],'imagem', TRUE)}" alt="{$_produto_dia->DS_PRODUTO_PRRC}">
            </a>
            {*<span class="promocao_dia">Promoção do Dia</span>*}

        </div>
        <div class="product-details">
            <div class="circle" style="background-color: #5fbf98">
                <a>NEW</a>
            </div>
            <h2 class="product-name" style="height: 18px">
                <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                    {$_produto_dia->DS_PRODUTO_PRRC|truncate:29:"...":TRUE}
                    {if $_produto_dia->DS_FRETEGRATIS_PRRC == 'S'}
                        - Frete Grátis
                    {/if}
                </a>
            </h2>
            <p class="price">
                {if $destaque->VL_PROMO_PRRC neq 0}
                    <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$destaque->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                        <span class="old-price">R$ {$destaque->VL_PRODUTO_PRRC|number_format:2:",":"."}</span>
                        por R$ {$destaque->VL_PROMO_PRRC|number_format:2:",":"."}
                    </a>
                {else}
                    <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$destaque->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                        R$ {$destaque->VL_PRODUTO_PRRC|number_format:2:",":"."}
                    </a>
                {/if}
            </p>
        </div>
        <div id="categorias" class="posreflole">
            <h3>Categorias</h3>
            <ul>
                {foreach from=$categorias item=categoria}
                    <li>
                        <a href="{$this->url(["categoria"=>$categoria->NR_SEQ_BLOGCAT_BCRC, "titulo"=>$this->createslug($categoria->DS_CATEGORIA_BCRC)])}">{$categoria->DS_CATEGORIA_BCRC|truncate:30:"...":TRUE}</a>
                    </li>
                {/foreach}
            </ul>
            <a href="#" class="vejamais posreflole">veja mais +</a>

        </div>



        {*<div id="forum" class="posreflole">*}
            {*<h3>Forum</h3>*}
            {*<ul>*}
                {*{foreach from=$foruns item=forum}*}
                    {*<li><a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($forum->DS_TOPICO_TOSO)}, "idforum"=>{$forum->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}">{$forum->DT_CADASTRO_TOSO|date_format:"%m/%y"} | {$forum->DS_TOPICO_TOSO|truncate:20:"...":TRUE}</a></li>*}
                {*{/foreach}*}
            {*</ul>*}
            {*<a rel="nofollow" href="{$this->url([], 'forum', TRUE)}" class="vejamais posreflole">veja mais +</a>*}
        {*</div>*}

        <div class="banners-sidebar cycle-slideshow"
         data-cycle-fx="fadeout"
         data-cycle-timeout="5000"
         data-cycle-slides="> a"
         data-cycle-log="false"
         data-cycle-pause-on-hover="true">
            {foreach from=$banners item=banner}
            {assign var="foto" value="{$banner['NR_SEQ_BANNER_BARC']}"}
            {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <a rel="nofollow" href="{$banner['DS_LINK_BARC']}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                  <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
                {else}
                  <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
                {/if}
            </a>
            {/foreach}
    </div>

    </div>
</section>