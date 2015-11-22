{if $currentAction eq "index"} 
{assign var="acaoAtual" value="loja"}
{else}
{assign var="acaoAtual" value=$currentAction}
{/if}

<div id="filters" class="mobile-action-box hidden">
    <p class="full-strip">Filtros</p>
    <div class="clearfix"></div>
    <!-- filtro de valores -->
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
            <a rel="nofollow" href="#" class="sub-menu-link">
                Até R$29,90
            </a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="#" class="sub-menu-link">
                De R$ 30 a 60
            </a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="#" class="sub-menu-link">
                De R$ 61 a 90
            </a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="#" class="sub-menu-link">
                A partir de R$ 90
            </a>
        </li>
    </ul>
    <div class="clearfix"></div>
    <!-- filtro produtos -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-products">
        <span class="icon-arrow"></span>
    </a>
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
            <h2><a rel="nofollow" href="{$this->url([], 'sale', TRUE)}" class="sub-menu-link">Sale</a></h2>
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
        {*{foreach from=$_categorias item=cat}*}
        {*<li class="sub-menu-item">*}
            {*<a  rel="nofollow" href="{$this->url(["categoria"=>{$cat['NR_SEQ_CATEGPRO_PCRC']}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link">{utf8_decode($cat['DS_CATEGORIA_PCRC'])}</a>*}
        {*</li>*}
        {*{/foreach}*}
    </ul>
    <div class="clearfix"></div>
    <!-- filtro gênero -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-gender">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Gênero</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-gender">
        <li class="sub-menu-item">
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>masculino, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link">Masculino</a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>feminino, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link">Feminino</a>
        </li>
    </ul>
    <div class="clearfix"></div>
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
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>pp, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link ui-button">PP</a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>p, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link ui-button">P</a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>m, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link ui-button">M</a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>g, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link ui-button">G</a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>gg, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link ui-button">GG</a>
        </li>
        <li class="sub-menu-item">
            <a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>xgg, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}], "todos-produtos", TRUE)}" class="sub-menu-link ui-button">XGG</a>
        </li>
    </ul>
    <div class="clearfix"></div>
    <!-- filtro cores -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-colors">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Cores</span>
        </div>
    </div>
    {*<ul class="sub-menu filter-by-colors">*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 1}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir black">Preto</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>1, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir black">Preto</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 2}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir gray">Cinza</span>*}
                {*</span>*}
            {*{else}*}
                {*<a href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>2, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir gray">Cinza</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 3}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir white">Branco</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>3, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir white">Branco</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 7}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir light-blue">Azul Claro</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>7, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir light-blue">Azul claro</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 4}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir red">Vermelho</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>4, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir red">Vermelho</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 5}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir yellow">Amarelo</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>5, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir yellow">Amarelo</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 5}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir cream">Creme</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>5, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir cream">Creme</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 6}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir green">Verde</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>6, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir green">Verde</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 8}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir brown">Marrom</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>8, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir brown">Marrom</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 1}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir orange">Laranja</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>9, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir orange">Laranja</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 10}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir purple">Roxo</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>10, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir purple">Roxo</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
        {*<li class="sub-menu-item">*}
            {*{if $cor_url eq 10}*}
                {*<span class="sub-menu-link ui-button active">*}
                    {*<span class="color ir purplepink">Rosa</span>*}
                {*</span>*}
            {*{else}*}
                {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>10, "tipo"=>{$tipo_url}], "{$acaoAtual}", TRUE)}" class="sub-menu-link ui-button">*}
                    {*<span class="color ir pink">Rosa</span>*}
                {*</a>*}
            {*{/if}*}
        {*</li>*}
    {*</ul>*}
    <div class="clearfix"></div>
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
        {*{foreach from=$_tipos item=tipo}*}
        {*<li class="sub-menu-item">*}
            {*<a rel="nofollow" href="{$this->url(["categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}], "todos-produtos", TRUE)}" class="sub-menu-link">{utf8_decode($tipo['DS_CATEGORIA_PTRC'])}</a>*}
        {*</li>*}
        {*{/foreach}*}
    </ul>
    <div class="clearfix"></div>
    <a rel="nofollow" href="{$basePath}/todos-produtos" class="full-strip black">
        Limpar filtros
    </a>
</div>