
<!--     {assign var="acaoAtual" value="loja"} -->
{assign var="acaoAtual" value="{$currentAction}"}
{assign var="controllerAtual" value="{$currentController}"}

{if $acaoAtual eq "index" and $controllerAtual eq "loja"}
    {assign var="acaoAtual" value="loja"}
{/if}

{if $acaoAtual eq "index" and $controllerAtual eq "atacado"}
    {assign var="acaoAtual" value="atacado"}
{/if}
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<div style="text-align:center;width:219px;">

    {*<ul class="socials-network-dark">*}
    {*<li><a rel="nofollow" href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>*}
    {*<li><a rel="nofollow" href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>*}
    {*<li><a rel="nofollow" href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>*}
    {*<li><a rel="nofollow" href="https://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>*}
    {*<li><a rel="nofollow" href="https://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>*}
    {*<li class="last"><a rel="nofollow" href="https://plus.google.com/+reverbcity/posts" target="_blank" class="icon rss ir">Google Plus</a></li>*}
    {*</ul>*}

    <!-- <p class="full-strip">Filtros</p> -->

    {*<form action="#" id="form-busca-filtros" class="clearfix" method="POST">*}

    {*<input type="text" class="search-input" placeholder="Digite a busca" name="busca_produto" {if $palavra_busca neq ''} value="{$palavra_busca}" {/if}>*}
    <!-- <div class="send-button search-icon">
        <button class="ir search-icon" type="submit">Buscar</button>
    </div> -->
    {*</form>*}
    <!-- filtro de valores -->
    <div class="menu-top">
        <span style="text-align: left">Filtre sua busca</span>
    </div>
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-values">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Valores</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-values">
        <li class="sub-menu-item">
            <div id="slide-green"></div>
            <label for="range-min"></label>
            <input type="text" id="range-min">
            <label for="range-max"></label>
            <input type="text" id="range-max">
        </li>
    </ul>
    {*{if $valor_url eq 19.90}*}
    {*<span class="sub-menu-link active">Até R$ 19,90</span>*}
    {*{else}*}
    {*<a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>"19.90"], "{$acaoAtual}", TRUE)}" class="sub-menu-link">*}
    {*Até R$ 19,90*}
    {*</a>*}
    {*{/if}*}
    {*</li>*}
    {*<li class="sub-menu-item">*}
    {*{if $valor_url eq 29.90}*}
    {*<span class="sub-menu-link active">Até R$ 29,90 - (SALE)</span>*}
    {*{else}*}
    {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>"29.90"], "{$acaoAtual}", TRUE)}" class="sub-menu-link">*}
    {*Até R$ 29,90*}
    {*</a>*}
    {*{/if}*}
    {*</li>*}
    {*<li class="sub-menu-item">*}
    {*{if $valor_url eq 30}*}
    {*<span class="sub-menu-link active">De R$ 30,00 A R$ 55,00</span>*}
    {*{else}*}
    {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>"30"], "{$acaoAtual}", TRUE)}" class="sub-menu-link">*}
    {*De R$ 30,00 A R$ 55,00*}
    {*</a>*}
    {*{/if}*}
    {*</li>*}
    {*<li class="sub-menu-item">*}
    {*{if $valor_url eq 59}*}
    {*<span class="sub-menu-link active">De R$ 59,00</span>*}
    {*{else}*}
    {*<a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>"59"], "{$acaoAtual}", TRUE)}" class="sub-menu-link">*}
    {*De R$ 59,00*}
    {*</a>*}
    {*{/if}*}
    {*</li>       *}
    {*<li class="sub-menu-item">*}
    {*{if $valor_url eq 61}*}
    {*<span class="sub-menu-link active">De R$ 61,00 A R$ 90,00</span>*}
    {*{else}*}
    {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>"61"], "{$acaoAtual}", TRUE)}" class="sub-menu-link">*}
    {*De R$ 61,00 A R$ 89,90*}
    {*</a>*}
    {*{/if}*}
    {*</li>*}
    {*<li class="sub-menu-item">*}
    {*{if $valor_url eq 90}*}
    {*<span class="sub-menu-link active">A PARTIR DE R$ 90,00</span>*}
    {*{else}*}
    {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>"90"], "{$acaoAtual}", TRUE)}" class="sub-menu-link">*}
    {*A PARTIR DE R$ 90,00*}
    {*</a>*}
    {*{/if}*}
    {*</li>*}
    {*</ul>*}

    {if $acaoAtual neq "casa"}
        <!-- filtro gênero -->
        <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-gender">
            <span class="icon-arrow"></span>
        </a>
        <div class="menu-title">
            <div class="left-menu-item">
                <h2><span class="menu-name">Gênero</span></h2>
            </div>
        </div>
        <ul class="sub-menu filter-by-gender">
            {if $acaoAtual neq 'masculino' AND $acaoAtual neq 'feminino'}
                <li class="sub-menu-item">
                    {if $genero eq "masculino"}
                        <h2><span class="sub-menu-link active">Masculino</span></h2>
                    {else}
                        <h2><a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>masculino, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">Masculino</a></h2>
                    {/if}
                </li>
                <li class="sub-menu-item">
                    {if $genero eq "feminino"}
                        <h2><span class="sub-menu-link active">Feminino</span></h2>
                    {else}
                        <h2><a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>feminino, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">Feminino</a></h2>
                    {/if}
                </li>
            {/if}
            {if $acaoAtual eq 'masculino'}
                <li class="sub-menu-item">
                    <h2><span class="sub-menu-link active">Masculino</span></h2>
                </li>
            {elseif $acaoAtual eq 'feminino'}
                <li class="sub-menu-item">
                    <h2><span class="sub-menu-link active">Feminino</span></h2>
                </li>
            {/if}
        </ul>
    {/if}
    {if $acaoAtual neq "casa"}
        <!-- filtro tamanhos -->
        <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-sizes">
            <span class="icon-arrow"></span>
        </a>
        <div class="menu-title">
            <div class="left-menu-item">
                <span class="menu-name">Tamanhos</span>
            </div>
        </div>
        <ul class="sub-menu filter-by-sizes">
            <li class="sub-menu-item">
                {if $tamanho_url eq "pp"}
                    <span class="sub-menu-link ui-button active">PP</span>
                {else}
                    <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>pp, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url},"valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">PP</a>
                {/if}
            </li>
            <li class="sub-menu-item">
                {if $tamanho_url eq "p"}
                    <span class="sub-menu-link ui-button active">P</span>
                {else}
                    <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>p, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">P</a>
                {/if}
            </li>
            <li class="sub-menu-item">
                {if $tamanho_url eq "m"}
                    <span class="sub-menu-link ui-button active">M</span>
                {else}
                    <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>m, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">M</a>
                {/if}
            </li>
            <li class="sub-menu-item">
                {if $tamanho_url eq "g"}
                    <span class="sub-menu-link ui-button active">G</span>
                {else}
                    <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>g, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">G</a>
                {/if}
            </li>
            <li class="sub-menu-item">
                {if $tamanho_url eq "gg"}
                    <span class="sub-menu-link ui-button active">GG</span>
                {else}
                    <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>gg, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">GG</a>
                {/if}
            </li>
            <li class="sub-menu-item">
                {if $tamanho_url eq "xgg"}
                    <span class="sub-menu-link ui-button active">XGG</span>
                {else}
                    <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>xgg, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">XGG</a>
                {/if}
            </li>
        </ul>
    {/if}
    {if $tipos|count > 0}
        <!-- filtro produtos -->
        {*<a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-products">*}
        {*<span class="icon-arrow"></span>*}
        {*</a>*}
        <div class="menu-title">
            <div class="left-menu-item">
                <span class="menu-name">Produtos</span>
            </div>
        </div>
        <ul class="sub-menu filter-by-products">
            <li class="sub-menu-item">
                <h2><a rel="nofollow" href="{$this->url([], 'novidades', TRUE)}" class="sub-menu-link" style="color: #5fbf98;">Novidades</a></h2>
            </li>
            <li class="sub-menu-item">
                <h2><a rel="nofollow" href="{$this->url([], 'sale', TRUE)}" class="sub-menu-link c-orange">Sale</a></h2>
            </li>

            {foreach from=$tipos item=tipo}
                <li class="sub-menu-item">
                    {if $tipo_url eq $tipo['NR_SEQ_CATEGPRO_PTRC']}
                        <h2><span class="sub-menu-link active">{$tipo['DS_CATEGORIA_PTRC']}</span></h2>
                    {else}
                        <h2><a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">{$tipo['DS_CATEGORIA_PTRC']}</a></h2>
                    {/if}
                </li>
            {/foreach}
        </ul>
    {/if}

    {if $cores|count > 0}
        <!-- filtro cores -->
        <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-colors">
            <span class="icon-arrow"></span>
        </a>
        <div class="menu-title">
            <div class="left-menu-item">
                <span class="menu-name">Cores</span>
            </div>
        </div>
        <ul class="sub-menu filter-by-colors">
            {if $tem_preto eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 1}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir black">Preto</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>1, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir black">Preto</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_cinza eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 2}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir gray">Cinza</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>2, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir gray">Cinza</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_branco}
                <li class="sub-menu-item">
                    {if $cor_url eq 3}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir white">Branco</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>3, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir white">Branco</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_azul eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 7}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir light-blue">Azul Claro</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>7, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir light-blue">Azul claro</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_vermelho eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 4}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir red">Vermelho</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>4, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir red">Vermelho</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_amarelo eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 5}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir yellow">Amarelo</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>5, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir yellow">Amarelo</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_creme eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 11}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir cream">Creme</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>11, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir cream">Creme</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_laranja eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 6}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir green">Verde</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>6, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir green">Verde</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_marrom eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 8}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir brown">Marrom</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>8, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir brown">Marrom</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_laranja eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 10}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir orange">Laranja</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>10, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir orange">Azul Marinho</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_roxo eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 9}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir purple">Roxo</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>9, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir purple">Roxo</span>
                        </a>
                    {/if}
                </li>
            {/if}
            {if $tem_rosa eq 1}
                <li class="sub-menu-item">
                    {if $cor_url eq 12}
                        <span class="sub-menu-link ui-button active">
                        <span class="color ir purplepink">Rosa</span>
                    </span>
                    {else}
                        <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>12, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
                            <span class="color ir pink">Rosa</span>
                        </a>
                    {/if}
                </li>
            {/if}
        </ul>
    {/if}
    <!-- filtro temas -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-themes">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Temas</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-themes">
        {foreach from=$categorias item=cat}
            <li class="sub-menu-item">
                {if $cat_url eq $cat['NR_SEQ_CATEGPRO_PCRC']}
                    <h2><span class="sub-menu-link active">{$cat['DS_CATEGORIA_PCRC']}</span></h2>
                {else}
                    <h2><a href="{$this->url(["categoria"=>{$cat['NR_SEQ_CATEGPRO_PCRC']}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">{$cat['DS_CATEGORIA_PCRC']}</a></h2>
                {/if}
            </li>
        {/foreach}
    </ul>

    <!-- filtro modelagem -->
    {*<a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-model">*}
    {*<span class="icon-arrow"></span>*}
    {*</a>*}
    {*<div class="menu-title">*}
    {*<div class="left-menu-item">*}
    {*<span class="menu-name">Modelagem</span>*}
    {*</div>*}
    {*</div>*}
    {*<ul class="sub-menu filter-by-model">*}
    {*{foreach from=$categorias item=cat}*}
    {*<li class="sub-menu-item">*}
    {*{if $cat_url eq $cat['NR_SEQ_CATEGPRO_PCRC']}*}
    {*<h2><span class="sub-menu-link active">{$cat['DS_CATEGORIA_PCRC']}</span></h2>*}
    {*{else}*}
    {*<h2><a href="{$this->url(["categoria"=>{$cat['NR_SEQ_CATEGPRO_PCRC']}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">{$cat['DS_CATEGORIA_PCRC']}</a></h2>*}
    {*{/if}*}
    {*</li>*}
    {*{/foreach}*}
    {*</ul>*}

    <p class="full-strip"><a rel="nofollow" href="{$this->url([], "{$acaoAtual}", TRUE)}">Limpar filtros</a></p>
</div>

<script>
    $(function() {
        $("#slide-green").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [ 75, 300 ],
            slide: function( event, ui ) {
                $( "#range-min" ).val( "R$ " + ui.values[ 0 ]);
                $( "#range-max" ).val( "R$ " + ui.values[ 1 ]);

            }
        });
        $( "#range-min" ).val( "R$ " + $( "#slide-green" ).slider( "values", 0 ));
        $( "#range-max" ).val( "R$ " + $( "#slide-green" ).slider( "values", 1 ));
    });
</script>