<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Site > Financeiros > Fornecedores
        </div>
        <div id="header-section-name">
            Fornecedores
        </div>
        <div id="header-section-name">
            {$pageName}
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <a href="{$this->url(['module' => 'painel', 'controller' => 'financeiro', 'action' => 'novo-fornecedor'], null, true)}" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-wh rl">Adicionar novo fornecedor</a>
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field min rt bs" name="busca" value="{$termo}">
                </form>
            </div>
            <table class="fw" id="indicacao-table">
                <thead class="table-heads indica-head">
                    <tr>
                        <th class="th-cells head-nome">NOME</th>
                        <th class="th-cells head-fone">FONE</th>
                        <th class="th-cells head-cont">CONTATO</th>
                        <th class="th-cells head-emai">E-MAIL</th>
                        <th class="th-cells head-action last-col">OPÇÕES</th>
                    </tr>
                </thead>
                <tbody class="table-body indica-body">
                    {foreach from=$dadosFornecedor item=fornecedor}
                        <tr>
                            <td class="tb-cells body-nome">{$fornecedor->DS_FANTASIA_FORC}</td>
                            <td class="tb-cells body-fone">{$fornecedor->DS_TEL_FORC}</td>
                            <td class="tb-cells body-cont">{$fornecedor->DS_CONTATO_FORC}</td>
                            <td class="tb-cells body-emai">{$fornecedor->DS_EMAIL_FORC}</td>
                            <td class="tb-cells posr body-action has-pop-over last-col">
                                <ul class="indica-actions bs">
                                    <li class="indica-items">
                                        <a class="indica-icos indica-eye" href="{$this->url(['module' => 'painel', 'controller' => 'financeiro', 'action' => 'editar-fornecedor', 'id' => {$fornecedor->NR_SEQ_FORNECEDOR_FORC}], null, true)}"></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </div>
        </div>
    </div>
</div>