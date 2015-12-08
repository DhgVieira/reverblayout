
<div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="false"
    data-cycle-pause-on-hover="true" style="margin-bottom:10px;">
        {foreach from=$banners_topo item=banner}
        {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
        {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <a href="{$banner->DS_LINK_BARC}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                    <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {else}
                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {/if}
            </a>
        {/foreach}
    </div>
  <h1 class="rvb-title">Vale <span>presente</span></h1>
<section class="products">
  <div class="rvb-column center">
    <p>
      Nada mais chato do que presentear alguém e a pessoa ficar com aquela cara de "ah, legal",
      não é mesmo? Então deixe ela mesmo escolher, dando o vale-presente da Reverbcity!
    </p>
    <ul class="gift-cards-collection">
      {foreach from=$vale_presentes item=vale}
        {assign var="foto" value="{$vale->NR_SEQ_PRODUTO_PRRC}"}
        {assign var="extensao" value="{$vale->DS_EXT_PRRC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        
        {*{assign var="fotos" value=$this->fotoproduto($vale->NR_SEQ_PRODUTO_PRRC)}
        {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
        {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
        {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}*}
        <li class="gift-item">
            {if file_exists("arquivos/uploads/produtos/$foto_completa")}
             <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>2, 'largura'=>193, 'altura'=>146, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$vale->DS_PRODUTO_PRRC}">
            {else}
             <img src="{$this->Url(['tipo'=>"error", 'crop'=>2, 'largura'=>193, 'altura'=>146, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$vale->DS_PRODUTO_PRRC}">
            {/if}
            <div class="gift-price">
              <span class="small">R$</span>
              {$vale->VL_PRODUTO_PRRC|number_format:2:",":"."}
            </div>
            <div class="send-button">
                <a href="{$this->url(["idproduto"=>{$vale->NR_SEQ_PRODUTO_PRRC}], 'adicionarcarrinho', TRUE)}" class="btn">Comprar</a>
            </div>
        </li>
      {/foreach}
    </ul>
  </div>

  {*<div class="rvb-column right">*}
    {*<div class="sidebar-ui">*}

      {*<ul class="socials-network-dark">*}
        {*<li><a href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>*}
        {*<li><a href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>*}
        {*<li><a href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>*}
        {*<li><a href="http://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>*}
        {*<li><a href="http://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>*}
        {*<li class="last"><a href="http://reverbcity.com/rss/rss.php" class="icon rss ir">RSS</a></li>*}
      {*</ul>*}

      {*<div class="fundo-verde">*}
          {*<form id="form-login-reverbme" method="post" action="{$this->url([], 'login', TRUE)}">*}
              {*<p class="legend">Reverbme</p>*}
              {*<div class="input-txt">*}
                  {*<input class="input-box" type="text"     name="email" placeholder="E-mail" required>*}
              {*</div>*}
              {*<div class="input-txt">*}
                  {*<input class="input-box" type="password" name="senha" placeholder="Senha" required>*}
              {*</div>*}
              {*<div class="send-button">*}
                  {*<button type="submit" class="btn">Login</button>*}
                  {*<a class="btn" href="{$this->url([], 'reverbme', TRUE)}">Cadastre-se</a>*}
                  {*<label for="staylogged">*}
                      {*<input id="staylogged" type="checkbox"> Permanecer logado*}
                  {*</label>*}
              {*</div>*}
          {*</form>*}

          {*<ul class="reverb-people">*}
              {*{foreach from=$fotos item=foto}*}
                  {*{assign var="foto_people" value="{$foto['NR_SEQ_FOTO_FORC']}"}*}
                  {*{assign var="extensao" value="{$foto['DS_EXT_FORC']}"}*}
                  {*{assign var="foto_completa" value="{$foto_people}.{$extensao}"}*}
                  {*<li>*}
                    {*{if file_exists("arquivos/uploads/people/$foto_completa")}*}
                      {*<img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>$foto_completa],"imagem", TRUE)}"  alt="{$foto->DS_NOME_FORC}" width="45" height="45" />*}
                    {*{else}*}
                      {*<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"  alt="{$foto->DS_NOME_FORC}" width="45" height="45" />*}
                    {*{/if}*}
                  {*</li>*}
              {*{/foreach}*}
          {*</ul>*}
      {*</div>*}

      {*<div class="blog-post clearfix">*}
          {*{assign var="foto_blog" value="{$post['NR_SEQ_BLOG_BLRC']}"}*}
          {*{assign var="extensao_blog" value="{$post['DS_EXT_BLRC']}"}*}
          {*{assign var="foto_completa_blog" value="{$foto_people}.{$extensao}"}*}
          {*<p class="cover-title ir">Blog</p>*}
          {*<a class="blog-image" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">*}
              {*{if file_exists("arquivos/uploads/produtos/$foto_completa_blog")}*}
                {*<img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>$foto_completa_blog],"imagem", TRUE)}" alt="{$post->DS_TITULO_BLRC}"/>*}
              {*{else}*}
                {*<img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$post->DS_TITULO_BLRC}"/>*}
              {*{/if}*}
          {*</a>*}
          {*<p class="blog-title">*}
              {*<a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">{$post->DS_TITULO_BLRC|strip_tags}</a>*}
          {*</p>*}
          {*<p class="authoring">*}
            {*<!-- <span class="period">Tem que trazer o post aqui ás 14h</span> -->*}
            {*Por: <strong>Reverbcity</strong>*}
          {*</p>*}
          {*<p class="tiny-post">{utf8_decode($post->DS_TEXTO_BLRC|strip_tags|truncate:130:"...":true)}</p>*}
          {*<div class="full-post clearfix">*}
              {*<a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">Ler post completo</a>*}
          {*</div>*}
      {*</div>*}
    {*</div>*}
  {*</div>*}
</section>
