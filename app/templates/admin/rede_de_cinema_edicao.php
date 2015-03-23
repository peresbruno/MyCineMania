<div class="espaco-topo">
<script src="/js/participante_edicao.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <form role="form" id="participante_edicao">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Editando Cadastro de Rede de Cinema</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rede" class="control-label">Nome da Rede: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="rede" placeholder="Nome da Rede">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="responsavel" class="control-label">Responsavel: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="responsavel" placeholder="Responsavel" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="endereco" class="control-label">Endereço: <?= OBG ?></label>
                            <textarea class="form-control" required id="endereco" placeholder="Endereço" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cnpj" class="control-label">CNPJ: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="cnpj" placeholder="CNPJ">
                        </div>
                        <div class="form-group">
                            <label for="data_cadastro" class="control-label">Data de Cadastro:</label>
                            <input type="datetime" readonly class="form-control" id="data_cadastro" placeholder="Data de Cadastro">
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
                    <p><a class="btn btn-default" data-toggle="modal" data-target="#alterar_senha">Alterar Senha do Responsável</a></p>


                    <div class="modal fade" id="alterar_senha" tabindex="-1" role="dialog" aria-labelledby="alterar_senhaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="alterar_senhaLabel">Alterar Senha do Responsável</h4>
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

                    <p><a class="btn btn-default" href="mailto:cassioherculano@gmail.com">Enviar mensagem de e-mail para o responsável</a></p>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->
</div>
