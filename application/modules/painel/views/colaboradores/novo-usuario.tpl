
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                <div class="fw lt" id="top-menu">
                    <button class="rt bs fs13 top-btns" id="logout-btn"></button>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Log Out</a>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Ir para o site</a>
                </div>
                <div class="fw lt fs12 right-crumb">
                    Usuário &gt; Configuração
                </div>
                <div id="header-section-name">
                    Cadastrar Novo Usuário
                </div>
            </header>
            <div class="lt bs posr container-contents" id="config-body">
                <div class="container">
                    <div class="hw lt">
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="login">Login</label>
                                <input  class="bs reverb-input-1" type="text" id="login" name="login">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-3">
                                <label class="reverb-label-1" for="fone">Fone</label>
                                <input  class="bs reverb-input-1" type="text" id="fone" name="fone">
                            </div>
                            <div class="reverb-fields reverb-field-8 ">
                                <label class="reverb-label-1" for="email">E-mail</label>
                                <input  class="bs reverb-input-1" type="text" id="email" name="email">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-9">
                                <label class="reverb-label-1" for="password">Senha</label>
                                <input  class="bs reverb-input-1" type="text" id="password" name="password">
                            </div>
                            <div class="reverb-fields reverb-field-9">
                                <label class="reverb-label-1" for="confirma_senha">Confirme a senha</label>
                                <input  class="bs reverb-input-1" type="text" id="confirma_senha" name="confirma_senha">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <label class="reverb-label-1" for="confirma_senha">Permissões(selecione para liberar)</label>
                            <ul class="posr wrap-permissions-items nm np">
                                {for $i=0 to 10}
                                    <li class="permission-items posr bs fw lt nl">
                                        <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                            <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                            <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                        </div>
                                        <label class="bs permission-labels fs13" for="checkbox-{$i}">ITEM{$a}</label>
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

                    <div class="hw rt">
                    </div>
                </div>
            </div>
        </div>