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
<h1 class="rvb-title">Resultado da busca por “{$palavra}”</h1>
{if count($arr1) eq 0 and count($arr2) eq 0 and count($arr3) eq 0 and count($arr4) eq 0 and count($arr5) eq 0}
<div id="empty-result">

    <img src="{$basePath}/arquivos/default/images/empty-result.png" alt="Página não encontrada" />

    <p class="visuallyhidden">
        Hey, não encontramos
        nada relacionado com a
        busca que você digitou... :(
        Tente novamente e tenha
        certeza que digitou
        tudo certo.. 
    </p>
</div>
{/if}

{if count($arr1)}
<div class="rvb-column left tudo">
    <p class="full-strip">Produtos</p>
    <ul class="rvb-collection-of-products">
     {foreach from=$arr1 item=resultItem}
     {assign var="foto" value="{$resultItem['id']}"}
     {assign var="extensao" value="{$resultItem['extencao']}"}
     {assign var="foto_completa" value="{$foto}.{$extensao}"}
     {if $_tipo == 'PJ'}
         {assign var=rotaProduto value='produtolojista'}
     {else}
         {assign var=rotaProduto value='produto'}
     {/if}
        <li class="rvb-product-item">
            {assign var="fotos" value=$this->fotoproduto($resultItem['id'])}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
            
            {if !file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
            {/if}

            {if $resultItem['NR_SEQ_TIPO_PRRC'] == 6}
                {assign var=preTitle value='camiseta '}
            {else}
                {assign var=preTitle value=''}
            {/if}

            {assign var=ds_produto_prrc value=' - '|explode:$resultItem['titulo']}
            {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}
            
            <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$resultItem['id']}], $rotaProduto, TRUE)}" class="product-photo">
                {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$produto->titulo}" data-title="{$resultado['titulo']}">
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>$foto_completa],'imagem', TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>140,'altura'=>156,'imagem'=>$foto_completa],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$produto->titulo}">
                        </noscript>
                    </span>
                {else}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$produto->titulo}" data-title="{$resultado['titulo']}">
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>140,'altura'=>156,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$produto->titulo}">
                        </noscript>
                    </span>
                {/if}
                <span class="rvb-tag"></span>
            </a>
            <h2 class="product-name">{$resultItem['titulo']|truncate:24:"...":TRUE}</h2>
            <p class="price"</p>

            <p class="price">
                {if $resultItem['extra'] neq 0}
                  <del>R$ {$resultItem['valor']|number_format:2:",":"."}</del>
                  por R$ {$resultItem['extra']|number_format:2:",":"."}
                {else}
                   R$ {$resultItem['valor']|number_format:2:",":"."}
                {/if}
            </p>
        </li>
      {/foreach}
    </ul>
</div>
{/if}
{if count($arr6)}
<div class="rvb-column left tudo">
    <p class="full-strip">Classics</p>
    <ul class="rvb-collection-of-products">
     {foreach from=$arr6 item=resultItem}
     {assign var="foto" value="{$resultItem['id']}"}
     {assign var="extensao" value="{$resultItem['extencao']}"}
     {assign var="foto_completa" value="{$foto}.{$extensao}"}
     
     {assign var="fotos" value=$this->fotoproduto($resultItem['id'])}
    {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
    {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
    {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

        <li class="rvb-product-item">
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])},"idproduto"=>{$resultItem['id']}], 'classic', TRUE)}" class="product-photo">
                {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa") && $foto_completa != '.'}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$produto->titulo}" data-title="{$resultado['titulo']}">
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>$foto_completa],'imagem', TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>140,'altura'=>156,'imagem'=>$foto_completa],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$produto->titulo}">
                        </noscript>
                    </span>
                {else}
                    {if file_exists("arquivos/uploads/produtos/{$resultItem['id']}.{$extensao_produto}")}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$produto->titulo}" data-title="{$resultado['titulo']}">
                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>"{$resultItem['id']}.{$extensao_produto}"],'imagem', TRUE)}"></span>

                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1,'largura'=>140,'altura'=>156,'imagem'=>"{$resultItem['id']}.{$extensao_produto}"],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>"{$resultItem['id']}.{$extensao_produto}"],'imagem', TRUE)}" alt="{$produto->titulo}">
                            </noscript>
                        </span>
                    {else}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$produto->titulo}" data-title="{$resultado['titulo']}" data="{$foto_completa}">
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>140,'altura'=>156,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$produto->titulo}">
                        </noscript>
                    </span>
                    {/if}
                {/if}
                <span class="rvb-tag" data-fotoTeste="{$resultItem['id']}.{$extensao_produto}"></span>
            </a>
            <h2 class="product-name">{utf8_decode($resultItem['titulo']|truncate:24:"...":TRUE)}</h2>
        </li>
      {/foreach}
    </ul>
