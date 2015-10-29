<!-- ----------------------------------------- CONTEÚDO ----------------------------------------- -->
<div class="main-content">
    <div class="row">
        <div class="col-md-6">
            <div class="col-sm-5 clear-pl">
                <select name="test" class="selectboxit" data-native="true" data-text="Opções em Lote">
                    <option value="1">Desativar Usuários</option>
                    <option value="2">Deletar Usuários</option>
                </select>
            </div>

            <button type="button" class="btn btn-confirm btn-icon icon-left">
                Aplicar nos itens selecionados
                <i class="entypo-check"></i>
            </button>
        </div>

        <div class="col-md-6 clear-pr">
            <div class="col-md-8 input-group input-group-space pull-right">
                <input type="text" class="form-control" placeholder="Buscar">
                <span class="input-group-btn">
                    <button class="btn btn-confirm" type="button">Buscar</button>
                </span>
            </div>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-md-12">
            <table class="table datatable dataTable datatable-custom" id="table-base"> <!--O ID da table é utilizado posteriormente no script-->
                <thead>
                    <tr>
                        <th>
                            <div class="checkbox-custom">
                                <input type="checkbox">
                                <label></label>
                            </div>
                        </th>
                        <th>#</th>
                        <th>Perfil</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Opções</th>
                        <th>Vizualizar</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    {foreach from=$usuarios item=usuario}
                        <tr>
                            <td>
                                <div class="checkbox-custom">
                                    <input type="checkbox" name="idusuario" value="{$usuario->idusuario}">
                                    <label></label>
                                </div>
                            </td>

                            <td>
                                {$usuario->idusuario}
                            </td>
                            <td>
                                {$usuario->descricao_perfil}
                            </td>

                            <td>
                                {$usuario->nome_usuario}
                            </td>

                            <td>
                                {$usuario->email}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white btn-icon" data-toggle="dropdown">
                                        Opções
                                        <i class="entypo-down-open-mini"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right dropdown-custom" role="menu">
                                        <li>
                                            <a class="text-right" href="#">
                                                <i class="pull-left entypo-cancel"></i>
                                                Alterar estoque
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-right" href="#">
                                                <i class="pull-left entypo-picture"></i>
                                                Imagens do produto
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-right" href="#">
                                                <i class="pull-left fa fa-shopping-cart"></i>
                                                Compradores
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-right" href="#">
                                                <i class="pull-left entypo-cancel"></i>
                                                Mover para Classics
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-right" href="#">
                                                <i class="pull-left entypo-eye"></i>
                                                Visualizar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-right" href="#">
                                                <i class="pull-left fa fa-edit"></i>
                                                Editar produto
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-right" href="#">
                                                <i class="pull-left entypo-check"></i>
                                                Ativar este produto
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-right cancel delete-row" href="#" data-text-confirm="Tem certeza que deseja excluir o item <b>[nome do item]</b> permanentemente?">
                                                <i class="pull-left entypo-cancel"></i>
                                                Excluir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                            <td>
                                <a href="#" class="entypo-eye" data-toggle="tooltip" data-placament="top" data-original-title="Visualizar"></a>
                            </td>
                        </tr>
                    {/foreach}

                   
                </tbody>
            </table>

            <script type="text/javascript">
                jQuery(window).load(function(){
                    formatDataTable("#table-base", 10);
                });

            </script>
        </div>
    </div>
</div>
<!-- ----------------------------------------- FIM DO CONTEÚDO ----------------------------------------- -->


<!-- -----------------------------------------  ALERTAS/MODAIS ----------------------------------------- -->

<!-- deletar dados -->
<div class="modal custom fade" id="modal-delete-data">
    <div class="modal-dialog" style="max-width: 495px; width: 100%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <h3>Atenção, Caio Arias</h3>

                <br />

                <p class="modify-text">
                    Você tem certeza que deseja excluir o item <b><u>The Kooks 2 - FEM</u></b> permanentemente?
                </p>

                <br />

                <p>
                    Essa ação não poderá ser desfeita.
                </p>
            </div>

            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- -----------------------------------------  FIM DE ALERTAS/MODAIS ----------------------------------------- -->