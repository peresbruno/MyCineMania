<div class="espaco-topo">
<script src="/js/participante_edicao.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <form role="form" id="participante_edicao">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Editando Cadastro de Participante</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome" class="control-label">Nome: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="nome" placeholder="Nome">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sobrenome" class="control-label">Sobrenome: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="sobrenome" placeholder="Sobrenome">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario" class="control-label">Usuário: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="usuario" placeholder="Usuário">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cpf" class="control-label">CPF: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="cpf" placeholder="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Digite o CPF no formato nnn.nnn.nnn-nn">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mail: <?= OBG ?></label>
                            <input type="email" class="form-control" required id="email" placeholder="E-mail">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_cadastro" class="control-label">Data de Cadastro:</label>
                            <input type="datetime" readonly class="form-control" id="data_cadastro" placeholder="Data de Cadastro">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_vencimento" class="control-label">Data de Vencimento:</label>
                            <input type="datetime" class="form-control" id="data_vencimento" placeholder="Data de Vencimento">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="regulamento" class="control-label">Interesses:</label>
                            <div>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">
                                    Suspense
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">
                                    Terror
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">
                                    Ação
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">
                                    Comédia
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">
                                    Drama
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">
                                    Animação
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="">
                                    Ficção científica
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <h2>Opções extras</h2>
                    <p><a class="btn btn-default" data-toggle="modal" data-target="#alterar_senha">Alterar Senha</a></p>


                    <div class="modal fade" id="alterar_senha" tabindex="-1" role="dialog" aria-labelledby="alterar_senhaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="alterar_senhaLabel">Alterar Senha</h4>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="senha">Senha: <?= OBG ?></label>
                                            <input type="password" class="form-control" required id="senha" placeholder="Senha">
                                        </div>
                                        <div class="form-group">
                                            <label for="senha_confirmacao">Repetir Senha: <?= OBG ?></label>
                                            <input type="password" class="form-control" required id="senha_confirmacao" placeholder="Repetir Senha">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Alterar senha</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p><a class="btn btn-default" href="mailto:cassioherculano@gmail.com">Enviar mensagem de e-mail</a></p>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->
</div>
