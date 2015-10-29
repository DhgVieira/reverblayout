<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Home &gt; Clientes
        </div>
        <div id="header-section-name">
            EDITAR CLIENTE
        </div>
    </header>
    <div id="banner-form">
        <div class="container">
            <form method="post">
                <div class="hw lt" style="border-right: 1px solid #d9dcdc;">
                    <h2>Dados Cadastrais</h2>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-8">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_NOME_CASO">Nome</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_NOME_CASO" name="DS_NOME_CASO" value="{$dadosCliente->DS_NOME_CASO}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-8">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_EMAIL_CASO">Email</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_EMAIL_CASO" name="DS_EMAIL_CASO" value="{$dadosCliente->DS_EMAIL_CASO}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_ENDERECO_CASO">Endereço</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_ENDERECO_CASO" name="DS_ENDERECO_CASO" value="{$dadosCliente->DS_ENDERECO_CASO}" required>
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_NUMERO_CASO">Número</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_NUMERO_CASO" name="DS_NUMERO_CASO" value="{$dadosCliente->DS_NUMERO_CASO}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_COMPLEMENTO_CASO">Complemento</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_COMPLEMENTO_CASO" name="DS_COMPLEMENTO_CASO" value="{$dadosCliente->DS_COMPLEMENTO_CASO}">
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_BAIRRO_CASO">Bairro</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_BAIRRO_CASO" name="DS_BAIRRO_CASO" value="{$dadosCliente->DS_BAIRRO_CASO}">
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_CIDADE_CASO">Cidade</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_CIDADE_CASO" name="DS_CIDADE_CASO" value="{$dadosCliente->DS_CIDADE_CASO}" required>
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_UF_CASO">Estado</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_UF_CASO" name="DS_UF_CASO" value="{$dadosCliente->DS_UF_CASO}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_CEP_CASO">Cep</label>
                                <input  class="bs reverb-input-1 cep" type="text" id="DS_CEP_CASO" name="DS_CEP_CASO" value="{$dadosCliente->DS_CEP_CASO}" required>
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DT_NASCIMENTO_CASO">Data de Nascimento</label>
                                <input  class="bs reverb-input-1" type="text" id="DT_NASCIMENTO_CASO" name="DT_NASCIMENTO_CASO" value="{$dadosCliente->DT_NASCIMENTO_CASO|date_format:"%d/%m/%Y"}"  required>
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_CPFCNPJ_CASO">CPF/CNPJ</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_CPFCNPJ_CASO" name="DS_CPFCNPJ_CASO" value="{$dadosCliente->DS_CPFCNPJ_CASO}" required>
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_TIPO_CASO">Tipo</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_TIPO_CASO" name="DS_TIPO_CASO" value="{$dadosCliente->DS_TIPO_CASO}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_DDDFONE_CASO">DDD</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_DDDFONE_CASO" name="DS_DDDFONE_CASO" value="{$dadosCliente->DS_DDDFONE_CASO}">
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_FONE_CASO">Telefone</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_FONE_CASO" name="DS_FONE_CASO" value="{$dadosCliente->DS_FONE_CASO}">
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_DDDCEL_CASO">DDD</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_DDDCEL_CASO" name="DS_DDDCEL_CASO" value="{$dadosCliente->DS_DDDCEL_CASO}">
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_CELULAR_CASO">Celular</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_CELULAR_CASO" name="DS_CELULAR_CASO" value="{$dadosCliente->DS_CELULAR_CASO}">
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-8">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_SENHA_CASO">Senha</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_SENHA_CASO" name="DS_SENHA_CASO" value="{$dadosCliente->DS_SENHA_CASO}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_TWITTER_CACH">Twitter</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_TWITTER_CACH" name="DS_TWITTER_CACH" value="{$dadosCliente->DS_TWITTER_CACH}">
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_FACEBOOK_CACH">Facebook</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_FACEBOOK_CACH" name="DS_FACEBOOK_CACH" value="{$dadosCliente->DS_FACEBOOK_CACH}">
                            </div>
                        </div>
                    </div>

                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Salvar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    </div>
                </div>

                {* Endereços *}
                <div class="hw rt">
                    <h2>Endereços</h2>
                    {foreach from=$dadosEnderecos item=endereco}
                        <input type="hidden" name="NR_SEQ_ENDERECO_ENRC[]" value="{$endereco->NR_SEQ_ENDERECO_ENRC}" />
                        <div class="row posr fw lt" style="margin-top: 10px">
                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_NOME_CASO">Nome</label>
                                    <input  class="bs reverb-input-1" type="text" name="DS_DESTINATARIO_ENRC[]" value="{$endereco->DS_DESTINATARIO_ENRC}" required>
                                </div>
                            </div>

                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_CEP_CASO">Cep</label>
                                    <input  class="bs reverb-input-1 cep" type="text" name="DS_CEP_ENRC[]" value="{$endereco->DS_CEP_ENRC}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_ENDERECO_CASO">Endereço</label>
                                    <input  class="bs reverb-input-1" type="text" name="DS_ENDERECO_ENRC[]" value="{$endereco->DS_ENDERECO_ENRC}" required>
                                </div>
                            </div>

                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_NUMERO_CASO">Número</label>
                                    <input  class="bs reverb-input-1" type="text" name="DS_NUMERO_ENRC[]" value="{$endereco->DS_NUMERO_ENRC}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_COMPLEMENTO_CASO">Complemento</label>
                                    <input  class="bs reverb-input-1" type="text" name="DS_COMPLEMENTO_ENRC[]" value="{$endereco->DS_COMPLEMENTO_ENRC}">
                                </div>
                            </div>

                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_BAIRRO_CASO">Bairro</label>
                                    <input  class="bs reverb-input-1" type="text" name="DS_BAIRRO_ENRC[]" value="{$endereco->DS_BAIRRO_ENRC}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_CIDADE_CASO">Cidade</label>
                                    <input  class="bs reverb-input-1" type="text" name="DS_CIDADE_ENRC[]" value="{$endereco->DS_CIDADE_ENRC}" required>
                                </div>
                            </div>

                            <div class="reverb-fields reverb-field-9">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="DS_UF_CASO">Estado</label>
                                    <input  class="bs reverb-input-1" type="text" name="DS_UF_ENRC[]" value="{$endereco->DS_UF_ENRC}" required>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%; height: 5px; border-bottom: 1px solid #d9dcdc; clear: both; padding: 0 0 10px 0;"></div>
                    {/foreach}
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#DT_NASCIMENTO_CASO').mask('99/99/9999');
        $('.cep').mask('99.999-999');
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/cliente';
            //history.go(-1);
        });
    });
</script>
