
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site &gt; Banners
                </div>
                <div id="header-section-name">
                    Banners Cadastrados
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <form action="" method="post">
                            <a href="{$basePath}/painel/site/novo-banner" class="head-cells fs13 cells nap bs grn-btn green-btn-3 plus-wh">Adicionar novo Banner</a>
                            <!-- <a href="{$basePath}/painel/site/novo-local-banner" class="head-cells fs13 cells nap bs grn-btn green-btn-3 plus-wh">Adicionar novo Local</a> -->
                        </form>
                    </div>
                    <table class="fw painel-tables" id="banners-table" cellpadding="0" border="0" align="center" cellspacing="0">
                        <thead class="tables-heads banners-head">
                            <tr>
                                <th class="th-cells head-name">NOME</th>
                                <th class="th-cells head-status">STATUS</th>
                                <th class="th-cells head-action">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="tables-body banners-body">
                            {foreach from=$dadosBannerslocal item=local key=i}
                                <tr class="collapse-open open-collapse-{$i}">
                                    <td colspan="4">
                                        <div class="collapse-block-title">
                                            {$local->DS_LOCAL_BLRC}
                                        </div>
                                    </td>
                                </tr>
                                {foreach from=$local->findDependentRowset('Default_Model_Banners') item=banner}
                                    <tr class="collapsed collapsed-{$i} {if $banner->ST_BANNER_BARC == 'A'}green{else}orange{/if}">
                                        <td class="tb-cells body-name">{$banner->DS_DESCRICAO_BARC}</td>
                                        <td class="tb-cells body-status">{if $banner->ST_BANNER_BARC == 'A'}ATIVO{else}INATIVO{/if}</td>
                                        <td class="tb-cells posr body-action has-pop-over">
                                            <div class="pop-over lt">
                                                <span class="open-pop-over">Opções</span>
                                                <div class="content-popover popover-3">
                                                    <ul class="nm np  fs13 pop-over-list-1">
                                                        <li class="nl bs posr popover-items popover-items-1">
                                                            <span class="ico ico-dd-edi"></span>
                                                            Editar Banner
                                                            <a class="f-anc" href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'editar-banner', 'id' => $banner->NR_SEQ_BANNER_BARC], null, true)}"></a>
                                                        </li>
                                                        <li class="nl bs posr popover-items popover-items-1">
                                                            <span class="ico ico-dd-vis"></span>
                                                            Ver Banner
                                                            {assign var=fotoCompleta value="{$banner->NR_SEQ_BANNER_BARC}.{$banner->DS_EXT_BARC}"}
                                                            <a class="f-anc" target="_blank" href="{$this->Url(['tipo'=>"banners", 'crop'=>1, 'largura'=>0, 'altura'=>0, 'imagem'=>$fotoCompleta],"imagem", TRUE)}"></a>
                                                        </li>
                                                        <li class="nl bs posr popover-items popover-items-1">
                                                            <span class="ico ico-dd-pow"></span>
                                                            {if $banner->ST_BANNER_BARC == 'A'}
                                                                Desativar
                                                                <a class="f-anc" href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'desativar-banner', 'id' => $banner->NR_SEQ_BANNER_BARC], null, true)}"></a>
                                                            {else}
                                                                Ativar
                                                                <a class="f-anc" href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'ativar-banner', 'id' => $banner->NR_SEQ_BANNER_BARC], null, true)}"></a>
                                                            {/if}
                                                        </li>
                                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                                            <span class="ico ico-dd-exc"></span>
                                                            Excluir
                                                            <a class="f-anc" href="#"></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="lt row-btns">
                                                <a href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'editar-banner', 'id' => $banner->NR_SEQ_BANNER_BARC], null, true)}" class="row-btns-el btn-banner-edit"></a>
                                                <a href="{$this->Url(['tipo'=>"banners", 'crop'=>1, 'largura'=>0, 'altura'=>0, 'imagem'=>$fotoCompleta],"imagem", TRUE)}" target="_blank" class="row-btns-el btn-banner-prev"></a>
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                            {/foreach}
                        </tbody>
                    </div>
                </div>
            </div>
        </div>