</div>
{/if}
{if count($arr2)}
<div class="rvb-column left tudo">
    <p class="full-strip">Cycle</p>
    <ul class="rvb-collection-of-products">
        {foreach from=$arr2 item=resultItem}
        {assign var="foto" value="{$resultItem['id']}"}
        {assign var="extensao" value="{$resultItem['extencao']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        
        {*{assign var="fotos" value=$this->fotoproduto($resultItem['id'])}*}
        {*{assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}*}
        {*{assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}*}
        {*{assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}*}

        {*{if !file_exists("arquivos/uploads/reverbcycle/$foto_completa")}*}
            {*{assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}*}
            {*{assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}*}
            {*{assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}*}
        {*{/if}*}
        
        <li class="rvb-product-item">
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idcycle"=>{$resultItem['id']}], 'cycledetalhe', TRUE)}" class="product-photo">
                {if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$resultItem['titulo']}" data-title="{$resultItem['titulo']}">
                        <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>170, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>140, 'altura'=>156, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$resultItem['titulo']}">
                        </noscript>
                    </span>
                {else}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$resultItem['titulo']}" data-title="{$resultItem['titulo']}">
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>140,'altura'=>156,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$resultItem['titulo']}">
                        </noscript>
                    </span>
                {/if}
                <span class="rvb-tag"></span>
            </a>
            <h2 class="product-name">{$resultItem['titulo']|truncate:24:"...":TRUE}</h2>
            {if $resultItem['valor'] > 0}
                <p class="price">R$ {$resultItem['valor']|number_format:2:",":"."}</p>
            {/if}
        </li>
        {/foreach}
    </ul>
</div>
{/if}

<!-- {if count($arr3)}
<div class="rvb-column left tudo">
    <p class="full-strip">Reverbme</p>
    <ul class="rvb-collection-of-products">
        {foreach from=$arr3 item=resultItem}
        {assign var="foto" value="{$resultItem['id']}"}
        {assign var="extensao" value="{$resultItem['extencao']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <li class="rvb-product-item">
            <a href="{$this->url(["nome"=>{$this->createslug($resultItem['titulo'])}, "idperfil"=>{$resultItem['id']}], 'perfil', TRUE)}" class="product-photo">
                {if file_exists("arquivos/uploads/reverbme/$foto_completa")} -->
                    <!-- Polyfill para imagens responsivas-->
                    <<!-- span data-picture data-alt="{$resultItem['titulo']}" data-title="{$resultItem['titulo']}">
                        <span data-src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>170, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>140, 'altura'=>156, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$resultItem['titulo']}">
                        </noscript>
                    </span>

                {else} -->
                    <!-- Polyfill para imagens responsivas-->
                    <<!-- span data-picture data-alt="{$resultItem['titulo']}" data-title="{$resultItem['titulo']}">
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"></span>

                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>140,'altura'=>156,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>170,'altura'=>190,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$resultItem['titulo']}">
                        </noscript>
                    </span>
                {/if}
                <span class="rvb-tag"></span>
            </a>
            <h2 class="product-name">{$resultItem['titulo']}</h2>

        </li>
        {/foreach}
    </ul>
</div>
{/if} -->
{if count($arr4)}
<div class="rvb-column left blog-after">
    <p class="full-strip">Blog</p>
    <ul class="rvb-collection-of-posts">
        {foreach from=$arr4 item=resultItem}
        {assign var="foto" value="{$resultItem['id']}"}
        {assign var="extensao" value="{$resultItem['extencao']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <li class="rvb-post-item">
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idpost"=>{$resultItem['id']}], 'post', TRUE)}" class="post-photo">
                {if file_exists("arquivos/uploads/blog/$foto_completa")}
                    <img alt="{$resultItem['titulo']}" src="{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>160, 'altura'=>145, 'imagem'=>$foto_completa],"imagem", TRUE)}">
                {else}
                    <img alt="{$resultItem['titulo']}" src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>160, 'altura'=>145, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}">
                {/if}
            </a>
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idpost"=>{$resultItem['id']}], 'post', TRUE)}" class="post-title">{$resultItem['titulo']}</a>
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idpost"=>{$resultItem['id']}], 'post', TRUE)}" class="post-comments"></a>
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idpost"=>{$resultItem['id']}], 'post', TRUE)}" class="post-date">{$resultItem['data_cadastro']|date_format:"%d/%m/%Y"} as  {$resultItem['data_cadastro']|date_format:"%H:%M"} hrs <span class="author"></span></a>
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idpost"=>{$resultItem['id']}], 'post', TRUE)}" class="post-description">{$resultItem['valor']|strip_tags|truncate:350:"...":TRUE}</a>
            <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idpost"=>{$resultItem['id']}], 'post', TRUE)}" class="post-button">Ler post completo</a>
        </li>
        {/foreach}
    </ul>
</div>
{/if} 
{if count($arr5)}
<div class="rvb-column right forum">
    <p class="full-strip">Forum</p>
    <table class="rvb-collection-of-topics">
        <tbody>
            {foreach from=$arr5 item=resultItem}
            <tr class="row-content">
                <td class="rvb-table-lists-item content topic">
                    <a class="post" href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idforum"=>{$resultItem['id']}], 'detalheforum', TRUE)}">{$resultItem['titulo']}</a>
                </td>
                <td class="rvb-table-lists-item content">
                    <a href="{$this->url(["titulo"=>{$this->createslug($resultItem['titulo'])}, "idforum"=>{$resultItem['id']}], 'detalheforum', TRUE)}">{$resultItem['data_cadastro']|date_format:"%d/%m/%Y"}</a>
                </td>
                <td class="rvb-table-lists-item content">{$resultItem['valor']}</td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
{/if}

