        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Banners > Locais-
                </div>
                <div id="header-section-name">
                    Ponto

                    <div class="header-helpers">
                        <a href="#" class="header-helpers-actions" id="new-action"></a>
                        <a href="#" class="header-helpers-actions" id="email-action"></a>
                        <a href="#" class="header-helpers-actions" id="print-action"></a>
                    </div>
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <form action="">
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field min rt bs">
                        </form>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-name">COLABORADOR</th>
                                <th class="th-cells head-point huge-blank-cell"></th>
                            </tr>
                        </thead>
                        <tbody class="table-body indica-body">
                            {for $i=0 to 9}
                            <tr style="border-bottom: 1px solid #ebebeb">
                                <td class="tb-cells body-name">DSADASDS</td>
                                <td class="tb-cells body-point huge-blank-cell">
                                    <ul class="pontos-lists nm np">
                                        <li class="pontos-items posr etc-ponto rt">Outras</li>
                                        <li class="pontos-items rt">NOV 13</li>
                                        <li class="pontos-items rt">OUT 13</li>
                                        <li class="pontos-items rt">SET 13</li>
                                        <li class="pontos-items rt">AGO 13</li>
                                        <li class="pontos-items rt">JUL 13</li>
                                    </ul>
                                </td>
                            </tr>
                            {/for}
                        </tbody>
                    </div>
                </div>
            </div>
        </div>