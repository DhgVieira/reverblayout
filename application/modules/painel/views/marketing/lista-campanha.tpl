
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Marketing > Campanha
        </div>
        <div id="header-section-name">
            Campanha
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <a href="{$this->url(['module' => 'painel', 'controller' => 'marketing', 'action' => 'cadastrar-campanha'], null, true)}" class="head-cells fs13 cells nap bs grn-btn green-btn-3">NOVA CAMPANHA</a>
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="termo" value="{$busca}">
                </form>
            </div>
            <table class="fw" id="indicacao-table">
                <thead class="table-heads indica-head">
                <tr>
                    <th class="th-cells head-chck"></th>
                    <th class="th-cells head-newsletter tlt">Campanha</th>
                    <th class="th-cells head-newsletter ">Parâmetro</th>
                    <th class="th-cells head-newsletter">Vendas concretizadas</th>
                    <th class="th-cells head-newsletter">Total</th>
                    <th class="th-cells head-newsletter">Últimos 7 dias</th>
                    <th class="th-cells head-newsletter">Total</th>
                    <th class="th-cells head-newsletter">Últimos 30 dias</th>
                    <th class="th-cells head-newsletter">Total</th>
                    <th class="th-cells head-action">OPÇÕES</th>
                </tr>
                </thead>
                <tbody class="table-body indica-body">
                <tr>
                    {foreach from=$dadosCampanha item=campanha}
                    <td class="tb-cells posr body-chck">

                    </td>
                    <td class="tb-cells body-newsletter tlt">{$campanha->DS_CAMPANHA_CARC}</td>
                    <td class="tb-cells body-newsletter">?cp={$campanha->NR_SEQ_CAMPANHA_CARC}</td>
                    <td class="tb-cells body-newsletter">{$campanha->total_concretizadas}</td>
                    <td class="tb-cells body-newsletter">R$ {$campanha->valor_concretizadas|number_format:2:",":"."}</td>
                    <td class="tb-cells body-newsletter">{$campanha->total_7_concretizadas}</td>
                    <td class="tb-cells body-newsletter">R$ {$campanha->valor_7_concretizadas|number_format:2:",":"."}</td>
                    <td class="tb-cells body-newsletter">{$campanha->total_30_concretizadas}</td>
                    <td class="tb-cells body-newsletter">R$ {$campanha->valor_30_concretizadas|number_format:2:",":"."}</td>
                    <td class="tb-cells posr body-action has-pop-over ">
                        <ul class="indica-actions bs">
                            <li class="indica-items">
                                <a title="Editar" class="indica-icos indica-edit" href="{$this->url(['module' => 'painel', 'controller' => 'marketing', 'action' => 'editar-campanha', 'id' => $campanha->NR_SEQ_CAMPANHA_CARC], null, true)}"></a>
                            </li>
                            <li class="indica-items">
                                <a title="Excluir" class="indica-icos indica-power excluir-campanha" href="{$this->url(['module' => 'painel', 'controller' => 'marketing', 'action' => 'apagar-campanha', 'id' => $campanha->NR_SEQ_CAMPANHA_CARC], null, true)}"></a>
                            </li>
                        </ul>
                    </td>
                </tr>
                {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosCampanha, NULL, 'paginator.tpl')}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.excluir-campanha').on('click', function() {
            if(confirm('Deseja realmente excluir a campanha?')){
                return true;
            }else{
                return false;
            }
        });
    });
</script>