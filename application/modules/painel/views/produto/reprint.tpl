
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                <div class="fw lt" id="top-menu">
                    <button class="rt bs fs13 top-btns" id="logout-btn"></button>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Log Out</a>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Ir para o site</a>
                </div>
                <div class="fw lt fs12 right-crumb">
                    Home &gt; Produtos
                </div>
                <div id="header-section-name">
                    Reprint

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
                            <div class="t-head-options bs fs11 select-2 lt">
                                <select class="select bs" id="tipo" name="tipo">
                                    <option value="" selected disabled>Selecione o tipo</option>
                                    <option value="1">Opção 1</option>
                                    <option value="2">Opção 2</option>
                                </select>
                                <span class="select-value">Opção</span>
                            </div>
                            <div class="t-head-options bs fs11 select-2 lt">
                                <select class="select bs" id="tipo" name="tipo">
                                    <option value="" selected disabled>Categoria</option>
                                    <option value="1">Categoria 1</option>
                                    <option value="2">Categoria 2</option>
                                </select>
                                <span class="select-value">Categoria</span>
                            </div>
                            <button class="head-cells fs13 cells nap bs grn-btn green-btn-1 plus-check" id="apply-items">Aplicar nos items selecionados</button>
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field rt bs" name="termo" value="{$busca}">
                        </form>
                    </div>
                    <div class="container reprint-container">
                        <ul class="reprint-collection reprint-fotos nm np">
                        {for $i=0 to 11}
                            <li class="reprint-items lt nl posr">
                                <div class="img-wrap">
                                    
                                </div>
                                <input class="posa styled-reprint-checkbox-element" type="checkbox" id="check-{$i}">
                                <div class="reprint-txt bs">
                                    <div class="reprint-name fs16"> Radiohead OK Com... </div>
                                    <div class="reprint-price fs13"> R$ 23.751,00 </div>
                                    <div class="reprint-text-bottom">
                                        <div class="reprint-fav-count posr bs lt">
                                            <span class="corassaum fs13">133</span>
                                            <div class="posa fav-details-block bs">
                                                <div class="lt fav-details-genres fav-details-f">
                                                    <table class="reprint-mini-tables">
                                                        <tr>
                                                            <td colspan="3">FEMININAS</td>
                                                        </tr>
                                                        <tr>
                                                            <td>PP</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>P</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>M</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>G</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>GG</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>XGG</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="rt fav-details-genres fav-details-m">
                                                    <table class="reprint-mini-tables">
                                                        <tr>
                                                            <td colspan="3">MASCULINAS</td>
                                                        </tr>
                                                        <tr>
                                                            <td>PP</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>P</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>M</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>G</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>GG</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                        <tr>
                                                            <td>XGG</td>
                                                            <td class="huge-blank-cell">&nbsp;</td>
                                                            <td> 20</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="reprint-checkbox posr rt" for="check-{$i}"></labe>
                                    </div>
                                </div>
                            </li>
                        {/for}
                        </ul>
                    </div>
                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                        <button class="rt edit-button reverb-btns-1"> Editar  <span class="ico"></span> </button>
                    </div>
                </div>
            </div>
        </div>
        {literal}
        <script>

        </script>
        {/literal}