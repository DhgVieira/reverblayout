<div class="sidebar-ui">
    <ul class="socials-network-dark">
        <li><a href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>
        <li><a href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>
        <li><a href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>
        <li><a href="http://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>
        <li><a href="http://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>
        <li class="last"><a href="https://plus.google.com/+reverbcity/posts" target="_blank" class="icon rss ir">Google Plus</a></li>
    </ul>
    <div class="box-promo_dia">
        {assign var="foto" value="{$_produto_dia->NR_SEQ_PRODUTO_PRRC}"}
        {assign var="extensao" value="{$_produto_dia->DS_EXT_PRRC}"}
        {assign var="foto_completa_dia" value="{$foto}.{$extensao}"}
        
        {assign var="fotos" value=$this->fotoproduto($_produto_dia->NR_SEQ_PRODUTO_PRRC)}
        {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
        {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
        {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

        <a href="{$this->url(["titulo"=>{$this->createslug($_produto_dia->DS_PRODUTO_PRRC)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" class="product-photo">
            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$foto_completa_dia],'imagem', TRUE)}" alt="{$_produto_dia->DS_PRODUTO_PRRC}">
        </a>
        <span class="promocao_dia">Promoção do Dia</span>

    </div>

    <p class="full-strip">Categorias</p>
    <ul class="collection-categories">
        {foreach from=$categorias item=categoria}
            <li><a href="{$this->url(["categoria"=>$categoria->NR_SEQ_BLOGCAT_BCRC, "titulo"=>$this->createslug($categoria->DS_CATEGORIA_BCRC)], "blog", TRUE)}">{$categoria->DS_CATEGORIA_BCRC|truncate:30:"...":TRUE}</a></li>
        {/foreach}
        <!-- <li><a href="#">veja mais +</a></li> -->
    </ul>

    <p class="full-strip">Fórum</p>
    <ul class="collection-posts">
         {foreach from=$foruns item=forum}
            <li class="post-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($forum->DS_TOPICO_TOSO)}, "idforum"=>{$forum->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}" class="post-link">
                    <span class="period">{$forum->DT_CADASTRO_TOSO|date_format:'%d/%m'} | </span>
                    <span class="title">{$forum->DS_TOPICO_TOSO|truncate:25:"...":TRUE}</span>
                </a>
            </li>
        {/foreach}
    </ul>

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
            <a href="{$banner['DS_LINK_BARC']}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                  <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
                {else}
                  <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
                {/if}
            </a>
            {/foreach}
    </div>
   
</div>


