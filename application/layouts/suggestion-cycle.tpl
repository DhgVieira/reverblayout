<div class="sidebar-bottom clearfix">
    <!-- Sugestoes -->
    {if $sugestoes|count > 0}
    <div class="category-item suggestions">
        <p class="title-category">Sugestões</p>
        <ul class="list-of-products">
          {assign var="maxcycles" value="{$cycles|count}"}
          {foreach from=$sugestoes item=sugestao}
            {assign var="foto" value="{$sugestao->NR_SEQ_REVERBCYCLE_RCRC}"}
            {assign var="extensao" value="{$sugestao->DS_EXT_RCRC}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}

            {if $maxcycles le 0}
              {assign var="max" value="4"}
            {/if}

            {if $maxcycles eq 1}
              {assign var="max" value="3"}
            {/if}

            {if $maxcycles ge 2}
              {assign var="max" value="2"}
            {/if}


            {if $sugestao@iteration > $max}
              {break}
            {/if}
              <li class="product-item">
                  <a class="thumb" href="{$this->url(["titulo"=>{$this->createslug($sugestao->DS_OBJETO_RCRC)},"idcycle"=>{$sugestao->NR_SEQ_REVERBCYCLE_RCRC}], 'cycledetalhe', TRUE)}">
                    {if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
                      <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="{$sugestao->DS_OBJETO_RCRC}">
                          <!--imagem padrão-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                          <!--imagem para 768px-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                          <!--imagem para 480px-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <!--imagem para 320px-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                          <!--imagem para javascript desativado-->
                          <noscript>
                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$sugestao->DS_OBJETO_RCRC}">
                          </noscript>
                      </span>
                    {else}
                      <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="{$sugestao->DS_OBJETO_RCRC}">
                          <!--imagem padrão-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                          <!--imagem para 768px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                          <!--imagem para 480px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <!--imagem para 320px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                          <!--imagem para javascript desativado-->
                          <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$sugestao->DS_OBJETO_RCRC}">
                          </noscript>
                      </span>
                    {/if}

                  </a>
                  <p class="product-title">
                      <a href="{$this->url(["titulo"=>{$this->createslug($sugestao->DS_OBJETO_RCRC)}, "idcycle"=>{$sugestao->NR_SEQ_REVERBCYCLE_RCRC}], 'cycledetalhe', TRUE)}">{$sugestao->DS_OBJETO_RCRC}</a>
                  </p>
              </li>
          {/foreach}
        </ul>
    </div>
    {/if}

    {if $cycles|count > 0}
    <div class="category-item visited">
        <p class="title-category">Produtos vistos</p>
        <ul class="list-of-products">
            {capture}{$cycles|@shuffle}{/capture}

            {foreach from=$cycles item=cycle}

            {assign var="foto" value="{$cycle['codigo']}"}
            {assign var="extensao" value="{$cycle['path']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            {assign var="max" value="2"}

            {if $cycle@iteration > $max}
              {break}
            {/if}
            <li class="product-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($cycle['nome'])},"idcycle"=>{$cycle['codigo']}], 'cycledetalhe', TRUE)}" class="thumb">
                  {if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
                      <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="{$cycle['nome']}">
                          <!--imagem padrão-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                          <!--imagem para 768px-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                          <!--imagem para 480px-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <!--imagem para 320px-->
                          <span data-src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                          <!--imagem para javascript desativado-->
                          <noscript>
                            <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$cycle['nome']}">
                          </noscript>
                      </span>
                  {else}
                    <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="{$cycle['nome']}">
                          <!--imagem padrão-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                          <!--imagem para 768px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                          <!--imagem para 480px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <!--imagem para 320px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                          <!--imagem para javascript desativado-->
                          <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$cycle['nome']}">
                          </noscript>
                      </span>
                  {/if}
                </a>
                <p class="product-title">
                    <a href="{$this->url(["titulo"=>{$this->createslug($cycle['nome'])},"idcycle"=>{$cycle['codigo']}], 'cycledetalhe', TRUE)}">{$cycle['nome']}</a>
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

            <li class="product-item last">
                <a href="{$this->url(["titulo"=>{$this->createslug($_produto_dia->DS_PRODUTO_PRRC)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" class="thumb">
                  {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$_produto_dia->DS_PRODUTO_PRRC}">
                        <!--imagem para padrão-->
                        <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}"></span>
                        <!--imagem para 768px-->
                        <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>164, 'altura'=>182, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                        <!--imagem para 480px-->
                        <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                        <!--imagem para 320px-->
                        <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                        <!--imagem para javascript desativado-->
                        <noscript>
                          <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" alt="{$_produto_dia->DS_PRODUTO_PRRC}">
                        </noscript>
                    </span>
                    {else}
                     <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="{$_produto_dia->DS_PRODUTO_PRRC}">
                          <!--imagem padrão-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                          <!--imagem para 768px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                          <!--imagem para 480px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                          <!--imagem para 320px-->
                          <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                          <!--imagem para javascript desativado-->
                          <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$_produto_dia->DS_PRODUTO_PRRC}">
                          </noscript>
                      </span>
                    {/if}
                </a>
                <p class="product-title">
                    <a href="{$this->url(["titulo"=>{$this->createslug($_produto_dia->DS_PRODUTO_PRRC)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">{$_produto_dia->DS_PRODUTO_PRRC}</a>
                </p>
                <p class="product-price">
                    {if $_produto_dia->VL_PROMO_PRRC != 0}
                        <a href="{$this->url(["titulo"=>{$this->createslug($_produto_dia->DS_PRODUTO_PRRC)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">R$ {$_produto_dia->VL_PROMO_PRRC|number_format:2:",":"."}</a>
                    {else}
                        <a href="{$this->url(["titulo"=>{$this->createslug($_produto_dia->DS_PRODUTO_PRRC)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">R$ {$_produto_dia->VL_PRODUTO_PRRC|number_format:2:",":"."}</a>
                    {/if}
                </p>
            </li>
        </ul>
    </div>
</div>

