<div class="sidebar-ui">
    
        <!-- <a href="#" class="chat-button ir">Atendimento Lojista On-Line</a> -->
        <div style="text-align:center;width:219px;">
</div>

    {*<ul class="socials-network-dark">*}
        {*<li><a rel="nofollow" href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>*}
        {*<li><a rel="nofollow" href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>*}
        {*<li><a rel="nofollow" href="https://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>*}
        {*<li><a rel="nofollow" href="https://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>*}
        {*<li><a rel="nofollow" href="https://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>*}
        {*<li class="last"><a rel="nofollow" href="https://plus.google.com/+reverbcity/posts" target="_blank" class="icon rss ir">Google Plus</a></li>*}
    {*</ul>*}

    <div class="fundo-verde">
        <div id="load-login-sidebar"></div>

        <ul class="reverb-people">
            {foreach from=$fotosme item=foto}
                {assign var="foto_people" value="{$foto['NR_SEQ_CADASTRO_CASO']}"}
                {assign var="extensao" value="{$foto['DS_EXT_CACH']}"}
                {assign var="foto_completa" value="{$foto_people}.{$extensao}"}
                <li><img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>$foto_completa],
                                        "imagem", TRUE)}"  alt="{$foto['DS_NOME_CASO']}" width="43" height="45" /></li>
            {/foreach}
        </ul>
    </div>

    <div class="blog-post clearfix">
        {assign var="foto_blog" value="{$post->NR_SEQ_BLOG_BLRC}"}
        {assign var="extensao_blog" value="{$post->DS_EXT_BLRC}"}
        {assign var="foto_completa_blog" value="{$foto_blog}.{$extensao_blog}"}
        <p class="cover-title ir">Blog</p>
        <a class="blog-image" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">
            {if file_exists("arquivos/uploads/blog/$foto_completa_blog")}
                <img src="{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>$foto_completa_blog],"imagem", TRUE)}" alt="{$post->DS_TITULO_BLRC}"/>
            {else}
                <img src="..\arquivos\default\images\sem_foto_blog.jpg" alt="{$post->DS_TITULO_BLRC}" title="{$post->DS_TITULO_BLRC}" width="220" height="110"/>
            {/if}
        </a>
        <p class="blog-title 1">
            <a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">{$post->DS_TITULO_BLRC|strip_tags}</a>
        </p>
        <p class="authoring">
          <span class="period">{$post->DT_PUBLICACAO_BLRC|date_format:'%Y/%m/%d'} ás {$post->DT_PUBLICACAO_BLRC|date_format:"%H:%M"}h</span>
          Por: <strong>Reverbcity</strong>
        </p>
        <p class="tiny-post">{$post->DS_TEXTO_BLRC|strip_tags|truncate:130:"...":true}</p>
        <div class="full-post clearfix">
            <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">Ler post completo</a>
        </div>
    </div>

    <p class="full-strip forum">Fórum</p>
    <ul class="collection-posts">
        {foreach from=$foruns item=forum key=key}
            {if $_logado != 1 and $key == 16}
                {break}
            {/if}
            <li class="post-item">
                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($forum->DS_TOPICO_TOSO)}, "idforum"=>{$forum->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}" class="post-link">
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
              <a rel="nofollow" href="{$banner['DS_LINK_BARC']}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                  <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"
                  />
                {else}
                  <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
                {/if}
              </a>
          {/foreach}
    </div>
</div>