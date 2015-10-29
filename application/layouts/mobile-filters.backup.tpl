{if $currentAction eq "index"} 
{assign var="acaoAtual" value="loja"}
{else}
{assign var="acaoAtual" value=$currentAction}
{/if}

<div id="filters" class="mobile-action-box hidden">
    <p class="full-strip">Filtros</p>
    <div class="clearfix"></div>
    <!-- filtro produtos -->
    <a class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-products">
    <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Produtos</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-products">
        {foreach from=$categorias item=cat}
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat['NR_SEQ_CATEGPRO_PCRC']}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">{utf8_decode($cat['DS_CATEGORIA_PCRC'])}</a>
        </li>
        {/foreach}
    </ul>
    <!-- filtro gênero -->
    <a class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-gender">
    <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Gênero</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-gender">
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>masculino, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">Masculino</a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>feminino, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">Feminino</a>
        </li>
    </ul>
    <!-- filtro tamanhos -->
    <a class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-sizes">
    <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Tamanhos</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-sizes">
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>pp, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">PP</a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>p, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">P</a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>m, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">M</a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>g, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">G</a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>gg, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">GG</a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>xgg, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">XGG</a>
        </li>
    </ul>
    <!-- filtro cores -->
    <a class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-colors">
    <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Cores</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-colors">
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>1, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir black">Preto</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>2, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir gray">Cinza</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>3, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir white">Branco</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>7, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir light-blue">Azul</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>6, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir green">Verde</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>8, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir brown">Marrom</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>10, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir orange">Laranja</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>4, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir red">Vermelho</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>5, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir yellow">Amarelo</span>
            </a>
        </li>
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>9, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">
            <span class="color ir pink">Roxo</span>
            </a>
        </li>
    </ul>
    <!-- filtro temas -->
    <a class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-themes">
    <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Temas</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-themes">
        {foreach from=$tipos item=tipo}
        <li class="sub-menu-item">
            <a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}], "{$acaoAtual}", TRUE)}" class="sub-menu-link">{utf8_decode($tipo['DS_CATEGORIA_PTRC'])}</a>
        </li>
        {/foreach}
    </ul>
    <a href="{$basePath}/loja/page/1/categoria//tamanho//genero//cor" class="full-strip black">
        Limpar filtros
    </a>
</div>