{assign var="max_visitados" value="{$_visitados|count}"}
{if $max_visitados le 0}
  {assign var="max" value="4"}
  {assign var="visitado" value="0"}
{/if}

{if $max_visitados eq 1}
  {assign var="max" value="3"}
  {assign var="visitado" value="1"}
{/if}

{if $max_visitados ge 2}
  {assign var="max" value="2"}
  {assign var="visitado" value="2"}
{/if}

{if $currentAction eq "produtolojista"}
  {assign var="acao" value="produtolojista"}
{else}
  {assign var="acao" value="produto"}
{/if}

<div class="sidebar-bottom clearfix">
    <!-- Sugestoes -->
    {if $_sugestoes|count > 0}
    <div class="category-item suggestions items-{$max}">
        <p class="title-category">Sugestões</p>
        <ul class="list-of-products">
          {foreach from=$_sugestoes item=sugestao}
          {assign var="foto" value="{$sugestao->NR_SEQ_PRODUTO_PRRC}"}
          {assign var="extensao" value="{$sugestao->DS_EXT_PRRC}"}
          {assign var="foto_completa" value="{$foto}.{$extensao}"}
          
          {assign var="fotos" value=$this->fotoproduto($sugestao->NR_SEQ_PRODUTO_PRRC)}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

            {if $sugestao@iteration > $max}
              {break}
            {/if}

              {if $sugestao->NR_SEQ_TIPO_PRRC == 6}
                  {assign var=preTitle value='camiseta '}
              {else}
                  {assign var=preTitle value=''}
              {/if}

              {assign var=ds_produto_prrc value=' - '|explode:$sugestao->DS_PRODUTO_PRRC}
              {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}
            <li class="product-item">
                <a class="thumb" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">
                  {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$sugestao->DS_PRODUTO_PRRC}">
                        <!--imagem padrão-->
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$sugestao->DS_PRODUTO_PRRC}">
                        </noscript>
                    </span>
                  {else}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$sugestao->DS_PRODUTO_PRRC}">
                        <!--imagem padrão-->
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$sugestao->DS_PRODUTO_PRRC}">
                        </noscript>
                    </span>
                  {/if}

                </a>
                <p class="product-title">
                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">{$sugestao->DS_PRODUTO_PRRC}</a>
                </p>
                <p class="product-price">
                  {if $sugestao->VL_PROMO_PRRC != 0}
                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$sugestao->VL_PROMO_PRRC|number_format:2:",":"."}</a>
                  {else}
                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$sugestao->VL_PRODUTO_PRRC|number_format:2:",":"."}</a>
                  {/if}
                </p>
            </li>
          {/foreach}
        </ul>
    </div>
    {/if}

    {if $_visitados|count > 0}
    <div class="category-item visited items-{$visitado}">
        <p class="title-category">Produtos vistos</p>
        <ul class="list-of-products">
            {capture}{$_visitados|@shuffle}{/capture}

            {foreach from=$_visitados item=visitado}

            {assign var="foto" value="{$visitado['codigo']}"}
            {assign var="extensao" value="{$visitado['path']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            {assign var="max" value="2"}
            
            {assign var="fotos" value=$this->fotoproduto($visitado['codigo'])}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

            {if $visitado@iteration > $max}
              {break}
            {/if}

                {if $visitado['tipo'] == 6}
                    {assign var=preTitle value='camiseta '}
                {else}
                    {assign var=preTitle value=''}
                {/if}

                {assign var=ds_produto_prrc value=' - '|explode:$visitado['nome']}
                {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}
            <li class="product-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}" class="thumb">
                  {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                      <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="{$visitado['nome']}">
                          <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                          <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                          <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                          <!-- for hd displays -->
                          <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                          <noscript>
                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$visitado['nome']}">
                          </noscript>
                      </span>
                  {else}
                      <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="{$visitado['nome']}">
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                          <!-- for hd displays -->
                          <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                          <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$visitado['nome']}">
                          </noscript>
                      </span>
                  {/if}
                </a>
                <p class="product-title">
                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">{utf8_decode($visitado['nome'])}</a>
                </p>
                <p class="product-price">
                  {if $visitado['promo'] != 0}
                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">R$ {$visitado['promo']|number_format:2:",":"."}</a>
                  {else}
                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">R$ {$visitado['valor']|number_format:2:",":"."}</a>
                  {/if}
                </p>
            </li>
            {/foreach}
        </ul>
    </div>
    {/if}

    <div class="category-item day">
        <p class="title-category black">Produto do dia</p>
        <ul class="list-of-products">
           {assign var="foto" value="{$_produto_dia->NR_SEQ_PRODUTO_PRRC}"}
           {assign var="extensao" value="{$_produto_dia->DS_EXT_PRRC}"}
           {assign var="foto_completa_dia" value="{$foto}.{$extensao}"}
           
            {assign var="fotos" value=$this->fotoproduto($_produto_dia->NR_SEQ_PRODUTO_PRRC)}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

            {if $_produto_dia->NR_SEQ_TIPO_PRRC == 6}
                {assign var=preTitle value='Camiseta '}
            {else}
                {assign var=preTitle value=''}
            {/if}
            {assign var=ds_produto_prrc value=' - '|explode:$_produto_dia->DS_PRODUTO_PRRC}
            {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

            <li class="product-item last">
                <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}" class="thumb">
                  {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa_dia")}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}"></span>
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>182, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                        </noscript>
                    </span>
                  {else}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>182, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                        </noscript>
                    </span>
                  {/if}
                </a>
                <p class="product-title">
                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}</a>
                </p>
                <p class="product-price">
                    {if $_produto_dia->VL_PROMO_PRRC != 0}
                        <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$_produto_dia->VL_PROMO_PRRC|number_format:2:",":"."}</a>
                    {else}
                        <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$_produto_dia->VL_PRODUTO_PRRC|number_format:2:",":"."}</a>
                    {/if}
                </p>
            </li>
        </ul>
    </div>
</div>
