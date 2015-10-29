
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                <div class="fw lt" id="top-menu">
                    <button class="rt bs fs13 top-btns" id="logout-btn"></button>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Log Out</a>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Ir para o site</a>
                </div>
                <div class="fw lt fs12 right-crumb">
                    Clientes &gt; Histórico de indicações
                </div>
                <div id="header-section-name">
                    Fotos cadastradas
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <form action="">

                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field rt bs">
                        </form>
                    </div>
                    <div class="container sortable-container">
                        <ul class="sortable-collection sortable-fotos nm np" id="ordenar-fotos">
                        {for $i=0 to 11}
                            <li class="sortable-items lt nl">
                                <div class="img-wrap">
                                    <img src="https://api.fnkr.net/testimg/200x220/00CED1/FFF/?text=img+placeholder">
                                </div>
                                <div class="sortable-txt bs">
                                    <div class="sortable-name">
                                        Lorem ipsum dolor {$i}
                                    </div>
                                    <div class="sortable-cm-count">
                                        10 Comentários
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