<div class="sidebar-ui">
    
        <!-- <a href="#" class="chat-button ir">Atendimento Lojista On-Line</a> -->
   

    {*<ul class="socials-network-dark">*}
        {*<li><a rel="nofollow" href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>*}
        {*<li><a rel="nofollow" href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>*}
        {*<li><a rel="nofollow" href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>*}
        {*<li><a rel="nofollow" href="http://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>*}
        {*<li><a rel="nofollow" href="http://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>*}
        {*<li class="last"><a rel="nofollow" href="https://plus.google.com/+reverbcity/posts" target="_blank" class="icon rss ir">Google Plus</a></li>*}
    {*</ul>*}

    <div class="fundo-verde">
        <form id="form-login-reverbme" method="post" action="{$this->url([], 'login', TRUE)}">
            <p class="legend">Reverbme</p>
            <div class="input-txt">
                <input class="input-box" type="text"     name="email" placeholder="E-mail" required>
            </div>
            <div class="input-txt">
                <input class="input-box" type="password" name="senha" placeholder="Senha" required>
            </div>
            <div class="send-button">
                <button type="submit" class="btn">Login</button>
                <a class="btn" href="{$this->url([], 'reverbme', TRUE)}">Cadastre-se</a>
                <label for="staylogged">
                    <input id="staylogged" type="checkbox" name="manter_logado" value="1"> Permanecer logado
                </label>
            </div>
        </form>

        <ul class="reverb-people">
            {foreach from=$fotos item=foto}
                {assign var="foto_people" value="{$foto['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao" value="{$foto['DS_EXT_FORC']}"}
                {assign var="foto_completa" value="{$foto_people}.{$extensao}"}
                <li><img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>$foto_completa],
                                        "imagem", TRUE)}"  alt="{$foto->DS_NOME_FORC}" width="45" height="45" /></li>
            {/foreach}
        </ul>
    </div>

    <div class="blog-post clearfix">
        {assign var="foto_blog" value="{$post['NR_SEQ_BLOG_BLRC']}"}
        {assign var="extensao_blog" value="{$post['DS_EXT_BLRC']}"}
        {assign var="foto_completa_blog" value="{$foto_people}.{$extensao}"}
        <p class="cover-title ir">Blog</p>
        <a rel="nofollow" class="blog-image" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">
            {if file_exists("arquivos/uploads/blog/$foto_completa_blog")}
                <img src="{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>$foto_completa_blog],"imagem", TRUE)}" alt="{$post->DS_TITULO_BLRC}"/>
            {else}
                <img src="..\arquivos\default\images\sem_foto_blog.jpg" alt="{$post->DS_TITULO_BLRC}" title="{$post->DS_TITULO_BLRC}" width="220" height="110"/>
            {/if}
        </a>
        <p class="blog-title 1">
            <a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">{utf8_encode($post->DS_TITULO_BLRC)|strip_tags}</a>
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

</div>


