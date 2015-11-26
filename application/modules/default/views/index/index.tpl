{*
<!-- <div class="banners-advertisement cycle-slideshow"
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
</div> -->

<ul id="carousel-banners" class="owl-carousel owl-theme">
  {foreach from=$banners item=banner}
    {assign var="foto" value=$banner['NR_SEQ_BANNER_BARC']}
    {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
    {assign var="foto_completa" value="{$foto}.{$extensao}"}
    <li class="item">
        <a href="{$banner['DS_LINK_BARC']}" target="_blank">
           <!--  {if file_exists("arquivos/uploads/banners/$foto_completa")}
                <img class="lazyOwl" data-src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>422,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
            {else}
                <img class="lazyOwl" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>422,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
            {/if} -->
             {if file_exists("arquivos/uploads/banners/$foto_completa")}
                <img class="lazyOwl" src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>560,'imagem'=>$foto_completa],'imagem', TRUE)}" data-src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>560,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
            {else}
                <img class="lazyOwl" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>560,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
            {/if}
            <div class="banner-hover">
                <span class="banner-hover-title">{$banner['DS_DESCRICAO_BARC']}</span> <br>

                <span class="banner-hover-btn">Clique e saiba mais</span> <br>

                <span class="banner-hover-phrase">{$banner['MSG_BANNER_BARC']}</span>
            </div>
        </a>
    </li>
  {/foreach}
</ul>
<!-- <ul id="banners-slim">
    <li class="first">
        {foreach from=$banner_1 item=menor_1}
            {assign var="foto" value="{$menor_1['NR_SEQ_BANNER_BARC']}"}
            {assign var="extensao" value="{$menor_1['DS_EXT_BARC']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <a href="{$menor_1['DS_LINK_BARC']}">
                <img alt="{$menor_1['DS_DESCRICAO_BARC']}" src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>612,'altura'=>240,'imagem'=>$foto_completa],'imagem', TRUE)}">
                <div class="banner-hover">
                    <span class="banner-hover-title">{$menor_1['DS_DESCRICAO_BARC']}</span> <br>
                    <span class="banner-hover-btn">Clique e saiba mais</span> <br>
                    <span class="banner-hover-phrase">{$menor_1['MSG_BANNER_BARC']}</span>
                </div>
            </a>
        {/foreach}
    </li>

    <li class="second">
         {foreach from=$banner_2 item=menor_2}
            {assign var="foto" value="{$menor_2['NR_SEQ_BANNER_BARC']}"}
            {assign var="extensao" value="{$menor_2['DS_EXT_BARC']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <a href="{$menor_2['DS_LINK_BARC']}">
                    <img alt="{$menor_2['DS_DESCRICAO_BARC']}" src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>289,'altura'=>240,'imagem'=>$foto_completa],'imagem', TRUE)}">
                    <div class="banner-hover">
                        <span class="banner-hover-title">{$menor_2['DS_DESCRICAO_BARC']}</span> <br>
                        <span class="banner-hover-btn">Clique e saiba mais</span> <br>
                        <span class="banner-hover-phrase">{$menor_2['MSG_BANNER_BARC']}</span>
                    </div>
                </a>
        {/foreach}
    </li>

    <li class="third">
        {foreach from=$banner_3 item=menor_3}
            {assign var="foto" value="{$menor_3['NR_SEQ_BANNER_BARC']}"}
            {assign var="extensao" value="{$menor_3['DS_EXT_BARC']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <a href="{$menor_3['DS_LINK_BARC']}">
                    <img alt="{$menor_3['DS_DESCRICAO_BARC']}" src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>392,'altura'=>255,'imagem'=>$foto_completa],'imagem', TRUE)}">
                    <div class="banner-hover">
                        <span class="banner-hover-title">{$menor_3['DS_DESCRICAO_BARC']}</span> <br>
                        <span class="banner-hover-btn">Clique e saiba mais</span> <br>
                        <span class="banner-hover-phrase">{$menor_3['MSG_BANNER_BARC']}</span>
                    </div>
                </a>
        {/foreach}
    </li>

    <li class="fourth">
        {foreach from=$banner_4 item=menor_4}
            {assign var="foto" value="{$menor_4['NR_SEQ_BANNER_BARC']}"}
            {assign var="extensao" value="{$menor_4['DS_EXT_BARC']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <a href="{$menor_4['DS_LINK_BARC']}">
                    <img alt="{$menor_4['DS_DESCRICAO_BARC']}" src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>509,'altura'=>255,'imagem'=>$foto_completa],'imagem', TRUE)}">
                    <div class="banner-hover">
                        <span class="banner-hover-title">{$menor_4['DS_DESCRICAO_BARC']}</span> <br>
                        <span class="banner-hover-btn">Clique e saiba mais</span> <br>
                        <span class="banner-hover-phrase">{$menor_4['MSG_BANNER_BARC']}</span>
                    </div>
                </a>
        {/foreach}
    </li>



</ul> -->


<!-- <div class="clearfix"></div> -->
*}
