<div class="banners-advertisement cycle-slideshow"
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
              <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {else}
              <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {/if}
        </a>
    {/foreach}
</div>

<h1 class="rvb-title">Imprensa</h1>

<form action="{$this->url([], 'imprensa', TRUE)}" id="search-imprensa-form" method="post">
    <div class="input-text">
        <input placeholder="Data - DD/MM/AAAA" type="search" name="search-date">
        <input placeholder="Informe um título" class="search-input" type="search" name="search-text">
    </div>
    <div class="send-button search-icon">
        <button class="search-icon ir" type="submit">Pesquisar</button>
    </div>
</form>
<ul class="news-media-collection">
  {assign var="i" value=0}
  {foreach from=$contadores item=contador}
    <li class="media-item" id="{$contador->idimprensa}">
        <div class="images-gallery">
          {assign var="imagem" value=$contador['imagem_path']}
          {if file_exists("arquivos/uploads/imprensa/$imagem")}
            <a class="imprensa-lgb imprensa-lgb-{$i}" href="{$this->Url(['tipo'=>"imprensa", 'crop'=>1, 'largura'=>700, 'altura'=>600, 'imagem'=>$contador['imagem_path']],"imagem", TRUE)}">
              <p>
                Ver todas as imagens
              </p>
              <img src="{$this->Url(['tipo'=>"imprensa", 'crop'=>1, 'largura'=>220, 'altura'=>180, 'imagem'=>$contador['imagem_path']],"imagem", TRUE)}" alt="{$contador['titulo']}">
            </a>
          {else}
            <a class="imprensa-lgb imprensa-lgb-{$i}" href="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>700, 'altura'=>600, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}">
              <p>
                Ver todas as imagens
              </p>
              <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>180, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$contador['titulo']}">
            </a>
          {/if}
          {if $contador['imagem_path2'] neq ""}

           <a class="hidden imprensa-lgb-{$i}" href="{$this->Url(['tipo'=>"imprensa", 'crop'=>1, 'largura'=>700, 'altura'=>600, 'imagem'=>$contador['imagem_path2']],"imagem", TRUE)}"></a>
          {/if}
          {if $contador['imagem_path3'] neq ""}
           <a class="hidden imprensa-lgb-{$i}" href="{$this->Url(['tipo'=>"imprensa", 'crop'=>1, 'largura'=>700, 'altura'=>600, 'imagem'=>$contador['imagem_path3']],"imagem", TRUE)}"></a>
          {/if}
        </div>

        <h2 class="media-title">{$contador['titulo']}</h2>
        <p class="media-date">{$contador['data_post']|date_format:"%d de %b de %Y"}</p>
        <div class="media-descr">{$contador['post']}</div>
        {include file="share-buttons.tpl"}
    </li>
    {assign var="i" value=i+1}
  {/foreach}
</ul>
<div id="paginacao" class="posreflole">
  <ul>
    {if $pages.previous}
      <li class="tofirst">
          <a class="linkpagination" title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"index", "action"=>"impresa", "page"=>{$pages.previous}], "imprensa", TRUE)}"></a>
      </li>
    {/if}
    {section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}
      <li>
        <a class="linkpagination" href="{$this->url(["module"=>"default","controller"=>"index",  "action"=>"impresa", "page"=>$smarty.section.page_loop.index+1], 'imprensa', TRUE)}">
          {$smarty.section.page_loop.index+1}
        </a>
      </li>
    {/section}
    {if $pages.next}
      <li class="tolast">
        <a class="linkpagination" title="Próxima Página" href="{$this->url(["module"=>"default", "controller"=>"index", "action"=>"impresa", "page"=>{$pages.next}], "imprensa", TRUE)}">></a>
      </li>
    {/if}
  </ul>
</div>
</div>

{include file="lightbox-indique.tpl"}

{literal}
<script type="text/javascript" async src="//platform.twitter.com/widgets.js"></script>
<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
{/literal}

